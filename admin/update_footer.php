<?php
include "header.php";

// Fetch existing footer information
$footerInfoQuery = "SELECT * FROM footer_info WHERE id = 1";
$footerInfoResult = $conn->query($footerInfoQuery);

// Check if there is footer information data
if ($footerInfoResult->num_rows > 0) {
    $footerInfoData = $footerInfoResult->fetch_assoc();
    $copyright = $footerInfoData['copyright'];
    $credits = $footerInfoData['credits'];
    $link = $footerInfoData['link'];
} else {
    // Default values if no data is available
    $copyright = "Your Company Name";
    $credits = "Designed by Your Name";
    $link = "https://yourwebsite.com";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $copyright = $_POST["copyright"];
    $credits = $_POST["credits"];
    $link = $_POST["link"];

    // Update footer information in the database
    $updateFooterQuery = "UPDATE footer_info SET copyright='$copyright', credits='$credits', link='$link' WHERE id=1";

    if ($conn->query($updateFooterQuery) === TRUE) {
        echo "Footer information updated successfully";
    } else {
        echo "Error updating footer information: " . $conn->error;
    }
}

$conn->close();

?>

<section class="content-header">
    <h1>Update Footer</h1>
</section>

<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center mb-4">Footer Update</h2>

                    <!-- Add your form or update logic here -->
                    <form action="update_footer" method="post">
                        <div class="mb-3">
                            <label for="copyright" class="form-label">Copyright:</label>
                            <input type="text" class="form-control" name="copyright" id="copyright" value="<?php echo $copyright; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="credits" class="form-label">Credits:</label>
                            <input type="text" class="form-control" name="credits" id="credits" value="<?php echo $credits; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">Link:</label>
                            <input type="text" class="form-control" name="link" id="link" value="<?php echo $link; ?>" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update Footer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
