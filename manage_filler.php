<?php
session_start();
include('config.php');

if (!in_array($_SESSION['role'], ['super_admin','filler_admin', 'order_admin'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['add_filler'])) {
        // Logic for adding filler from form
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $country = $_POST['country'];
        $date_created = $_POST['date_created'];
        $our_network = $_POST['our_network'];
        $client_network = $_POST['client_network'];
        $broker = $_POST['broker'];

        $stmt = $conn->prepare("INSERT INTO filler (first_name, last_name, email, phone_number, country, date_created, our_network, client_network, broker) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $first_name, $last_name, $email, $phone_number, $country, $date_created, $our_network, $client_network, $broker);
        $stmt->execute();
        header("Location: manage_filler.php");
    } elseif(isset($_POST['delete_filler'])) {
        // Logic for deleting filler
        $id = $_POST['filler_id'];
        mysqli_query($conn, "DELETE FROM filler WHERE id='$id'");
        header("Location: manage_filler.php");
    } elseif(isset($_POST['upload_csv'])) {
        // Logic for uploading CSV file
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
            $file = $_FILES['csv_file']['tmp_name'];
            $handle = fopen($file, "r");

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $first_name = $data[0];
                $last_name = $data[1];
                $email = $data[2];
                $phone_number = $data[3];
                $country = $data[4];
                $date_created = $data[5];
                $our_network = $data[6];
                $client_network = $data[7];
                $broker = $data[8];

                $stmt = $conn->prepare("INSERT INTO filler (first_name, last_name, email, phone_number, country, date_created, our_network, client_network, broker) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssss", $first_name, $last_name, $email, $phone_number, $country, $date_created, $our_network, $client_network, $broker);
                $stmt->execute();
            }
            fclose($handle);
            header("Location: manage_filler.php");
        }
    }
}

$fillers = mysqli_query($conn, "SELECT * FROM filler");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Fillers</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
    <style>
        input, textarea {
            width: 500px;
        }
        button[name="add_filler"] {
            display: block;
        }
        button[name="update_filler"] {
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="bg-gray-100 py-8 px-4">
    <a href="dashboard.php"><button class="mt-4 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">Back To Dashboard</button></a> <br><br>
    <h1 class="text-2xl font-bold mb-4">Manage Fillers</h1>
    <form method="post" class="mt-8" enctype="multipart/form-data">
        <label for="csv_file" class="block">Upload CSV File:</label>
        <input type="file" id="csv_file" name="csv_file" accept=".csv" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        <button type="submit" name="upload_csv" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md mt-2">Upload CSV</button>
    </form>
    <form method="post" class="space-y-4">
        <label for="first_name" class="block">First Name:</label>
        <input type="text" id="first_name" name="first_name" required class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <label for="last_name" class="block">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <label for="email" class="block">Email:</label>
        <input type="email" id="email" name="email" required class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <label for="phone_number" class="block">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <label for="country" class="block">Country:</label>
        <input type="text" id="country" name="country" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <label for="date_created" class="block">Date Created:</label>
        <input type="text" id="date_created" name="date_created" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <label for="our_network" class="block">Our Network:</label>
        <input type="text" id="our_network" name="our_network" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <label for="client_network" class="block">Client Network:</label>
        <input type="text" id="client_network" name="client_network" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <label for="broker" class="block">Broker:</label>
        <input type="text" id="broker" name="broker" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <button type="submit" name="add_filler" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md">Add Filler</button>
    </form>
    <h2 class="text-xl font-bold mt-8 mb-4">Filler List</h2>
    <table class="w-full border-collapse border border-gray-200">
        <thead>
            <tr>
                <th class="border border-gray-200 px-4 py-2">ID</th>
                <th class="border border-gray-200 px-4 py-2">First Name</th>
                <th class="border border-gray-200 px-4 py-2">Last Name</th>
                <th class="border border-gray-200 px-4 py-2">Email</th>
                <th class="border border-gray-200 px-4 py-2">Phone Number</th>
                <th class="border border-gray-200 px-4 py-2">Country</th>
                <th class="border border-gray-200 px-4 py-2">Date Created</th>
                <th class="border border-gray-200 px-4 py-2">Our Network</th>
                <th class="border border-gray-200 px-4 py-2">Client Network</th>
                <th class="border border-gray-200 px-4 py-2">Broker</th>
                <th class="border border-gray-200 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($filler = mysqli_fetch_assoc($fillers)) { ?>
                <tr>
    <td class="border border-gray-200 px-4 py-2"><?php echo $filler['id']; ?></td>
    <td class="border border-gray-200 px-4 py-2"><?php echo $filler['first_name']; ?></td>
    <td class="border border-gray-200 px-4 py-2"><?php echo $filler['last_name']; ?></td>
    <td class="border border-gray-200 px-4 py-2"><?php echo $filler['email']; ?></td>
    <td class="border border-gray-200 px-4 py-2"><?php echo $filler['phone_number']; ?></td>
    <td class="border border-gray-200 px-4 py-2"><?php echo $filler['country']; ?></td>
    <td class="border border-gray-200 px-4 py-2"><?php echo $filler['date_created']; ?></td>
    <td class="border border-gray-200 px-4 py-2"><?php echo $filler['our_network']; ?></td>
    <td class="border border-gray-200 px-4 py-2"><?php echo $filler['client_network']; ?></td>
    <td class="border border-gray-200 px-4 py-2"><?php echo $filler['broker']; ?></td>
    <td class="border border-gray-200 px-4 py-2">
        <form method="post" action="update_filler.php">
            <input type="hidden" name="filler_id" value="<?php echo $filler['id']; ?>">
            <button type="submit" name="update_filler" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
        </form>
        <form method="post">
            <input type="hidden" name="filler_id" value="<?php echo $filler['id']; ?>">
            <button type="submit" name="delete_filler" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </td>
</tr>

            <?php } ?>
        </tbody>
    </table>
</body>
</html>

