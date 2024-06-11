<?php
session_start();
if (!in_array($_SESSION['role'], ['super_admin', 'order_admin', 'ftd_admin'])) {
    header("Location: dashboard.php");
    exit();
}

include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_ftd_submit'])) {
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

    $sql = "UPDATE ftd SET email=?, email_password=?, extension=?, phone_number=?, whatsapp=?, viber=?, messenger=?, dob=?, address=?, country=?, date_created=?, front_id=?, back_id=?, selfie_front=?, selfie_back=?, remark=?, profile_picture=?, our_network=?, client_network=?, broker=? WHERE fid=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssssssss", $email, $email_password, $extension, $phone_number, $whatsapp, $viber, $messenger, $dob, $address, $country, $date_created, $front_id, $back_id, $selfie_front, $selfie_back, $remark, $profile_picture, $our_network, $client_network, $broker, $fid);
    $stmt->execute();
    header("Location: manage_ftd.php");
}

$fid = $_GET['id'];
$ftd_result = mysqli_query($conn, "SELECT * FROM ftd WHERE fid='$fid'");
$ftd = mysqli_fetch_assoc($ftd_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update FTD</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container px-6 mx-auto py-8">
        <h1 class="text-3xl text-center font-bold mb-4">Update FTD</h1>
        <form method="post" class="space-y-4">
            <input type="hidden" name="fid" value="<?php echo $ftd['fid']; ?>">
            <label for="email" class="block">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $ftd['email']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="email_password" class="block">Email Password:</label>
            <input type="text" id="email_password" name="email_password" value="<?php echo $ftd['email_password']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="extension" class="block">Extension:</label>
            <input type="number" id="extension" name="extension" value="<?php echo $ftd['extension']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="phone_number" class="block">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $ftd['phone_number']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="whatsapp" class="block">WhatsApp:</label>
            <select id="whatsapp" name="whatsapp" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="Yes" <?php if ($ftd['whatsapp'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option value="No" <?php if ($ftd['whatsapp'] == 'No') echo 'selected'; ?>>No</option>
            </select>

            <label for="viber" class="block">Viber:</label>
            <select id="viber" name="viber" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="Yes" <?php if ($ftd['viber'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option value="No" <?php if ($ftd['viber'] == 'No') echo 'selected'; ?>>No</option>
            </select>

            <label for="messenger" class="block">Messenger:</label>
            <select id="messenger" name="messenger" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="Yes" <?php if ($ftd['messenger'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option value="No" <?php if ($ftd['messenger'] == 'No') echo 'selected'; ?>>No</option>
            </select>

            <label for="dob" class="block">DOB:</label>
            <input type="date" id="dob" name="dob" value="<?php echo $ftd['dob']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="address" class="block">Address:</label>
            <textarea id="address" name="address" rows="3" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"><?php echo $ftd['address']; ?></textarea>

            <label for="country" class="block">Country:</label>
            <input type="text" id="country" name="country" value="<?php echo $ftd['country']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="date_created" class="block">Date Created:</label>
            <input type="date" id="date_created" name="date_created" value="<?php echo $ftd['date_created']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="front_id" class="block">Front ID:</label>
            <input type="text" id="front_id" name="front_id" value="<?php echo $ftd['front_id']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="back_id" class="block">Back ID:</label>
            <input type="text" id="back_id" name="back_id" value="<?php echo $ftd['back_id']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="selfie_front" class="block">Selfie Front:</label>
            <input type="text" id="selfie_front" name="selfie_front" value="<?php echo $ftd['selfie_front']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="selfie_back" class="block">Selfie Back:</label>
            <input type="text" id="selfie_back" name="selfie_back" value="<?php echo $ftd['selfie_back']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="remark" class="block">Remark:</label>
            <textarea id="remark" name="remark" rows="3" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"><?php echo $ftd['remark']; ?></textarea>

            <label for="profile_picture" class="block">Profile Picture:</label>
            <input type="text" id="profile_picture" name="profile_picture" value="<?php echo $ftd['profile_picture']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="our_network" class="block">Our Network:</label>
            <input type="text" id="our_network" name="our_network" value="<?php echo $ftd['our_network']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="client_network" class="block">Client Network:</label>
            <input type="text" id="client_network" name="client_network" value="<?php echo $ftd['client_network']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="broker" class="block">Broker:</label>
            <input type="text" id="broker" name="broker" value="<?php echo $ftd['broker']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <div class="flex justify-center">
                <button type="submit" name="update_ftd_submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update FTD</button>
            </div>
        </form>
    </div>
</body>
</html>
