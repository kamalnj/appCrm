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
    
    if (isset($_POST['table_origin'])) {
        $table_origin = $_POST['table_origin'];
        $updated_fields[] = "table_origin='$table_origin'";
    }
    
    if (isset($_POST['first_name'])) {
        $first_name = $_POST['first_name'];
        $updated_fields[] = "first_name='$first_name'";
    }
    
    if (isset($_POST['last_name'])) {
        $last_name = $_POST['last_name'];
        $updated_fields[] = "last_name='$last_name'";
    }
    
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $updated_fields[] = "email='$email'";
    }
    
    if (isset($_POST['phone_number'])) {
        $phone_number = $_POST['phone_number'];
        $updated_fields[] = "phone_number='$phone_number'";
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
    
    if (isset($_POST['client_network_today'])) {
        $client_network_today = $_POST['client_network_today'];
        $updated_fields[] = "client_network_today='$client_network_today'";
    }
    
    if (isset($_POST['broker_today'])) {
        $broker_today = $_POST['broker_today'];
        $updated_fields[] = "broker_today='$broker_today'";
    }
    
    // Construct the update query with the updated fields
    if (!empty($updated_fields)) {
        $update_query = "UPDATE orders SET " . implode(', ', $updated_fields) . " WHERE id={$_POST['order_id']}";
        // Assuming 'order_id' is passed through a hidden input field in your form
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
        /* Additional custom styles can be added here */
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-lg font-semibold mb-4">Update Order</h1>
        <form method="post" class="space-y-4">
            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
            <label for="order_date" class="block">Order Date:</label>
            <input type="text" id="order_date" name="order_date" value="<?php echo $order['order_date']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <label for="table_origin" class="block">Table Origin:</label>
            <input type="text" id="table_origin" name="table_origin" value="<?php echo $order['table_origin']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <label for="first_name" class="block">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $order['first_name']; ?>"
            class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <label for="last_name" class="block">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $order['last_name']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <label for="email" class="block">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $order['email']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <label for="phone_number" class="block">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $order['phone_number']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <label for="country" class="block">Country:</label>
            <input type="text" id="country" name="country" value="<?php echo $order['country']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <label for="for_day" class="block">For Day:</label>
            <input type="text" id="for_day" name="for_day" value="<?php echo $order['for_day']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <label for="work_hours" class="block">Work Hours:</label>
            <input type="text" id="work_hours" name="work_hours" value="<?php echo $order['work_hours']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <label for="our_network_today" class="block">Our Network Today:</label>
            <input type="text" id="our_network_today" name="our_network_today" value="<?php echo $order['our_network_today']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <label for="client_network_today" class="block">Client Network Today:</label>
            <input type="text" id="client_network_today" name="client_network_today" value="<?php echo $order['client_network_today']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <label for="broker_today" class="block">Broker Today:</label>
            <input type="text" id="broker_today" name="broker_today" value="<?php echo $order['broker_today']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            
            <button type="submit" name="update_order_submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Update Order</button>
        </form>
        <a href="manage_orders.php" class="block mt-4 text-blue-500">Cancel</a>
    </div>
</body>
</html>
