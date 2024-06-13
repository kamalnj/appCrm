<?php
session_start();
if (!in_array($_SESSION['role'], ['super_admin', 'order_admin', 'ftd_admin'])) {
    header("Location: dashboard.php");
    exit();
}

include('config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_csv'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file = $_FILES['csv_file']['tmp_name'];
        $handle = fopen($file, "r");
        
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $fid = $data[0];
            $email = $data[1];
            $email_password = $data[2];
            $extension = $data[3];
            $phone_number = $data[4];
            $whatsapp = $data[5];
            $viber = $data[6];
            $messenger = $data[7];
            $dob = $data[8];
            $address = $data[9];
            $country = $data[10];
            $date_created = $data[11];
            $front_id = $data[12];
            $back_id = $data[13];
            $selfie_front = $data[14];
            $selfie_back = $data[15];
            $remark = $data[16];
            $profile_picture = $data[17];
            $our_network = $data[18];
            $client_network = $data[19];
            $broker = $data[20];
            
            $stmt = $conn->prepare("INSERT INTO ftd (fid, email, email_password, extension, phone_number, whatsapp, viber, messenger, dob, address, country, date_created, front_id, back_id, selfie_front, selfie_back, remark, profile_picture, our_network, client_network, broker) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssssssssssss", $fid, $email, $email_password, $extension, $phone_number, $whatsapp, $viber, $messenger, $dob, $address, $country, $date_created, $front_id, $back_id, $selfie_front, $selfie_back, $remark, $profile_picture, $our_network, $client_network, $broker);
            $stmt->execute();
        }
        fclose($handle);
        header("Location: manage_ftd.php");
    }
}


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

    // Check for duplicate fid
    $check_stmt = $conn->prepare("SELECT fid FROM ftd WHERE fid = ?");
    $check_stmt->bind_param("s", $fid);
    $check_stmt->execute();
    $check_stmt->store_result();
    if ($check_stmt->num_rows > 0) {
        // Handle duplicate fid case
        echo "Error: Duplicate FID detected. Please use a unique FID.";
    } else {
        // Proceed with insertion
        $stmt = $conn->prepare("INSERT INTO ftd (fid, email, email_password, extension, phone_number, whatsapp, viber, messenger, dob, address, country, date_created, front_id, back_id, selfie_front, selfie_back, remark, profile_picture, our_network, client_network, broker) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssssssssssss", $fid, $email, $email_password, $extension, $phone_number, $whatsapp, $viber, $messenger, $dob, $address, $country, $date_created, $front_id, $back_id, $selfie_front, $selfie_back, $remark, $profile_picture, $our_network, $client_network, $broker);
        $stmt->execute();
        header("Location: manage_ftd.php");
    }
    $check_stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_ftd'])) {
    $fid = $_POST['ftd_id'];
    mysqli_query($conn, "DELETE FROM ftd WHERE fid='$fid'");
    header("Location: manage_ftd.php");
}

$ftds = mysqli_query($conn, "SELECT * FROM ftd");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage FTD</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        input{
            padding: 8px;
        }
        div#viewModal div.shadow-lg {
            margin: 0 auto;
            margin-top: 50px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container px-6 mx-auto py-8">
        <a href="dashboard.php"><button class="mt-4 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">Back To Dashboard</button></a> <br><br>
        <h1 class="text-3xl text-center font-bold mb-4">Manage FTD</h1>
        <form method="post" enctype="multipart/form-data" class="space-y-4">
    <div class="mb-4">
        <label for="csv_file" class="block text-sm font-medium text-gray-700">Upload CSV:</label>
        <input type="file" id="csv_file" name="csv_file" accept=".csv" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
    </div>
    <button type="submit" name="upload_csv" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Upload CSV</button>
</form>
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
                    <input type="date" id="date_created" name="date_created" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                    <textarea id="remark" name="remark" rows="5" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
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
            <div class="text-center">
                <button type="submit" name="add_ftd" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add FTD</button>
            </div>
        </form>
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">FTD Records</h2>
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">FID</th>
                        <th class="py-2 px-4 text-left">Email</th>
                        <th class="py-2 px-4 text-left">Date Created</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($ftd = mysqli_fetch_assoc($ftds)) { ?>
                    <tr>
                        <td class="py-2 px-4"><?php echo $ftd['fid']; ?></td>
                        <td class="py-2 px-4"><?php echo $ftd['email']; ?></td>
                        <td class="py-2 px-4"><?php echo $ftd['date_created']; ?></td>
                        <td class="py-2 px-4">
                            <button class="view-ftd-btn inline-flex items-center px-2 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" data-fid="<?php echo $ftd['fid']; ?>">View</button>
                            <a href="update_ftd.php?id=<?php echo $ftd['fid']; ?>" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-700">Edit</a>
                            <form method="post" class="inline-block">
                                <input type="hidden" name="ftd_id" value="<?php echo $ftd['fid']; ?>">
                                <button type="submit" name="delete_ftd" class="inline-flex items-center px-2 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="viewModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75  items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl">
            <h2 class="text-2xl font-bold mb-4">FTD Details</h2>
            <div id="ftdDetails">
            </div>
            <div class="mt-4 text-right">
                <button id="closeModal" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Close</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.view-ftd-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const fid = this.getAttribute('data-fid');
                    fetch(`get_ftd_details.php?fid=${fid}`)
                        .then(response => response.json())
                        .then(data => {
                            const detailsDiv = document.getElementById('ftdDetails');
                            detailsDiv.innerHTML = `
                                <p><strong>FID:</strong> ${data.fid}</p>
                                <p><strong>Email:</strong> ${data.email}</p>
                                <p><strong>Telegram:</strong> ${data.telegram}</p>
                                <p><strong>WhatsApp:</strong> ${data.whatsapp}</p>
                                <p><strong>Messenger:</strong> ${data.messenger}</p>
                                <p><strong>DOB:</strong> ${data.dob}</p>
                                <p><strong>Address:</strong> ${data.address}</p>
                                <p><strong>Country:</strong> ${data.country}</p>
                                <p><strong>Date Created:</strong> ${data.date_created}</p>
                                <p><strong>Front ID:</strong> ${data.front_id}</p>
                                <p><strong>Back ID:</strong> ${data.back_id}</p>
                                <p><strong>Selfie Front:</strong> ${data.selfie_front}</p>
                                <p><strong>Selfie Back:</strong> ${data.selfie_back}</p>
                                <p><strong>Remark:</strong> ${data.remark}</p>
                                <p><strong>Profile Picture:</strong> ${data.profile_picture}</p>
                                <p><strong>Our Network:</strong> ${data.our_network}</p>
                                <p><strong>Client Network:</strong> ${data.client_network}</p>
                                <p><strong>Broker:</strong> ${data.broker}</p>
                            `;
                            document.getElementById('viewModal').classList.remove('hidden');
                        });
                });
            });

            document.getElementById('closeModal').addEventListener('click', function () {
                document.getElementById('viewModal').classList.add('hidden');
            });
        });
    </script>
</body>
</html>
