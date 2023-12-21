<?php
// Include your database connection file
include 'config.php';
include 'header.php';

// Fetch existing data from the 'contents' table
$contentQuery = "SELECT * FROM contents";
$contentResult = $conn->query($contentQuery);

// Initialize variables to store fetched data
$existingData = array();

if ($contentResult->num_rows > 0) {
    $existingData = $contentResult->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle content form submission
    if (isset($_POST['hero_title'], $_POST['hero_subtitle'], $_POST['resume_link'])) {
        $heroTitle = $_POST['hero_title'];
        $heroSubtitle = $_POST['hero_subtitle'];
        $resumeLink = $_POST['resume_link'];

        // Social Media Links
        $twitterLink = isset($_POST['twitter_link']) ? $_POST['twitter_link'] : '';
        $facebookLink = isset($_POST['facebook_link']) ? $_POST['facebook_link'] : '';
        $instagramLink = isset($_POST['instagram_link']) ? $_POST['instagram_link'] : '';
        $skypeLink = isset($_POST['skype_link']) ? $_POST['skype_link'] : '';
        $linkedinLink = isset($_POST['linkedin_link']) ? $_POST['linkedin_link'] : '';

        // Check if data already exists in the 'contents' table
        if ($contentResult->num_rows > 0) {
            // Update data in the 'contents' table
            $contentUpdateQuery = "UPDATE contents SET hero_title = '$heroTitle', hero_subtitle = '$heroSubtitle', resume_link = '$resumeLink',
                twitter_link = '$twitterLink', facebook_link = '$facebookLink', instagram_link = '$instagramLink',
                skype_link = '$skypeLink', linkedin_link = '$linkedinLink'";
            $conn->query($contentUpdateQuery);
        } else {
            // Insert data into the 'contents' table
            $contentInsertQuery = "INSERT INTO contents (hero_title, hero_subtitle, resume_link, twitter_link, facebook_link, instagram_link, skype_link, linkedin_link)
                VALUES ('$heroTitle', '$heroSubtitle', '$resumeLink', '$twitterLink', '$facebookLink', '$instagramLink', '$skypeLink', '$linkedinLink')";
            $conn->query($contentInsertQuery);
        }

        // Fetch the updated data after submission
        $contentResult = $conn->query($contentQuery);
        $existingData = $contentResult->fetch_assoc();
    }
}

// Close the database connection
$conn->close();
?>



<section class="content-header">
    <h1>Update Content</h1>
</section>

<section class="content">
    <div class="row">

<section class="content">
    <div class="container mt-5">
        <h2>Update Content</h2>

        <!-- Content Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4">
        <div class="form-group">
    <label for="hero_title">Hero Title:</label>
    <input type="text" class="form-control" name="hero_title" value="<?php echo htmlspecialchars($existingData['hero_title']); ?>">
</div>
<div class="form-group">
    <label for="hero_subtitle">Hero Subtitle:</label>
    <input type="text" class="form-control" name="hero_subtitle" value="<?php echo htmlspecialchars($existingData['hero_subtitle']); ?>">
</div>
<div class="form-group">
    <label for="resume_link">Resume Link:</label>
    <input type="text" class="form-control" name="resume_link" value="<?php echo htmlspecialchars($existingData['resume_link']); ?>">
</div>

            <!-- Social Media Links -->
            <h3>Social Media Links</h3>
            <div class="form-group">
                <label for="twitter_link">Twitter Link:</label>
                <input type="text" class="form-control" name="twitter_link" value="<?php echo htmlspecialchars($existingData['twitter_link']); ?>">
            </div>
            <div class="form-group">
                <label for="facebook_link">Facebook Link:</label>
                <input type="text" class="form-control" name="facebook_link" value="<?php echo htmlspecialchars($existingData['facebook_link']); ?>">
            </div>
            <div class="form-group">
                <label for="instagram_link">Instagram Link:</label>
                <input type="text" class="form-control" name="instagram_link" value="<?php echo htmlspecialchars($existingData['instagram_link']); ?>">
            </div>
            <div class="form-group">
                <label for="skype_link">Skype Link:</label>
                <input type="text" class="form-control" name="skype_link" value="<?php echo htmlspecialchars($existingData['skype_link']); ?>">
            </div>
            <div class="form-group">
                <label for="linkedin_link">LinkedIn Link:</label>
                <input type="text" class="form-control" name="linkedin_link" value="<?php echo htmlspecialchars($existingData['linkedin_link']); ?>">
            </div>

            <button type="submit" class="btn btn-primary">Update Content Data</button>
        </form>
    </div>


    </div>

</section>

<?php include "footer.php"; ?>