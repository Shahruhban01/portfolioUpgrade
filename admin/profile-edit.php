<?php
include "header.php";

// Fetch existing profile data
$adminId = $_SESSION['user_id'];
$profileQuery = "SELECT * FROM admin_users WHERE id = $adminId";
$profileResult = $conn->query($profileQuery);

if ($profileResult->num_rows > 0) {
    $profileData = $profileResult->fetch_assoc();
    $fname = $profileData['Name'];
    $username = $profileData['username'];
    $email = $profileData['email'];
    $profileImage = $profileData['profile_image'];
} else {
    // Handle error or redirect as needed
    echo "Error: Admin profile not found!";
    exit();
}

// Update profile logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $newUsername = $_POST['new_username'];
    $newEmail = $_POST['new_email'];

    // Check if a new profile image is uploaded
    if (!empty($_FILES['profile_image']['name'])) {
        $profileImage = $_FILES['profile_image']['name'];
        $target = "admin_profiles/" . basename($profileImage);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);
    }

    // Perform the update query
    $updateProfileQuery = "UPDATE admin_users SET Name = '$name', username = '$newUsername', email = '$newEmail', profile_image = '$target' WHERE id = $adminId";

    if ($conn->query($updateProfileQuery) === TRUE) {
        echo "Profile updated successfully";
        // You can also redirect the user to a different page after successful update
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

$conn->close();
?>

<section class="content-header">
    <h1>Edit Profile</h1>
</section>

<section class="content">
    <div class="row">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" value="<?php echo $fname; ?>" required>
            </div>

            <div class="mb-3">
                <label for="new_username" class="form-label">Username:</label>
                <input type="text" name="new_username" class="form-control" value="<?php echo $username; ?>" required>
            </div>

            <div class="mb-3">
                <label for="new_email" class="form-label">Email:</label>
                <input type="email" name="new_email" class="form-control" value="<?php echo $email; ?>" required>
            </div>

            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image:</label>
                <input type="file" name="profile_image" class="form-control"><br>
                <img src="<?php echo $profileImage; ?>" alt="profile image" width="160"><br><br>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</section>

<?php include "footer.php"; ?>
