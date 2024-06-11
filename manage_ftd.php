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
                    <label for="dob" class="block text-sm font-medium text-gray-700">DOB:</label>
                    <input type="date" id="dob" name="dob" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address:</label>
                    <textarea id="address" name="address" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                </div>
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700">Country:</label>
                    <input type="text" id="country" name="country" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="date_created" class="block text-sm font-medium text-gray-700">Date Created:</label>
                    <input type="date" id="date_created" name="date_created" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                    <textarea id="remark" name="remark" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
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
            <div class="flex justify-center">
                <button type="submit" name="add_ftd" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700">Add FTD</button>
            </div>
        </form>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white mt-6">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/6 py-2">FID</th>
                        <th class="w-1/6 py-2">Email</th>
                        <th class="w-1/6 py-2">Phone Number</th>
                        <th class="w-1/6 py-2">Country</th>
                        <th class="w-1/6 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($ftds)) { ?>
                    <tr class="border-b">
                        <td class="py-2"><?php echo $row['fid']; ?></td>
                        <td class="py-2"><?php echo $row['email']; ?></td>
                        <td class="py-2"><?php echo $row['phone_number']; ?></td>
                        <td class="py-2"><?php echo $row['country']; ?></td>
                        <td class="py-2">
                            <div class="flex space-x-2">
                                <button onclick="viewFTD('<?php echo $row['fid']; ?>')" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-700">View</button>
                                <form method="post" action="update_ftd.php">
                                    <input type="hidden" name="ftd_id" value="<?php echo $row['fid']; ?>">
                                    <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-700">Update</button>
                                </form>
                                <form method="post">
                                    <input type="hidden" name="ftd_id" value="<?php echo $row['fid']; ?>">
                                    <button type="submit" name="delete_ftd" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-700">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Modal -->
    <div id="viewModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">FTD Details</h3>
                    <div id="ftdDetails" class="space-y-2"></div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button onclick="closeModal()" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewFTD(fid) {
            fetch('get_ftd_details.php?fid=' + fid)
                .then(response => response.json())
                .then(data => {
                    let details = '';
                    for (const [key, value] of Object.entries(data)) {
                        details += <div><strong>${key}:</strong> ${value}</div>;
                    }
                    document.getElementById('ftdDetails').innerHTML = details;
                    document.getElementById('viewModal').classList.remove('hidden');
                })
                .catch(error => console.error('Error fetching FTD details:', error));
        }

        function closeModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }
    </script>
</body>
</html>