<?php
session_start();
include('config.php');

if (!in_array($_SESSION['role'], ['super_admin', 'affiliate_manager', 'order_admin'])) {
    header("Location: dashboard.php");
    exit();
}
$current_manager_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_order'])) {
    $order_date = $_POST['order_date'];
    $country = $_POST['country'];
    $for_day = $_POST['for_day'];
    $work_hours = $_POST['work_hours'];
    $our_network_today = $_POST['our_network_today'];
    $approval = $_POST['approval'];
    $type_order = $_POST['type_order'];
    $brand_name = $_POST['brand_name'];
    $capps = $_POST['capps'];
    $ftds = $_POST['ftds'];

    $stmt = $conn->prepare("INSERT INTO orders (order_date, country, for_day, work_hours, our_network_today, approval, type_order, brand_name, capps, ftds, aff_manager_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $default_approval = "Waiting"; // Set the default approval value
    $stmt->bind_param("ssssssssiss", $order_date, $country, $for_day, $work_hours, $our_network_today, $default_approval, $type_order, $brand_name, $capps, $ftds, $current_manager_id);
    $stmt->execute();
    header("Location: manager_order.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_order'])) {
    $id = $_POST['order_id'];
    mysqli_query($conn, "DELETE FROM orders WHERE id='$id'");
    header("Location: manager_order.php");
    exit();
}

$brand_names_query = mysqli_query($conn, "SELECT DISTINCT brand_name FROM orders WHERE aff_manager_id='$current_manager_id'");
$brand_names = mysqli_fetch_all($brand_names_query, MYSQLI_ASSOC);

// Check if a brand name is selected
if (isset($_POST['search_brand']) && !empty($_POST['selected_brand'])) {
    $selected_brand = $_POST['selected_brand'];
    // Fetch orders based on the selected brand name
    $orders = mysqli_query($conn, "SELECT * FROM orders WHERE aff_manager_id='$current_manager_id' AND brand_name='$selected_brand'");
} else {
    // Fetch all orders if no brand name is selected
    $orders = mysqli_query($conn, "SELECT * FROM orders WHERE aff_manager_id='$current_manager_id'");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        button[name="update_order"] {
            margin-bottom: 5px;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <a href="dashboard.php"><button class="mt-4 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">Back To Dashboard</button></a> <br><br>
        <h1 class="text-2xl text-center mb-7 font-semibold ">Manage Orders</h1>
        <form method="post" class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="order_date" class="block">Order Date:</label>
                    <input type="date" id="order_date" name="order_date" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="country" class="block">Country:</label>
                    <input type="text" id="country" name="country" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="for_day" class="block">For Day:</label>
                    <input type="date" id="for_day" name="for_day" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="work_hours" class="block">Work Hours:</label>
                    <input type="text" id="work_hours" name="work_hours" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="our_network_today" class="block">Our Network Today:</label>
                    <input type="text" id="our_network_today" name="our_network_today" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="approval" class="block">Approval:</label>
                    <select id="approval" name="approval" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Waiting">Waiting</option>
                    </select>
                </div>
                <div>
                    <label for="type_order" class="block">Type Order:</label>
                    <input type="text" id="type_order" name="type_order" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="brand_name" class="block">Brand Name:</label>
                    <input type="text" id="brand_name" name="brand_name" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="capps" class="block">Capps:</label>
                    <input type="text" id="capps" name="capps" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="ftds" class="block">Ftds:</label>
                    <input type="number" id="ftds" name="ftds" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
            </div>
            <button type="submit" name="add_order" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg mt-4">Add Order</button>
        </form>
        
        <form method="post" class="mb-8">
            <div>
                <label for="selected_brand" class="block">Select Brand Name:</label>
                <div class="flex items-center">
                    <select id="selected_brand" name="selected_brand" class="border border-gray-300 rounded-md px-3 py-2 mr-2 w-full">
                        <option value="">All</option>
                        <?php foreach ($brand_names as $brand) { ?>
                            <option value="<?php echo $brand['brand_name']; ?>"><?php echo $brand['brand_name']; ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" name="search_brand" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">Search</button>
                </div>
            </div>
        </form>

        <h2 class="text-lg font-semibold mb-4">Order List</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Order Date</th>
                    <th class="border border-gray-300 px-4 py-2">Country</th>
                    <th class="border border-gray-300 px-4 py-2">For Day</th>
                    <th class="border border-gray-300 px-4 py-2">Work Hours</th>
                    <th class="border border-gray-300 px-4 py-2">Our Network Today</th>
                    <th class="border border-gray-300 px-4 py-2">Approval</th>
                    <th class="border border-gray-300 px-4 py-2">Type Order</th>
                    <th class="border border-gray-300 px-4 py-2">Brand Name</th>
                    <th class="border border-gray-300 px-4 py-2">Capps</th>
                    <th class="border border-gray-300 px-4 py-2">Ftds</th>
                    <th class="border border-gray-300 px-4 py-2">Affiliate Manager ID</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['id']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['order_date']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['country']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['for_day']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['work_hours']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['our_network_today']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['approval']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['type_order']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['brand_name']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['capps']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['ftds']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['aff_manager_id']; ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <form method="post" action="update_orders.php"> <!-- Point to the update page -->
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <button type="submit" name="update_order" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded-lg mr-2">Update</button>
                            </form>
                            <form method="post">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <button type="submit" name="delete_order" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-lg">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>