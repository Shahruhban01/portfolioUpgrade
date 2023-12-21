<?php
// Include your database connection file
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle header form submission
    if (isset($_POST['title'], $_POST['meta_description'], $_POST['meta_keywords'])) {
        $title = $_POST['title'];
        $metaDescription = $_POST['meta_description'];
        $metaKeywords = $_POST['meta_keywords'];

        // Insert data into the 'headers' table
        $headerInsertQuery = "INSERT INTO headers (title, meta_description, meta_keywords) VALUES ('$title', '$metaDescription', '$metaKeywords')";
        $conn->query($headerInsertQuery);
    }

    // Handle content form submission
    if (isset($_POST['hero_title'], $_POST['hero_subtitle'], $_POST['resume_link'])) {
        $heroTitle = $_POST['hero_title'];
        $heroSubtitle = $_POST['hero_subtitle'];
        $resumeLink = $_POST['resume_link'];

        // Insert data into the 'contents' table
        $contentInsertQuery = "INSERT INTO contents (hero_title, hero_subtitle, resume_link) VALUES ('$heroTitle', '$heroSubtitle', '$resumeLink')";
        $conn->query($contentInsertQuery);
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Insert Data</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2>Insert Data</h2>

        <!-- Header Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h3>Header Information</h3>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="meta_description">Meta Description:</label>
                <input type="text" class="form-control" name="meta_description" required>
            </div>
            <div class="form-group">
                <label for="meta_keywords">Meta Keywords:</label>
                <input type="text" class="form-control" name="meta_keywords" required>
            </div>
            <button type="submit" class="btn btn-primary">Insert Header Data</button>
        </form>

        <!-- Content Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4">
            <h3>Content Information</h3>
            <div class="form-group">
                <label for="hero_title">Hero Title:</label>
                <input type="text" class="form-control" name="hero_title" required>
            </div>
            <div class="form-group">
                <label for="hero_subtitle">Hero Subtitle:</label>
                <input type="text" class="form-control" name="hero_subtitle" required>
            </div>
            <div class="form-group">
                <label for="resume_link">Resume Link:</label>
                <input type="text" class="form-control" name="resume_link" required>
            </div>
            <button type="submit" class="btn btn-primary">Insert Content Data</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
