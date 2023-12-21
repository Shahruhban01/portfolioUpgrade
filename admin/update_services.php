<?php
include "header.php";

// Fetch services description data
$servicesDescriptionQuery = "SELECT * FROM services_description";
$servicesDescriptionResult = $conn->query($servicesDescriptionQuery);

// Check if there is services description data
if ($servicesDescriptionResult->num_rows > 0) {
    $servicesDescriptionData = $servicesDescriptionResult->fetch_assoc();
    $servicesDescription = $servicesDescriptionData['description'];
} else {
    // Default description if no data is available
    $servicesDescription = "Default services description.";
}

// Fetch individual services data
$servicesQuery = "SELECT * FROM services";
$servicesResult = $conn->query($servicesQuery);

// Check if there is individual services data
$servicesData = [];
if ($servicesResult->num_rows > 0) {
    while ($row = $servicesResult->fetch_assoc()) {
        $servicesData[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle services description form submission
    if (isset($_POST['servicesDescription'])) {
        $servicesDescription = $_POST['servicesDescription'];

        // Update data in the 'services_description' table
        $servicesDescriptionUpdateQuery = "UPDATE services_description SET description = ?";
        $stmt = $conn->prepare($servicesDescriptionUpdateQuery);
        $stmt->bind_param("s", $servicesDescription);
        $stmt->execute();
        $stmt->close();
    }

    // Handle individual services form submission
    if (isset($_POST['individualServices'])) {
        $individualServices = $_POST['individualServices'];

        // Clear existing data in the 'services' table
        $clearServicesQuery = "DELETE FROM services";
        $conn->query($clearServicesQuery);

        // Insert new data into the 'services' table
        $insertServicesQuery = "INSERT INTO services (icon, title, description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertServicesQuery);

        foreach ($individualServices as $service) {
            $stmt->bind_param("sss", $service['icon'], $service['title'], $service['description']);
            $stmt->execute();
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<section class="content-header">
    <h1>Update Services</h1>
</section>

<section class="content">
    <div class="row">
        <!-- Services Description Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Update Services Description</h2>
            <div class="form-group">
                <label for="servicesDescription">Services Description:</label>
                <textarea class="form-control" name="servicesDescription" rows="4"><?php echo $servicesDescription; ?></textarea>
            </div>
            <input type="submit" class="btn btn-primary" value="Update Services Description">
        </form>

        <!-- Individual Services Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Update Individual Services</h2>
            <?php
            foreach ($servicesData as $service) {
            ?>
            <hr style="border: 1px solid #3c8dbc;">
                <div class="form-group">
                    <label for="individualServices[<?php echo $service['id']; ?>][icon]">Icon:</label>
                    <input type="text" class="form-control" name="individualServices[<?php echo $service['id']; ?>][icon]" value="<?php echo $service['icon']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="individualServices[<?php echo $service['id']; ?>][title]">Title:</label>
                    <input type="text" class="form-control" name="individualServices[<?php echo $service['id']; ?>][title]" value="<?php echo $service['title']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="individualServices[<?php echo $service['id']; ?>][description]">Description:</label>
                    <textarea class="form-control" name="individualServices[<?php echo $service['id']; ?>][description]" rows="4" required><?php echo $service['description']; ?></textarea>
                </div>
            <?php
            }
            ?>
            <input type="submit" class="btn btn-primary" value="Update Individual Services">
        </form>
    </div>
</section>

<?php include "footer.php"; ?>
