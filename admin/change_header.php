<?php
// Include your database connection file
include 'config.php';
include 'header.php';

// Initialize variables to store form data
$title = $metaDescription = $metaKeywords = '';
$existingFavicons = [];

// Fetch existing data for headers
$headerQuery = "SELECT * FROM headers";
$headerResult = $conn->query($headerQuery);

if ($headerResult->num_rows > 0) {
    $headerData = $headerResult->fetch_assoc();

    // Assign existing data to variables
    $title = $headerData['title'];
    $metaDescription = $headerData['meta_description'];
    $metaKeywords = $headerData['meta_keywords'];
}

// Fetch existing data for favicons
$faviconQuery = "SELECT * FROM favicons";
$faviconResult = $conn->query($faviconQuery);

if ($faviconResult->num_rows > 0) {
    $existingFavicons = $faviconResult->fetch_assoc();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle header form submission
    if (isset($_POST['title'], $_POST['meta_description'], $_POST['meta_keywords'])) {
        $title = $_POST['title'];
        $metaDescription = $_POST['meta_description'];
        $metaKeywords = $_POST['meta_keywords'];

        // Check if data already exists in the 'headers' table
        $headerQuery = "SELECT * FROM headers";
        $headerResult = $conn->query($headerQuery);

        if ($headerResult->num_rows > 0) {
            // Update data in the 'headers' table
            $headerUpdateQuery = "UPDATE headers SET title = '$title', meta_description = '$metaDescription', meta_keywords = '$metaKeywords'";
            $conn->query($headerUpdateQuery);
        } else {
            // Insert data into the 'headers' table
            $headerInsertQuery = "INSERT INTO headers (title, meta_description, meta_keywords) VALUES ('$title', '$metaDescription', '$metaKeywords')";
            $conn->query($headerInsertQuery);
        }
    }

    // Handle favicon form submission
    if (isset($_FILES['favicon_file'], $_FILES['apple_touch_icon_file'], $_FILES['favicon_192_file'], $_FILES['favicon_512_file'], $_FILES['favicon_16_file'], $_FILES['favicon_32_file'], $_FILES['manifest_file'])) {
        $faviconFile = $_FILES['favicon_file'];
        $appleTouchIconFile = $_FILES['apple_touch_icon_file'];
        $favicon192File = $_FILES['favicon_192_file'];
        $favicon512File = $_FILES['favicon_512_file'];
        $favicon16File = $_FILES['favicon_16_file'];
        $favicon32File = $_FILES['favicon_32_file'];
        $manifestFile = $_FILES['manifest_file'];

        // Assuming you have a folder named 'uploads' to store the favicon files
        $uploadDir = '../assets/img/favicon/';

        // Get the file links before updating
        $faviconQuery = "SELECT * FROM favicons";
        $faviconResult = $conn->query($faviconQuery);

        // Initialize old file paths
        $oldFaviconPath = $oldAppleTouchIconPath = $oldFavicon192Path = $oldFavicon512Path = $oldFavicon16Path = $oldFavicon32Path = $oldManifestPath = $uploadDir;

        if ($faviconResult->num_rows > 0) {
            $faviconRow = $faviconResult->fetch_assoc();
            $oldFaviconPath .= $faviconRow['favicon_link'];
            $oldAppleTouchIconPath .= $faviconRow['apple_touch_icon_link'];
            $oldFavicon192Path .= $faviconRow['favicon_192_link'];
            $oldFavicon512Path .= $faviconRow['favicon_512_link'];
            $oldFavicon16Path .= $faviconRow['favicon_16_link'];
            $oldFavicon32Path .= $faviconRow['favicon_32_link'];
            $oldManifestPath .= $faviconRow['manifest_link'];
        }

        // Delete old files
        if (!empty($oldFaviconPath) && file_exists($oldFaviconPath)) {
            unlink($oldFaviconPath);
        }
        if (!empty($oldAppleTouchIconPath) && file_exists($oldAppleTouchIconPath)) {
            unlink($oldAppleTouchIconPath);
        }
        if (!empty($oldFavicon192Path) && file_exists($oldFavicon192Path)) {
            unlink($oldFavicon192Path);
        }
        if (!empty($oldFavicon512Path) && file_exists($oldFavicon512Path)) {
            unlink($oldFavicon512Path);
        }
        if (!empty($oldFavicon16Path) && file_exists($oldFavicon16Path)) {
            unlink($oldFavicon16Path);
        }
        if (!empty($oldFavicon32Path) && file_exists($oldFavicon32Path)) {
            unlink($oldFavicon32Path);
        }
        if (!empty($oldManifestPath) && file_exists($oldManifestPath)) {
            unlink($oldManifestPath);
        }

        // Move the uploaded files to the 'uploads' folder
        move_uploaded_file($faviconFile['tmp_name'], $uploadDir . $faviconFile['name']);
        move_uploaded_file($appleTouchIconFile['tmp_name'], $uploadDir . $appleTouchIconFile['name']);
        move_uploaded_file($favicon192File['tmp_name'], $uploadDir . $favicon192File['name']);
        move_uploaded_file($favicon512File['tmp_name'], $uploadDir . $favicon512File['name']);
        move_uploaded_file($favicon16File['tmp_name'], $uploadDir . $favicon16File['name']);
        move_uploaded_file($favicon32File['tmp_name'], $uploadDir . $favicon32File['name']);
        move_uploaded_file($manifestFile['tmp_name'], $uploadDir . $manifestFile['name']);

        // Get the file links
        $faviconLink = $uploadDir . $faviconFile['name'];
        $appleTouchIconLink = $uploadDir . $appleTouchIconFile['name'];
        $favicon192Link = $uploadDir . $favicon192File['name'];
        $favicon512Link = $uploadDir . $favicon512File['name'];
        $favicon16Link = $uploadDir . $favicon16File['name'];
        $favicon32Link = $uploadDir . $favicon32File['name'];
        $manifestLink = $uploadDir . $manifestFile['name'];

        // Check if data already exists in the 'favicons' table
        $faviconQuery = "SELECT * FROM favicons";
        $faviconResult = $conn->query($faviconQuery);

        if ($faviconResult->num_rows > 0) {
            // Update data in the 'favicons' table
            // $faviconUpdateQuery = "UPDATE favicons SET favicon_link = '$faviconLink', apple_touch_icon_link = '$appleTouchIconLink', favicon_192_link = '$favicon192Link', favicon_512_link = '$favicon512Link', favicon_16_link = '$favicon16Link', favicon_32_link = '$favicon32Link', manifest_link = '$manifestLink'";
            // $conn->query($faviconUpdateQuery);
        } else {
            // Insert data into the 'favicons' table
            $faviconInsertQuery = "INSERT INTO favicons (favicon_link, apple_touch_icon_link, favicon_192_link, favicon_512_link, favicon_16_link, favicon_32_link, manifest_link) VALUES ('$faviconLink', '$appleTouchIconLink', '$favicon192Link', '$favicon512Link', '$favicon16Link', '$favicon32Link', '$manifestLink')";
            $conn->query($faviconInsertQuery);
        }
    }

    // Handle additional CSS form submission
    if (isset($_POST['css_link'])) {
        $cssLink = $_POST['css_link'];

        // Insert data into the 'additional_css' table
        $cssInsertQuery = "INSERT INTO additional_css (css_link) VALUES ('$cssLink')";
        $conn->query($cssInsertQuery);
    }

    // Handle additional JS form submission
    if (isset($_POST['js_link'])) {
        $jsLink = $_POST['js_link'];

        // Insert data into the 'additional_js' table
        $jsInsertQuery = "INSERT INTO additional_js (js_link) VALUES ('$jsLink')";
        $conn->query($jsInsertQuery);
    }
}

// Close the database connection
$conn->close();
?>

<section class="content-header">
    <h1>Home</h1>
</section>

<section class="content">
    <div class="row">
        <!-- This is inside the header -->
        <div class="container mt-5">
            <h2>Insert Data</h2>

            <!-- Header Form -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h3>Header Information</h3>
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
                </div>
                <div class="form-group">
                    <label for="meta_description">Meta Description:</label>
                    <input type="text" class="form-control" name="meta_description" value="<?php echo $metaDescription; ?>">
                </div>
                <div class="form-group">
                    <label for="meta_keywords">Meta Keywords:</label>
                    <input type="text" class="form-control" name="meta_keywords" value="<?php echo $metaKeywords; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Insert/Update Header Data</button>
            </form>

            <!-- Favicon Form -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4" enctype="multipart/form-data">
                <h3>Favicon Information</h3>
                <?php if (!empty($existingFavicons)): ?>
                    <div class="mb-3">
                        <h4>Existing Favicons</h4>
                        <ul>
                            <li>Favicon: <?php echo $existingFavicons['favicon_link']; ?></li>
                            <li>Apple Touch Icon: <?php echo $existingFavicons['apple_touch_icon_link']; ?></li>
                            <li>Favicon 192x192: <?php echo $existingFavicons['favicon_192_link']; ?></li>
                            <li>Favicon 512x512: <?php echo $existingFavicons['favicon_512_link']; ?></li>
                            <li>Favicon 16x16: <?php echo $existingFavicons['favicon_16_link']; ?></li>
                            <li>Favicon 32x32: <?php echo $existingFavicons['favicon_32_link']; ?></li>
                            <li>Manifest: <?php echo $existingFavicons['manifest_link']; ?></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="favicon_file">Favicon File:</label>
                    <input type="file" class="form-control" name="favicon_file" required>

                    <img src="../<?php echo $existingFavicons['favicon_link']; ?>" alt="Existing Image" class="mt-2" style="max-width: 200px;">
                </div>
                <div class="form-group">
                    <label for="apple_touch_icon_file">Apple Touch Icon File:</label>
                    <input type="file" class="form-control" name="apple_touch_icon_file" required>
                    <img src="../<?php echo $existingFavicons['apple_touch_icon_link']; ?>" alt="Existing Image" class="mt-2" style="max-width: 150px;">
                </div>
                <div class="form-group">
                    <label for="favicon_192_file">Favicon 192x192 File:</label>
                    <input type="file" class="form-control" name="favicon_192_file" required>
                    <img src="../<?php echo $existingFavicons['favicon_192_link']; ?>" alt="Existing Image" class="mt-2" style="max-width: 150px;">
                </div>
                <div class="form-group">
                    <label for="favicon_512_file">Favicon 512x512 File:</label>
                    <input type="file" class="form-control" name="favicon_512_file" required>
                    <img src="../<?php echo $existingFavicons['favicon_512_link']; ?>" alt="Existing Image" class="mt-2" style="max-width: 150px;">
                </div>
                <div class="form-group">
                    <label for="favicon_16_file">Favicon 16x16 File:</label>
                    <input type="file" class="form-control" name="favicon_16_file" required>
                    <img src="../<?php echo $existingFavicons['favicon_16_link']; ?>" alt="Existing Image" class="mt-2" style="max-width: 150px;">
                </div>
                <div class="form-group">
                    <label for="favicon_32_file">Favicon 32x32 File:</label>
                    <input type="file" class="form-control" name="favicon_32_file" required>
                    <img src="../<?php echo $existingFavicons['favicon_32_link']; ?>" alt="Existing Image" class="mt-2" style="max-width: 150px;">
                </div>
                <div class="form-group">
                    <label for="manifest_file">Manifest File:</label>
                    <input type="file" class="form-control" name="manifest_file" required>
                    <?php echo $existingFavicons['manifest_link']; ?>
                </div>
                <button type="submit" class="btn btn-primary">Insert/Update Favicon Data</button>
            </form>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
