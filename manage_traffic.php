<?php
session_start();
if (!in_array($_SESSION['role'], ['super_admin', 'order_admin','filler_admin', 'ftd_admin'])) {
    header("Location: dashboard.php");
    exit();
}

include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_traffic'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $country = $_POST['country'];
    $date_created = $_POST['date_created'];
    $our_network = $_POST['our_network'];
    $client_network = $_POST['client_network'];
    $broker = $_POST['broker'];

    $stmt = $conn->prepare("INSERT INTO traffic (first_name, last_name, email, phone_number, country, date_created, our_network, client_network, broker) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssss", $first_name, $last_name, $email, $phone_number, $country, $date_created, $our_network, $client_network, $broker);
    $stmt->execute();
    header("Location: manage_traffic.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_traffic'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $country = $_POST['country'];
    $date_created = $_POST['date_created'];
    $our_network = $_POST['our_network'];
    $client_network = $_POST['client_network'];
    $broker = $_POST['broker'];

    $stmt = $conn->prepare("UPDATE traffic SET first_name=?, last_name=?, email=?, phone_number=?, country=?, date_created=?, our_network=?, client_network=?, broker=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $first_name, $last_name, $email, $phone_number, $country, $date_created, $our_network, $client_network, $broker, $id);
    $stmt->execute();
    header("Location: manage_traffic.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_traffic'])) {
    $id = $_POST['traffic_id'];
    mysqli_query($conn, "DELETE FROM traffic WHERE id='$id'");
    header("Location: manage_traffic.php");
}

$traffic_records = mysqli_query($conn, "SELECT * FROM traffic");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Traffic Records</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Manage Traffic Records</h1>
        <form method="post" class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="last_name" class="block">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="email" class="block">Email:</label>
                    <input type="email" id="email" name="email" required class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="phone_number" class="block">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="country" class="block">Country:</label>
                    <input type="text" id="country" name="country" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="date_created" class="block">Date Created:</label>
                    <input type="text" id="date_created" name="date_created" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="our_network" class="block">Our Network:</label>
                    <input type="text" id="our_network" name="our_network" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="client_network" class="block">Client Network:</label>
                    <input type="text" id="client_network" name="client_network" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="broker" class="block">Broker:</label>
                    <input type="text" id="broker" name="broker" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
            </div>
            <button type="submit" name="add_traffic" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Add Traffic Record</button>
        </form>
        <h2 class="text-xl font-bold mb-4">Traffic Records List</h2>
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">First Name</th>
                    <th class="py-2 px-4 border-b">Last Name</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Phone Number</th>
                    <th class="py-2 px-4 border-b">Country</th>
                    <th class="py-2 px-4 border-b">Date Created</th>
                    <th class="py-2 px-4 border-b">Our Network</th>
                    <th class="py-2 px-4 border-b">Client Network</th>
                    <th class="py-2 px-4 border-b">Broker</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($record = mysqli_fetch_assoc($traffic_records)) { ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo $record['id']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $record['first_name']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $record['last_name']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $record['email']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $record['phone_number']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $record['country']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $record['date_created']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $record['our_network']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $record['client_network']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $record['broker']; ?></td>
                        <td class="py-2 px-4 border-b">
                            <form method="post" action="update_traffic.php" class="inline">
                                <input type="hidden" name="traffic_id" value="<?php echo $record['id']; ?>">
                                <button type="submit" name="update_traffic" class="text-indigo-600 hover:text-indigo-900">Update</button>
                            </form>
                            <form method="post" class="inline">
                                <input type="hidden" name="traffic_id" value="<?php echo $record['id']; ?>">
                                <button type="submit" name="delete_traffic" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="block mt-4 text-blue-500">Back to Dashboard</a>
    </div>
</body>
</html>