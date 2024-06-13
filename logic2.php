<?php
// Assuming you have a database connection established
$conn = mysqli_connect("localhost", "root", "", "upwork4");

// Step 1: Check approved orders
$query = "SELECT * FROM orders WHERE approval = 'Yes'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Fetch the order details
    $orderRow = mysqli_fetch_assoc($result);
    
    // Step 2: Ftd Selection
    // Query to count the number of ftds that have not been used by our_network
    $ftdQuery = "SELECT COUNT(*) AS total_unused FROM ftd WHERE our_network IS NULL";
    $ftdResult = mysqli_query($conn, $ftdQuery);
    $ftdRow = mysqli_fetch_assoc($ftdResult);
    $numUnusedFtd = $ftdRow['total_unused'];

    // Check if the number of unused ftds is greater than 0
    if ($numUnusedFtd > 0) {
        // Loop through ftd to update them as used by our_network
        while ($numUnusedFtd > 0) {
            // Retrieve the next available ftd ID
            $ftdQuery = "SELECT fid FROM ftd WHERE our_network IS NULL LIMIT 1";
            $ftdResult = mysqli_query($conn, $ftdQuery);
            $ftdRow = mysqli_fetch_assoc($ftdResult);
            $ftdId = $ftdRow['fid'];
            
            // Update the ftd to mark them as used by our_network
            $updateFtdQuery = "UPDATE ftd SET our_network = '{$orderRow['our_network_today']}', client_network = '{$orderRow['brand_name']}' WHERE fid = $ftdId";
            mysqli_query($conn, $updateFtdQuery);
            $numUnusedFtd--; // Decrease the count of unused ftd
            
            echo "Filler with ID: $ftdId updated.<br>";
        }
    
        

        // Insert the approved order into the brand_table
        $brandTableQuery = "INSERT INTO brand_table ( brand_name, aff_manager_id) VALUES ('" . $orderRow['brand_name'] . "', '" . $orderRow['aff_manager_id'] . "')";
        mysqli_query($conn, $brandTableQuery);

        echo "Order successfully processed and injected.";
    } else {
        echo "Not enough unused ftd available.";
    }
} else {
    echo "No approved orders to process.";
}

mysqli_close($conn); 
?>
