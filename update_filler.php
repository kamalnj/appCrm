<?php
session_start();
if (!in_array($_SESSION['role'], ['super_admin', 'order_admin','filler_admin','ftd_admin'])) {
    header("Location: dashboard.php");
    exit();
}

include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_filler']) && isset($_POST['filler_id'])) {
    $filler_id = $_POST['filler_id'];
    $result = mysqli_query($conn, "SELECT * FROM filler WHERE id='$filler_id'");
    $filler = mysqli_fetch_assoc($result);
}else{
    header('Location: manage_filler.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_filler_submit'])) {
    $filler_id = $_POST['filler_id'];
    $updated_fields = array();
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
    
    if (isset($_POST['date_created'])) {
        $date_created = $_POST['date_created'];
        $updated_fields[] = "date_created='$date_created'";
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
    
    if (!empty($updated_fields)) {
        $update_query = "UPDATE filler SET " . implode(', ', $updated_fields) . " WHERE id={$_POST['filler_id']}";
        mysqli_query($conn, $update_query);
        // Redirect or handle success message
        header("Location: manage_filler.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Filler</title>
    <link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap"
  rel="stylesheet" />
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
  <style>
        input, textarea {
            width: 500px;
        }
        div#bloc-data {
            margin-left: 20px;
            margin-top: 20px;
        }
        button[name="update_filler_submit"] {
            display: block;
        }
  </style>
<script src="https://cdn.tailwindcss.com/3.3.0"></script>
</head>
<body>
    <div id="bloc-data">
        <h1 class="text-2xl font-bold">Update Filler</h1>
        <form method="post" class="space-y-4">
            <input type="hidden" name="filler_id" value="<?php echo $filler['id']; ?>">
            
            <label for="first_name" class="block">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $filler['first_name']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>

            <label for="last_name" class="block">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $filler['last_name']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>

            <label for="email" class="block">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $filler['email']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>

            <label for="phone_number" class="block">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $filler['phone_number']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="country" class="block">Country:</label>
            <input type="text" id="country" name="country" value="<?php echo $filler['country']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="date_created" class="block">Date Created:</label>
            <input type="text" id="date_created" name="date_created" value="<?php echo $filler['date_created']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="our_network" class="block">Our Network:</label>
            <input type="text" id="our_network" name="our_network" value="<?php echo $filler['our_network']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="client_network" class="block">Client Network:</label>
            <input type="text" id="client_network" name="client_network" value="<?php echo $filler['client_network']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <label for="broker" class="block">Broker:</label>
            <input type="text" id="broker" name="broker" value="<?php echo $filler['broker']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

            <button type="submit" name="update_filler_submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md">Update Filler</button>
        </form>
        <a href="manage_filler.php" class="block mt-4 text-indigo-600 hover:text-indigo-700">Cancel</a>
    </div>
</body>
</html>