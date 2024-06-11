<?php
session_start();
if (!in_array($_SESSION['role'], ['super_admin', 'order_admin', 'ftd_admin'])) {
    header("Location: dashboard.php");
    exit();
}

include('config.php');

// Check if form is submitted and fid is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_ftd']) && isset($_POST['ftd_id'])) {
    $fid = $_POST['ftd_id'];

    // Fetch the FTD record from the database based on fid
    $result = mysqli_query($conn, "SELECT * FROM ftd WHERE fid='$fid'");
    $ftd = mysqli_fetch_assoc($result);
}

// Handle Update Operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_ftd_submit'])) {
    $fid = $_POST['ftd_id'];
    $updated_fields = array();

    // Check which fields are being updated and add them to the $updated_fields array
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $updated_fields[] = "email='$email'";
    }
    if (isset($_POST['email_password'])) {
        $email_password = $_POST['email_password'];
        $updated_fields[] = "email_password='$email_password'";
    }
    if (isset($_POST['extension'])) {
        $extension = $_POST['extension'];
        $updated_fields[] = "extension='$extension'";
    }
    if (isset($_POST['phone_number'])) {
        $phone_number = $_POST['phone_number'];
        $updated_fields[] = "phone_number='$phone_number'";
    }
    if (isset($_POST['whatsapp'])) {
        $whatsapp = $_POST['whatsapp'];
        $updated_fields[] = "whatsapp='$whatsapp'";
    }
    if (isset($_POST['viber'])) {
        $viber = $_POST['viber'];
        $updated_fields[] = "viber='$viber'";
    }
    if (isset($_POST['messenger'])) {
        $messenger = $_POST['messenger'];
        $updated_fields[] = "messenger='$messenger'";
    }
    if (isset($_POST['dob'])) {
        $dob = $_POST['dob'];
        $updated_fields[] = "dob='$dob'";
    }
    if (isset($_POST['address'])) {
        $address = $_POST['address'];
        $updated_fields[] = "address='$address'";
    }
    if (isset($_POST['country'])) {
        $country = $_POST['country'];
        $updated_fields[] = "country='$country'";
    }
    if (isset($_POST['date_created'])) {
        $date_created = $_POST['date_created'];
        $updated_fields[] = "date_created='$date_created'";
    }
    if (isset($_POST['front_id'])) {
        $front_id = $_POST['front_id'];
        $updated_fields[] = "front_id='$front_id'";
    }
    if (isset($_POST['back_id'])) {
        $back_id = $_POST['back_id'];
        $updated_fields[] = "back_id='$back_id'";
    }
    if (isset($_POST['selfie_front'])) {
        $selfie_front = $_POST['selfie_front'];
        $updated_fields[] = "selfie_front='$selfie_front'";
    }
    if (isset($_POST['selfie_back'])) {
        $selfie_back = $_POST['selfie_back'];
        $updated_fields[] = "selfie_back='$selfie_back'";
    }
    if (isset($_POST['remark'])) {
        $remark = $_POST['remark'];
        $updated_fields[] = "remark='$remark'";
    }
    if (isset($_POST['profile_picture'])) {
        $profile_picture = $_POST['profile_picture'];
        $updated_fields[] = "profile_picture='$profile_picture'";
    }
    if (isset($_POST['our_network'])) {
        $our_network = $_POST['our_network'];
        $updated_fields[] = "our_network='$our_network'";
    }
    if (isset($_POST['client_network'])) {
        $client_network = $_POST['client_network'];
        $updated_fields[] = "client_network='$client_network'";
    }
    if (isset($_POST['broker'])) {
        $broker = $_POST['broker'];
        $updated_fields[] = "broker='$broker'";
    }

    // Construct the update query with the updated fields
    if (!empty($updated_fields)) {
        $update_query = "UPDATE ftd SET " . implode(', ', $updated_fields) . " WHERE fid='$fid'";
        mysqli_query($conn, $update_query);
        header("Location: manage_ftd.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update FTD</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 py-8 px-4">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-md shadow-md">
        <h1 class="text-2xl font-bold mb-4">Update FTD</h1>
        <form method="post" class="space-y-4">
            <input type="hidden" name="ftd_id" value="<?php echo $ftd['fid']; ?>">

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

            <label for="dob" class="block">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?php echo $ftd['dob']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="address" class="block">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $ftd['address']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="country" class="block">Country:</label>
            <input type="text" id="country" name="country" value="<?php echo $ftd['country']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="date_created" class="block">Date Created:</label>
            <input type="text" id="date_created" name="date_created" value="<?php echo $ftd['date_created']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="front_id" class="block">Front ID:</label>
            <input type="text" id="front_id" name="front_id" value="<?php echo $ftd['front_id']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="back_id" class="block">Back ID:</label>
            <input type="text" id="back_id" name="back_id" value="<?php echo $ftd['back_id']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="selfie_front" class="block">Selfie Front:</label>
            <input type="text" id="selfie_front" name="selfie_front" value="<?php echo $ftd['selfie_front']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="selfie_back" class="block">Selfie Back:</label>
            <input type="text" id="selfie_back" name="selfie_back" value="<?php echo $ftd['selfie_back']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="remark" class="block">Remark:</label>
            <textarea id="remark" name="remark" class="border border-gray-300 rounded-md px-3 py-2 focus
focus
focus
focus
"><?php echo $ftd['remark']; ?></textarea>
<label for="profile_picture" class="block">Profile Picture:</label>
        <input type="text" id="profile_picture" name="profile_picture" value="<?php echo $ftd['profile_picture']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <label for="our_network" class="block">Our Network:</label>
        <input type="text" id="our_network" name="our_network" value="<?php echo $ftd['our_network']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <label for="client_network" class="block">Client Network:</label>
        <input type="text" id="client_network" name="client_network" value="<?php echo $ftd['client_network']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <label for="broker" class="block">Broker:</label>
        <input type="text" id="broker" name="broker" value="<?php echo $ftd['broker']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

        <button type="submit" name="update_ftd_submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md">Update FTD</button>
    </form>
    <a href="manage_ftd.php" class="block mt-4 text-indigo-600 hover:text-indigo-700">Cancel</a>
</div>

