<?php
session_start();
if ($_SESSION['role'] != 'super_admin') {
    header("Location: dashboard.php");
    exit();
}

include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // No hashing here
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
    header("Location: add_admin.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password']; // No hashing here
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET username=?, password=?, role=? WHERE id=?");
    $stmt->bind_param("sssi", $username, $password, $role, $id);
    $stmt->execute();
    header("Location: add_admin.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: add_admin.php");
}

$user_records = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Manage Users</h1>
        <form method="post" class="mb-8 p-4 bg-white shadow-md rounded">
            <h2 class="text-xl font-bold mb-4">Add User</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select id="role" name="role" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="super_admin">Super Admin</option>
                        <option value="order_admin">Order Admin</option>
                        <option value="filler_admin">Filler Admin</option>
                        <option value="ftd_admin">FTD Admin</option>
                    </select>
                </div>
            </div>
            <button type="submit" name="add_user" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Add User</button>
        </form>

        <h2 class="text-2xl font-bold mb-4">User List</h2>
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200">ID</th>
                    <th class="py-2 px-4 border-b border-gray-200">Username</th>
                    <th class="py-2 px-4 border-b border-gray-200">Password</th>
                    <th class="py-2 px-4 border-b border-gray-200">Role</th>
                    <th class="py-2 px-4 border-b border-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($record = $user_records->fetch_assoc()) { ?>
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $record['id']; ?></td>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $record['username']; ?></td>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $record['password']; ?></td>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $record['role']; ?></td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <form method="post" class="inline-block">
                            <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
                            <button type="button" onclick="openUpdateModal(<?php echo $record['id']; ?>, '<?php echo $record['username']; ?>', '<?php echo $record['password']; ?>', '<?php echo $record['role']; ?>')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-2 rounded">Update</button>
                        </form>
                        <form method="post" class="inline-block">
                            <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
                            <button type="submit" name="delete_user" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div id="updateModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Update User</h3>
                        <div class="mt-2">
                            <form method="post">
                                <input type="hidden" id="update_id" name="id">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="update_username" class="block text-sm font-medium text-gray-700">Username</label>
                                        <input type="text" id="update_username" name="username" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div>
                                        <label for="update_password" class="block text-sm font-medium text-gray-700">Password</label>
                                        <input type="text" id="update_password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div>
                                        <label for="update_role" class="block text-sm font-medium text-gray-700">Role</label>
                                        <select id="update_role" name="role" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="super_admin">Super Admin</option>
                                            <option value="order_admin">Order Admin</option>
                                            <option value="filler_admin">Filler Admin</option>
                                            <option value="ftd_admin">FTD Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" name="update_user" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Update User</button>
                                <button type="button" onclick="closeUpdateModal()" class="mt-4 ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openUpdateModal(id, username, password, role) {
                document.getElementById('update_id').value = id;
                document.getElementById('update_username').value = username;
                document.getElementById('update_password').value = password;
                document.getElementById('update_role').value = role;
                document.getElementById('updateModal').classList.remove('hidden');
            }

            function closeUpdateModal() {
                document.getElementById('updateModal').classList.add('hidden');
            }
        </script>
    </div>
</body>
</html>
