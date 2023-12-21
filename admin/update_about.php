<?php
// Include your database connection file
include 'config.php';
include 'header.php';

// Initialize variables to store form data
$title = $description = $imagePath = $role = $roleDescription = $birthday = $website = $phone = $city = $age = $qualification = $email = $freelanceStatus = $additionalInformation = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data as needed

    // Assign form data to variables
    $title = $_POST['title'];
    $description = $_POST['description'];
    $role = $_POST['role'];
    $roleDescription = $_POST['role_description'];
    $birthday = $_POST['birthday'];
    $website = $_POST['website'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $age = $_POST['age'];
    $qualification = $_POST['qualification'];
    $email = $_POST['email'];
    $freelanceStatus = isset($_POST['freelance_status']) ? 1 : 0;
    $additionalInformation = $_POST['additional_information'];

// Check if a new image file is uploaded
if ($_FILES['image']['size'] > 0) {
    // Use the existing image name as the new image name
    $newImageName = pathinfo($_POST['existing_image_path'], PATHINFO_FILENAME) . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    // Define the upload directory
    $uploadDirectory = '../assets/img/';

    // Set the new image path
    $imagePath = $uploadDirectory . $newImageName;

    // Move the uploaded file to the upload directory
    
    $dbImgPath = $_POST['existing_image_path'];
    
    // Remove the previous image file
    if (file_exists($_POST['existing_image_path'])) {
        unlink($_POST['existing_image_path']);
    }

    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
} else {
    // If no new image is uploaded, use the existing image path
    $imagePath = $_POST['existing_image_path'];
}

    // Update data in the 'about' table
    $aboutUpdateQuery = "UPDATE about SET
        title = '$title',
        description = '$description',
        image_path = '$dbImgPath',
        role = '$role',
        role_description = '$roleDescription',
        birthday = '$birthday',
        website = '$website',
        phone = '$phone',
        city = '$city',
        age = '$age',
        qualification = '$qualification',
        email = '$email',
        freelance_status = '$freelanceStatus',
        additional_information = '$additionalInformation'
    WHERE id = 1";

    if ($conn->query($aboutUpdateQuery) === TRUE) {
        echo "About information updated successfully!";
    } else {
        echo "Error: " . $aboutUpdateQuery . "<br>" . $conn->error;
    }
}

// Fetch existing data for ID 1
$aboutQuery = "SELECT * FROM about WHERE id = 1";
$aboutResult = $conn->query($aboutQuery);

if ($aboutResult->num_rows > 0) {
    $aboutData = $aboutResult->fetch_assoc();

    // Assign existing data to variables
    $title = $aboutData['title'];
    $description = $aboutData['description'];
    $imagePath = $aboutData['image_path'];
    $role = $aboutData['role'];
    $roleDescription = $aboutData['role_description'];
    $birthday = $aboutData['birthday'];
    $website = $aboutData['website'];
    $phone = $aboutData['phone'];
    $city = $aboutData['city'];
    $age = $aboutData['age'];
    $qualification = $aboutData['qualification'];
    $email = $aboutData['email'];
    $freelanceStatus = $aboutData['freelance_status'];
    $additionalInformation = $aboutData['additional_information'];
}

// Close the database connection
$conn->close();
?>


<section class="content-header">
    <h1>Update About</h1>
</section>

<section class="content">
    <div class="row">
        <!-- This is inside the header -->
        <div class="container mt-5">
            <h2>Update Data</h2>

            <!-- About Form -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <!-- Add form fields based on your table structure -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea class="form-control" name="description" required><?php echo $description; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label>
                    <input type="file" class="form-control" name="image" accept=".png">
                    <!-- Hidden field to store existing image path -->
                    <input type="hidden" name="existing_image_path" value="<?php echo $imagePath; ?>">
                    <!-- Display existing image or the newly uploaded image -->
                    <?php if ($imagePath) : ?>
                        <img src="../<?php echo $imagePath; ?>" alt="Existing Image" class="mt-2" style="max-width: 200px;">
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role:</label>
                    <input type="text" class="form-control" name="role" value="<?php echo $role; ?>">
                </div>
                <div class="mb-3">
                    <label for="role_description" class="form-label">Role Description:</label>
                    <textarea class="form-control" name="role_description"><?php echo $roleDescription; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">Birthday:</label>
                    <input type="text" class="form-control" name="birthday" value="<?php echo $birthday; ?>">
                </div>
                <div class="mb-3">
                    <label for="website" class="form-label">Website:</label>
                    <input type="text" class="form-control" name="website" value="<?php echo $website; ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City:</label>
                    <input type="text" class="form-control" name="city" value="<?php echo $city; ?>">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age:</label>
                    <input type="text" class="form-control" name="age" value="<?php echo $age; ?>">
                </div>
                <div class="mb-3">
                    <label for="qualification" class="form-label">Qualification:</label>
                    <input type="text" class="form-control" name="qualification" value="<?php echo $qualification; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
                <div class="mb-3 form-check">
                    <label class="form-check-label" for="freelance_status">Freelance Status</label>
                    <input type="checkbox" id="freelance_status" class="form-check-input" name="freelance_status" <?php echo $freelanceStatus == 1 ? 'checked' : ''; ?>>
                </div>
                <div class="mb-3">
                    <label for="additional_information" class="form-label">Additional Information:</label>
                    <textarea class="form-control" name="additional_information"><?php echo $additionalInformation; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update About Data</button>
            </form>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
