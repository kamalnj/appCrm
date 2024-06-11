<?php
session_start();
include('config.php');

// Check user role and redirect if not authorized
if (!in_array($_SESSION['role'], ['super_admin', 'order_admin'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle Add Operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_order'])) {
    $order_date = $_POST['order_date'];
    $table_origin = $_POST['table_origin'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $country = $_POST['country'];
    $for_day = $_POST['for_day'];
    $work_hours = $_POST['work_hours'];
    $our_network_today = $_POST['our_network_today'];
    $client_network_today = $_POST['client_network_today'];
    $broker_today = $_POST['broker_today'];

    $stmt = $conn->prepare("INSERT INTO orders (order_date, table_origin, first_name, last_name, email, phone_number, country, for_day, work_hours, our_network_today, client_network_today, broker_today) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $order_date, $table_origin, $first_name, $last_name, $email, $phone_number, $country, $for_day, $work_hours, $our_network_today, $client_network_today, $broker_today);
    $stmt->execute();
    header("Location: manage_orders.php");
}

// Handle Update Operation


// Handle Delete Operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_order'])) {
    $id = $_POST['order_id'];
    mysqli_query($conn, "DELETE FROM orders WHERE id='$id'");
    header("Location: manage_orders.php");
}

// Fetch Orders
$orders = mysqli_query($conn, "SELECT * FROM orders");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <!-- Add any necessary styles or scripts here -->
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl text-center mb-7 font-semibold ">Manage Orders</h1>
        <form method="post" class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="order_date" class="block">Order Date:</label>
                    <input type="date" id="order_date" name="order_date" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="table_origin" class="block">Table Origin:</label>
                    <input type="text" id="table_origin" name="table_origin" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="first_name" class="block">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="last_name" class="block">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="email" class="block">Email:</label>
                    <input type="email" id="email" name="email" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="phone_number" class="block">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
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
                    <label for="client_network_today" class="block">Client Network Today:</label>
                    <input type="text" id="client_network_today" name="client_network_today" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label for="broker_today" class="block">Broker Today:</label>
                    <input type="text" id="broker_today" name="broker_today" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
            </div>
            <button type="submit" name="add_order" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg mt-4">Add Order</button>
        </form>
        <h2 class="text-lg font-semibold mb-4">Order List</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Order Date</th>
                    <th class="border border-gray-300 px-4 py-2">Table Origin</th>
                    <th class="border border-gray-300 px-4 py-2">First Name</th>
                    <th class="border border-gray-300 px-4 py-2">Last Name</th>
                    <th class="border border-gray-300 px-4 py-2">Email</th>
                    <th class="border border-gray-300 px-4 py-2">Phone Number</th>
                    <th class="border border-gray-300 px-4 py-2">Country</th>
                    <th class="border border-gray-300 px-4 py-2">For Day</th>
                    <th class="border border-gray-300 px-4 py-2">Work Hours</th>
                    <th class="border border-gray-300 px-4 py-2">Our Network Today</th>
                    <th class="border border-gray-300 px-4 py-2">Client Network Today</th>
                    <th class="border border-gray-300 px-4 py-2">Broker Today</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['id']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['order_date']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['table_origin']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['first_name']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['last_name']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $order['email']; ?></td>
                        <td class="border border-gray-
300 px-4 py-2"><?php echo $order['phone_number']; ?></td>
<td class="border border-gray-300 px-4 py-2"><?php echo $order['country']; ?></td>
<td class="border border-gray-300 px-4 py-2"><?php echo $order['for_day']; ?></td>
<td class="border border-gray-300 px-4 py-2"><?php echo $order['work_hours']; ?></td>
<td class="border border-gray-300 px-4 py-2"><?php echo $order['our_network_today']; ?></td>
<td class="border border-gray-300 px-4 py-2"><?php echo $order['client_network_today']; ?></td>
<td class="border border-gray-300 px-4 py-2"><?php echo $order['broker_today']; ?></td>
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
<a href="dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg mt-4 inline-block">Back to Dashboard</a>
</div>

</body>
</html>
