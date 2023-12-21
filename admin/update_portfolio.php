<?php
include "header.php";

// Fetch existing data for portfolio description
$portfolioDescriptionQuery = "SELECT * FROM portfolio_description";
$portfolioDescriptionResult = $conn->query($portfolioDescriptionQuery);

if ($portfolioDescriptionResult->num_rows > 0) {
    $portfolioDescriptionData = $portfolioDescriptionResult->fetch_assoc();
    $portfolioDescription = $portfolioDescriptionData['description'];
} else {
    // Default description if no data is available
    $portfolioDescription = "";
}

// Fetch existing data for portfolio items
$portfolioItemsQuery = "SELECT * FROM portfolio_items";
$portfolioItemsResult = $conn->query($portfolioItemsQuery);

if ($portfolioItemsResult->num_rows > 0) {
    $portfolioItemsData = $portfolioItemsResult->fetch_all(MYSQLI_ASSOC);
} else {
    // Default empty array if no data is available
    $portfolioItemsData = [];
}

// Handle form submission for updating portfolio description
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateDescription'])) {
    $newDescription = $_POST['description'];

    // Update data in the 'portfolio_description' table
    $updateDescriptionQuery = "UPDATE portfolio_description SET description = ?";
    $stmt = $conn->prepare($updateDescriptionQuery);
    $stmt->bind_param("s", $newDescription);
    $stmt->execute();
    $stmt->close();

    // Fetch the updated data
    $portfolioDescription = $newDescription;
}

// Handle form submission for updating portfolio items
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateItems'])) {
    $newItems = $_POST['items'];

    // Delete existing data in the 'portfolio_items' table
    $deleteItemsQuery = "DELETE FROM portfolio_items";
    $conn->query($deleteItemsQuery);

    // Insert new data into the 'portfolio_items' table
    $insertItemsQuery = "INSERT INTO portfolio_items (image_path, category, title, details_link, gallery_link) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertItemsQuery);

    foreach ($newItems as $item) {
        $stmt->bind_param("sssss", $item['image_path'], $item['category'], $item['title'], $item['details_link'], $item['gallery_link']);
        $stmt->execute();
    }

    $stmt->close();

    // Fetch the updated data
    $portfolioItemsQuery = "SELECT * FROM portfolio_items";
    $portfolioItemsResult = $conn->query($portfolioItemsQuery);

    if ($portfolioItemsResult->num_rows > 0) {
        $portfolioItemsData = $portfolioItemsResult->fetch_all(MYSQLI_ASSOC);
    } else {
        // Default empty array if no data is available
        $portfolioItemsData = [];
    }
}

// Close the database connection
$conn->close();
?>

<section class="content-header">
    <h1>Update Portfolio</h1>
</section>

<section class="content">
    <div class="row">
<!-- HTML form for updating portfolio items -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h2>Update Portfolio Items</h2>
    <?php
    foreach ($portfolioItemsData as $index => $item) {
    ?>
    <hr style="border: 1px solid #3c8dbc;">
        <div class="form-group">
            <label for="items[<?php echo $index; ?>][image_path]">Image Path:</label>
            <input type="text" class="form-control" name="items[<?php echo $index; ?>][image_path]" value="<?php echo $item['image_path']; ?>" required>
        </div>

        <div class="form-group">
            <label for="items[<?php echo $index; ?>][category]">Category:</label>
            <input type="text" class="form-control" name="items[<?php echo $index; ?>][category]" value="<?php echo $item['category']; ?>" required>
        </div>

        <div class="form-group">
            <label for="items[<?php echo $index; ?>][title]">Title:</label>
            <input type="text" class="form-control" name="items[<?php echo $index; ?>][title]" value="<?php echo $item['title']; ?>" required>
        </div>

        <div class="form-group">
            <label for="items[<?php echo $index; ?>][details_link]">Details Link:</label>
            <input type="text" class="form-control" name="items[<?php echo $index; ?>][details_link]" value="<?php echo $item['details_link']; ?>" required>
        </div>

        <div class="form-group">
            <label for="items[<?php echo $index; ?>][gallery_link]">Gallery Link:</label>
            <input type="text" class="form-control" name="items[<?php echo $index; ?>][gallery_link]" value="<?php echo $item['gallery_link']; ?>" required>
        </div>

    <?php
    }
    ?>
    <input type="submit" name="updateItems" class="btn btn-primary" value="Update Items">
</form>


</div>

</section>

<?php include "footer.php"; ?>