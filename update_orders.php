<?php
session_start();
if (!in_array($_SESSION['role'], ['super_admin', 'order_admin', 'ftd_admin', 'affiliate_manager'])) {
    header("Location: dashboard.php");
    exit();
}

include('config.php');

// Fetch Order Details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_order']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    $result = mysqli_query($conn, "SELECT * FROM orders WHERE id='$order_id'");
    $order = mysqli_fetch_assoc($result);
}

// Handle Update Operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_order_submit'])) {
    $order_id = $_POST['order_id'];
    $updated_fields = array();
    if (isset($_POST['order_date'])) {
        $order_date = $_POST['order_date'];
        $updated_fields[] = "order_date='$order_date'";
    }

    if (isset($_POST['country'])) {
        $country = $_POST['country'];
        $updated_fields[] = "country='$country'";
    }

    if (isset($_POST['for_day'])) {
        $for_day = $_POST['for_day'];
        $updated_fields[] = "for_day='$for_day'";
    }

    if (isset($_POST['work_hours'])) {
        $work_hours = $_POST['work_hours'];
        $updated_fields[] = "work_hours='$work_hours'";
    }

    if (isset($_POST['our_network_today'])) {
        $our_network_today = $_POST['our_network_today'];
        $updated_fields[] = "our_network_today='$our_network_today'";
    }

    if (isset($_POST['approval'])) {
        $approval = $_POST['approval'];
        $updated_fields[] = "approval='$approval'";
    }

    if (isset($_POST['type_order'])) {
        $type_order = $_POST['type_order'];
        $updated_fields[] = "type_order='$type_order'";
    }

    if (isset($_POST['brand_name'])) {
        $brand_name = $_POST['brand_name'];
        $updated_fields[] = "brand_name='$brand_name'";
    }

    if (isset($_POST['capps'])) {
        $capps = $_POST['capps'];
        $updated_fields[] = "capps='$capps'";
    }

    if (isset($_POST['ftds'])) {
        $ftds = $_POST['ftds'];
        $updated_fields[] = "ftds='$ftds'";
    }

    if (isset($_POST['aff_manager_id'])) {
        $aff_manager_id = $_POST['aff_manager_id'];
        $updated_fields[] = "aff_manager_id='$aff_manager_id'";
    }

    // Construct the update query with the updated fields
    if (!empty($updated_fields)) {
        $update_query = "UPDATE orders SET " . implode(', ', $updated_fields) . " WHERE id={$order_id}";
        mysqli_query($conn, $update_query);

        // If the order is approved, process it
        if (isset($_POST['approval']) && $_POST['approval'] === 'Yes') {
            processApprovedOrder($conn, $order_id);
        }

        if ($_SESSION['role'] == 'affiliate_manager') {
            header("Location: manager_order.php");
            exit();
        }

        // Redirect or handle success message
        header("Location: manage_orders.php");
        exit();
    }
}

function processApprovedOrder($conn, $orderID)
{
    // Fetch the approved order details
    $orderQuery = "SELECT * FROM orders WHERE id = $orderID AND approval = 'Yes'";
    $orderResult = mysqli_query($conn, $orderQuery);

    if (mysqli_num_rows($orderResult) > 0) {
        $orderRow = mysqli_fetch_assoc($orderResult);

        // Process fillers
        $cappsFtds = $orderRow['capps'] - $orderRow['ftds'];
        error_log("Calculated cappsFtds: $cappsFtds");

        $fillerQuery = "SELECT f.* FROM filler f
        JOIN orders o ON f.country LIKE CONCAT('%', o.country, '%')
        WHERE f.our_network IS NULL";
        $fillerResult = mysqli_query($conn, $fillerQuery);
        $numUnusedFillers = mysqli_num_rows($fillerResult);
        error_log("Number of unused fillers found: $numUnusedFillers");

        if ($numUnusedFillers >= $cappsFtds) {
            while (($fillerRow = mysqli_fetch_assoc($fillerResult)) && $cappsFtds > 0) {
                $fillerId = $fillerRow['id'];
                $updateFillerQuery = "UPDATE filler SET our_network = '{$orderRow['our_network_today']}', client_network = '{$orderRow['brand_name']}' WHERE id = $fillerId";
                mysqli_query($conn, $updateFillerQuery);
                error_log("Updated filler with ID: $fillerId");
                $cappsFtds--;

                $orderInjectionQuery = "INSERT INTO orders_injection (order_date, table_origin, f_id, first_name, last_name, email, phone_number, country, aff_manager_id, for_day, work_hours, our_network_today, client_network_today, broker_today) VALUES (
                    '{$orderRow['order_date']}', 
                    'filler', 
                    $fillerId, 
                    '{$fillerRow['first_name']}', 
                    '{$fillerRow['last_name']}', 
                    '{$fillerRow['email']}', 
                    '{$fillerRow['phone_number']}', 
                    '{$orderRow['country']}', 
                    '{$orderRow['aff_manager_id']}', 
                    '{$orderRow['for_day']}', 
                    '{$orderRow['work_hours']}', 
                    '{$orderRow['our_network_today']}', 
                    '{$orderRow['brand_name']}', 
                    '{$orderRow['broker_today']}')";
                mysqli_query($conn, $orderInjectionQuery);
                error_log("Injected order for filler ID: $fillerId");
            }

            $brandTableQuery = "INSERT INTO brand_table (brand_name, aff_manager_id) VALUES ('{$orderRow['brand_name']}', '{$orderRow['aff_manager_id']}')";
            mysqli_query($conn, $brandTableQuery);
            error_log("Order for brand: {$orderRow['brand_name']} successfully processed and injected.");
        } else {
            error_log("Not enough unused fillers available for brand: {$orderRow['brand_name']}.");
        }

        // Process ftds
        $numFtdsToProcess = $orderRow['ftds'];
        while ($numFtdsToProcess > 0) {
            $ftdQuery = "SELECT f.fid FROM ftd f
            JOIN orders o ON f.country LIKE CONCAT('%', o.country, '%')
            WHERE f.our_network IS NULL
            LIMIT 1";
            $ftdResult = mysqli_query($conn, $ftdQuery);

            if (mysqli_num_rows($ftdResult) > 0) {
                $ftdRow = mysqli_fetch_assoc($ftdResult);
                $ftdId = $ftdRow['fid'];
                $updateFtdQuery = "UPDATE ftd SET our_network = '{$orderRow['our_network_today']}', client_network = '{$orderRow['brand_name']}' WHERE fid = $ftdId";
                mysqli_query($conn, $updateFtdQuery);
                $numFtdsToProcess--;
                error_log("Ftd with ID: $ftdId updated.");

                $orderInjectionQuery = "INSERT INTO orders_injection (order_date, table_origin, f_id, first_name, last_name, email, phone_number, country, aff_manager_id, for_day, work_hours, our_network_today, client_network_today, broker_today) VALUES (
                    '{$orderRow['order_date']}', 
                    'ftd', 
                    $ftdId, 
                    '{$ftdRow['first_name']}', 
                    '{$ftdRow['last_name']}', 
                    '{$ftdRow['email']}', 
                    '{$ftdRow['phone_number']}', 
                    '{$orderRow['country']}', 
                    '{$orderRow['aff_manager_id']}', 
                    '{$orderRow['for_day']}', 
                    '{$orderRow['work_hours']}', 
                    '{$orderRow['our_network_today']}', 
                    '{$orderRow['brand_name']}', 
                    '{$orderRow['broker_today']}')";
                mysqli_query($conn, $orderInjectionQuery);
                error_log("Injected order for ftd ID: $ftdId");
            } else {
                error_log("Not enough unused ftd available for brand: {$orderRow['brand_name']}.");
                break;
            }
        }

        error_log("Order for brand: {$orderRow['brand_name']} successfully processed and injected.");
    } else {
        error_log("No approved orders to process.");
    }
}
$brand_names_query = mysqli_query($conn, "SELECT DISTINCT name_brand FROM list_brand_name");
$name_brand = mysqli_fetch_all($brand_names_query, MYSQLI_ASSOC);

$type_orders_query = mysqli_query($conn, "SELECT DISTINCT name_type FROM list_type_order");
$type_orders = mysqli_fetch_all($type_orders_query, MYSQLI_ASSOC);

$network_names_query = mysqli_query($conn, "SELECT DISTINCT name_network FROM list_network");
$network_names = mysqli_fetch_all($network_names_query, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        button[name="update_order_submit"] {
            display: block;
        }

        input,
        textarea {
            width: 500px;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-lg font-semibold mb-4">Update Order</h1>
        <form method="post" class="space-y-4">
            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
            <div>
                <label for="order_date" class="block">Order Date:</label>
                <input type="text" id="order_date" name="order_date" value="<?php echo $order['order_date']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div>
                <label for="country" class="block">Country:</label>
                <select id="country" name="country" required class="border border-gray-300 rounded-md px-3 py-2 w-auto">
                    <option value="Australia" <?php if ($order['country'] == 'Australia') echo 'selected'; ?>>Australia</option>
                    <option value="Canada" <?php if ($order['country'] == 'Canada') echo 'selected'; ?>>Canada</option>
                    <option value="United Kingdom" <?php if ($order['country'] == 'United Kingdom') echo 'selected'; ?>>United Kingdom</option>
                    <option value="Sweden" <?php if ($order['country'] == 'Sweden') echo 'selected'; ?>>Sweden</option>
                    <option value="Spain" <?php if ($order['country'] == 'Spain') echo 'selected'; ?>>Spain</option>
                </select>
            </div>
            <div>
                <label for="for_day" class="block">For Day:</label>
                <input type="text" id="for_day" name="for_day" value="<?php echo $order['for_day']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div>
                <label for="work_hours" class="block">Work Hours:</label>
                <input type="text" id="work_hours" name="work_hours" value="<?php echo $order['work_hours']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div>
                <label for="network_name" class="block">Our network today:</label>
                <select id="network_name" name="our_network_today" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                    <?php foreach ($network_names as $network) : ?>
                        <option value="<?= $network['name_network'] ?>"><?= $network['name_network'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if ($_SESSION['role'] == 'affiliate_manager') : ?>
                <input type="hidden" name="approval" value="Waiting">
            <?php else : ?>
                <div>
                    <label for="approval" class="block">Approval:</label>
                    <select id="approval" name="approval" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="Yes" <?php if ($order['approval'] === 'Yes') echo 'selected'; ?>>Yes</option>
                        <option value="No" <?php if ($order['approval'] === 'No') echo 'selected'; ?>>No</option>
                        <option value="Waiting" <?php if ($order['approval'] === 'Waiting') echo 'selected'; ?>>Waiting</option>
                    </select>
                </div>
            <?php endif; ?>
            <div>
                <label for="type_order" class="block">Type Order:</label>
                <select id="type_order" name="type_order" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                    <?php foreach ($type_orders as $type_order) : ?>
                        <option value="<?= $type_order['name_type'] ?>"><?= $type_order['name_type'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="brand_name" class="block">Brand Name:</label>
                <select id="brand_name" name="brand_name" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                    <?php foreach ($name_brand as $brand) : ?>
                        <option value="<?= $brand['name_brand'] ?>"><?= $brand['name_brand'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="capps" class="block">CAPPs (5 to 1000):</label>
                <input type="number" id="capps" name="capps" value="<?php echo $order['capps']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" min="5" max="1000">
            </div>
            <div>
                <label for="ftds" class="block">FTDs (1 to 250):</label>
                <input type="number" id="ftds" name="ftds" value="<?php echo $order['ftds']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" min="1" max="250">
            </div>

            <div>
                <label for="aff_manager_id" class="block">Affiliate Manager ID:</label>
                <input type="text" id="aff_manager_id" name="aff_manager_id" value="<?php echo $order['aff_manager_id']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <button type="submit" name="update_order_submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Update Order</button>
        </form>
        <a href="manage_orders.php" class="block mt-4 text-blue-500">Cancel</a>
    </div>
</body>

</html>