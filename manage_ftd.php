<?php
session_start();
if (!in_array($_SESSION['role'], ['super_admin', 'order_admin', 'ftd_admin'])) {
    header("Location: dashboard.php");
    exit();
}

include('config.php');

// Handle Add Operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_ftd'])) {
    $fid = $_POST['fid'];
    $email = $_POST['email'];
    $email_password = $_POST['email_password'];
    $extension = $_POST['extension'];
    $phone_number = $_POST['phone_number'];
    $whatsapp = $_POST['whatsapp'];
    $viber = $_POST['viber'];
    $messenger = $_POST['messenger'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $date_created = $_POST['date_created'];
    $front_id = $_POST['front_id'];
    $back_id = $_POST['back_id'];
    $selfie_front = $_POST['selfie_front'];
    $selfie_back = $_POST['selfie_back'];
    $remark = $_POST['remark'];
    $profile_picture = $_POST['profile_picture'];
    $our_network = $_POST['our_network'];
    $client_network = $_POST['client_network'];
    $broker = $_POST['broker'];

    // Prepare INSERT statement
    $stmt = $conn->prepare("INSERT INTO ftd (fid, email, email_password, extension, phone_number, whatsapp, viber, messenger, dob, address, country, date_created, front_id, back_id, selfie_front, selfie_back, remark, profile_picture, our_network, client_network, broker) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    // Bind parameters and execute
    $stmt->bind_param("sssssssssssssssssssss", $fid, $email, $email_password, $extension, $phone_number, $whatsapp, $viber, $messenger, $dob, $address, $country, $date_created, $front_id, $back_id, $selfie_front, $selfie_back, $remark, $profile_picture, $our_network, $client_network, $broker);
    $stmt->execute();
    header("Location: manage_ftd.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_ftd'])) {
    $fid = $_POST['fid'];
    $email = $_POST['email'];
    $email_password = $_POST['email_password'];
    $extension = $_POST['extension'];
    $phone_number = $_POST['phone_number'];
    $whatsapp = $_POST['whatsapp'];
    $viber = $_POST['viber'];
    $messenger = $_POST['messenger'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $date_created = $_POST['date_created'];
    $front_id = $_POST['front_id'];
    $back_id = $_POST['back_id'];
    $selfie_front = $_POST['selfie_front'];
    $selfie_back = $_POST['selfie_back'];
    $remark = $_POST['remark'];
    $profile_picture = $_POST['profile_picture'];
    $our_network = $_POST['our_network'];
    $client_network = $_POST['client_network'];
    $broker = $_POST['broker'];

    $stmt = $conn->prepare("UPDATE ftd SET email=?, email_password=?, extension=?, phone_number=?, whatsapp=?, viber=?, messenger=?, dob=?, address=?, country=?, date_created=?, front_id=?, back_id=?, selfie_front=?, selfie_back=?, remark=?, profile_picture=?, our_network=?, client_network=?, broker=? WHERE fid=?");
    $stmt->bind_param("sssssssssssssssssssss", $email, $email_password, $extension, $phone_number, $whatsapp, $viber, $messenger, $dob, $address, $country, $date_created, $front_id, $back_id, $selfie_front, $selfie_back, $remark, $profile_picture, $our_network, $client_network, $broker, $fid);
    $stmt->execute();
    header("Location: manage_ftd.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_ftd'])) {
    // Code to delete FTD record
    $fid = $_POST['ftd_id'];
    // Delete the FTD record from the database
    mysqli_query($conn, "DELETE FROM ftd WHERE fid='$fid'");
    header("Location: manage_ftd.php");
}

// Fetch FTDs
$ftds = mysqli_query($conn, "SELECT * FROM ftd");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage FTD</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container px-6 mx-auto py-8">
        <h1 class="text-3xl text-center font-bold mb-4">Manage FTD</h1>
        <form method="post" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="fid" class="block text-sm font-medium text-gray-700">FID:</label>
                    <input type="text" id="fid" name="fid" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" id="email" name="email" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="email_password" class="block text-sm font-medium text-gray-700">Email Password:</label>
                    <input type="text" id="email_password" name="email_password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="extension" class="block text-sm font-medium text-gray-700">Extension:</label>
                    <input type="number" id="extension" name="extension" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="whatsapp" class="block text-sm font-medium text-gray-700">WhatsApp:</label>
                    <select id="whatsapp" name="whatsapp" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div>
                    <label for="viber" class="block text-sm font-medium text-gray-700">Viber:</label>
                    <select id="viber" name="viber" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div>
                    <label for="messenger" class="block text-sm font-medium text-gray-700">Messenger:</label>
                    <select id="messenger" name="messenger" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div>
                    <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address:</label>
                    <input type="text" id="address" name="address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700">Country:</label>
                    <input type="text" id="country" name="country" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="date_created" class="block text-sm font-medium text-gray-700">Date Created:</label>
                    <input type="text" id="date_created" name="date_created" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="front_id" class="block text-sm font-medium text-gray-700">Front ID:</label>
                    <input type="text" id="front_id" name="front_id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="back_id" class="block text-sm font-medium text-gray-700">Back ID:</label>
                    <input type="text" id="back_id" name="back_id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="selfie_front" class="block text-sm font-medium text-gray-700">Selfie Front:</label>
                    <input type="text" id="selfie_front" name="selfie_front" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="selfie_back" class="block text-sm font-medium text-gray-700">Selfie Back:</label>
                    <input type="text" id="selfie_back" name="selfie_back" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="remark" class="block text-sm font-medium text-gray-700">Remark:</label>
                    <textarea id="remark" name="remark" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                </div>
                <div>
                    <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture:</label>
                    <input type="text" id="profile_picture" name="profile_picture" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="our_network" class="block text-sm font-medium text-gray-700">Our Network:</label>
                    <input type="text" id="our_network" name="our_network" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="client_network" class="block text-sm font-medium text-gray-700">Client Network:</label>
                    <input type="text" id="client_network" name="client_network" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="broker" class="block text-sm font-medium text-gray-700">Broker:</label>
                    <input type="text" id="broker" name="broker" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>
            <button type="submit" name="add_ftd" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 mt-4">Add FTD</button>
        </form>
        <h2 class="text-xl font-semibold mt-8">FTD List</h2>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($ftd = mysqli_fetch_assoc($ftds)) { ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $ftd['fid']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $ftd['email']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form method="post" action="update_ftd.php" class="inline">
                                    <input type="hidden" name="ftd_id" value="<?php echo $ftd['fid']; ?>">
                                    <button type="submit" name="update_ftd" class="text-indigo-600 hover:text-indigo-900">Update</button>
                                </form>
                                <form method="post" class="inline">
                                    <input type="hidden" name="ftd_id" value="<?php echo $ftd['fid']; ?>">
                                    <button type="submit" name="delete_ftd" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <a href="dashboard.php" class="text-indigo-600 hover:text-indigo-900 mt-4 block">Back to Dashboard</a>
    </div>
</body>
</html>


