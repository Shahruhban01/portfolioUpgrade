<?php
// Include your database connection file
include "config.php";

// Function to get the client's IP address
function getIpAddress() {
    // Check for shared Internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // Check for IP address from a proxy or load balancer
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    // Check for the regular remote address
    if (!empty($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) {
        return $_SERVER['REMOTE_ADDR'];
    }

    // Return a default IP address if none of the above is found
    return '0.0.0.0';
}

// Get the visitor's IP address
$ipAddress = getIpAddress();

// Get the current date and time
$visitDatetime = date('Y-m-d H:i:s');

// Insert visitor data into the database
$insertVisitorQuery = "INSERT INTO visitors (ip_address, visit_datetime) VALUES ('$ipAddress', '$visitDatetime')";

if ($conn->query($insertVisitorQuery) === TRUE) {
    echo "Visitor recorded successfully";
} else {
    echo "Error recording visitor: " . $conn->error;
}

$conn->close();
?>
