<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Additional custom styles can be added here */
    </style>
</head>
<body class="bg-gray-100">
    <div class="mt-12 container mx-auto px-4 py-8"> <!-- Added mx-auto class -->
        <h1 class="text-4xl mb-20 text-center font-semibold">Welcome to the Dashboard</h1>
        <div class="flex flex-wrap gap-4 justify-center"> <!-- Added justify-center class -->

            <?php if ($role == 'super_admin') { ?>
                <a href="add_admin.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage Users</a>
                <a href="manage_orders.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage Orders</a>
                <a href="manage_ftd.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage FTD</a>
                <a href="manage_filler.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage Filler</a>
                <a href="manage_traffic.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage Traffic</a>
            <?php } elseif ($role == 'order_admin') { ?>
                <a href="manage_orders.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage Orders</a>
                <a href="manage_ftd.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage FTD</a>
                <a href="manage_filler.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage Filler</a>
                <a href="manage_traffic.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage Traffic</a>
            <?php } elseif ($role == 'filler_admin') { ?>
                <a href="manage_filler.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage Filler</a>
                <a href="manage_traffic.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage Traffic</a>
            <?php } elseif ($role == 'ftd_admin') { ?>
                <a href="manage_ftd.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Manage FTD</a>
            <?php } ?>
            <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg">Logout</a>
        </div>
    </div>
</body>
</html>
