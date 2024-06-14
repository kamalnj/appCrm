<?php
session_start();
if (!in_array($_SESSION['role'], ['super_admin', 'order_admin', 'ftd_admin'])) {
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
        $update_query = "UPDATE orders SET " . implode(', ', $updated_fields) . " WHERE id={$_POST['order_id']}";
        mysqli_query($conn, $update_query);
            // Redirect or handle success message
            header("Location: manage_orders.php");
            exit();
    }
}

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
        input, textarea {
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
                    <input type="text" id="country" name="country" value="<?php echo $order['country']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
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
                    <label for="our_network_today" class="block">Our Network Today:</label>
                    <input type="text" id="our_network_today" name="our_network_today" value="<?php echo $order['our_network_today']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label for="approval" class="block">Approval:</label>
                    <select id="approval" name="approval" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="Yes" <?php if ($order['approval'] === 'Yes') echo 'selected'; ?>>Yes</option>
                        <option value="No" <?php if ($order['approval'] === 'No') echo 'selected'; ?>>No</option>
                        <option value="Waiting" <?php if ($order['approval'] === 'Waiting') echo 'selected'; ?>>Waiting</option>
                    </select>
                </div>
                <div>
                    <label for="type_order" class="block">Type of Order:</label>
                    <input type="text" id="type_order" name="type_order" value="<?php echo $order['type_order']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label for="brand_name" class="block">Brand Name:</label>
                    <input type="text" id="brand_name" name="brand_name" value="<?php echo $order['brand_name']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label for="capps" class="block">CAPPs:</label>
                    <input type="text" id="capps" name="capps" value="<?php echo $order['capps']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label for="ftds" class="block">FTDs:</label>
                    <input type="text" id="ftds" name="ftds" value="<?php echo $order['ftds']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
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
