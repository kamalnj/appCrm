<?php
session_start();
if (!in_array($_SESSION['role'], ['super_admin'])) {
    header("Location: dashboard.php");
    exit();
}

include('config.php'); // Include your database connection file
// Handle deletion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_brand'])) {
        $brand_id = $_POST['brand_id'];
        mysqli_query($conn, "DELETE FROM list_brand_name WHERE id=$brand_id");
        // Redirect or show success message
    }
    if (isset($_POST['delete_network'])) {
        $network_id = $_POST['network_id'];
        mysqli_query($conn, "DELETE FROM list_network WHERE id=$network_id");
        // Redirect or show success message
    }
    if (isset($_POST['delete_type'])) {
        $type_id = $_POST['type_id'];
        mysqli_query($conn, "DELETE FROM list_type_order WHERE id=$type_id");
        // Redirect or show success message
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_brand'])) {
        $brand_name = $_POST['brand_name'];
        mysqli_query($conn, "INSERT INTO list_brand_name (name_brand) VALUES ('$brand_name')");
        echo '<script>alert("Added successfully");</script>';
    }

    if (isset($_POST['add_network'])) {
        $network_name = $_POST['network_name'];
        mysqli_query($conn, "INSERT INTO list_network (name_network) VALUES ('$network_name')");
        echo '<script>alert("Added successfully");</script>';

    }

    if (isset($_POST['add_type_order'])) {
        $type_order = $_POST['type_order'];
        // Insert $type_order into list_type_order table
        mysqli_query($conn, "INSERT INTO list_type_order (name_type) VALUES ('$type_order')");
        echo '<script>alert("Added successfully");</script>';

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add information</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-32 px-4 py-8">
    <a href="dashboard.php"><button class="mt-4 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">Back To Dashboard</button></a> <br><br>
        <h1 class="text-lg text-center font-semibold mb-4">Add information</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Form for Brand Names -->
            <form method="post" class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-2">Add Brand Name</h2>
                <div class="mb-4">
                    <label for="brand_name" class="block">Brand Name:</label>
                    <input type="text" id="brand_name" name="brand_name" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <button type="submit" name="add_brand" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Add Brand</button>
            </form>

            <!-- Form for Network Names -->
            <form method="post" class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-2">Add Network Name</h2>
                <div class="mb-4">
                    <label for="network_name" class="block">Network Name:</label>
                    <input type="text" id="network_name" name="network_name" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <button type="submit" name="add_network" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Add Network</button>
            </form>

            <!-- Form for Type Order Names -->
            <form method="post" class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-2">Add Type Order Name</h2>
                <div class="mb-4">
                    <label for="type_order" class="block">Type Order Name:</label>
                    <input type="text" id="type_order" name="type_order" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <button type="submit" name="add_type_order" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Add Type Order</button>
            </form>
        </div>
    </div>
    <div class="container mx-auto mt-32 px-4 py-8">
        <h1 class="text-lg text-center font-semibold mb-4">View and Delete Information</h1>
        
        <!-- Table for Brand Names -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-2">Brand Names</h2>
            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-md">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM list_brand_name");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>{$row['id']}</td>";
                        echo "<td class='border px-4 py-2'>{$row['name_brand']}</td>";
                        echo "<td class='border px-4 py-2'><form method='post'><input type='hidden' name='brand_id' value='{$row['id']}'><button type='submit' name='delete_brand' class='bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded'>Delete</button></form></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Table for Network Names -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-2">Network Names</h2>
            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-md">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM list_network");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>{$row['id']}</td>";
                        echo "<td class='border px-4 py-2'>{$row['name_network']}</td>";
                        echo "<td class='border px-4 py-2'><form method='post'><input type='hidden' name='network_id' value='{$row['id']}'><button type='submit' name='delete_network' class='bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded'>Delete</button></form></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Table for Type Order Names -->
        <div>
            <h2 class="text-lg font-semibold mb-2">Type Order Names</h2>
            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-md">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM list_type_order");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>{$row['id']}</td>";
                        echo "<td class='border px-4 py-2'>{$row['name_type']}</td>";
                        echo "<td class='border px-4 py-2'><form method='post'><input type='hidden' name='type_id' value='{$row['id']}'><button type='submit' name='delete_type' class='bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded'>Delete</button></form></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
