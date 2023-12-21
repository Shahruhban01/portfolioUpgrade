<?php
include "header.php"; 

$location = $email = $phone = $mapIframe = ''; // Initialize variables

// Fetch existing contact information
$contactInfoQuery = "SELECT * FROM contact_info WHERE id=1";
$contactInfoResult = $conn->query($contactInfoQuery);

if ($contactInfoResult->num_rows > 0) {
    $contactInfoData = $contactInfoResult->fetch_assoc();
    $location = $contactInfoData['location'];
    $locationLink = $contactInfoData['location_link'];
    $email = $contactInfoData['email'];
    $phone = $contactInfoData['phone'];
    $mapIframe = $contactInfoData['map_iframe'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $location = $_POST["location"];
    $locationLink = $_POST['locationlink'];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $mapIframe = $_POST["mapIframe"];

    // Update contact information in the database
    $updateContactQuery = "UPDATE contact_info SET location='$location', location_link='$locationLink', email='$email', phone='$phone', map_iframe='$mapIframe' WHERE id=1";

    if ($conn->query($updateContactQuery) === TRUE) {
        echo "Contact information updated successfully";
    } else {
        echo "Error updating contact information: " . $conn->error;
    }
}

$conn->close();
?>

<section class="content-header">
    <h1>Contact Update</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form action="" method="post">
                <!-- You can include form fields for updating location, email, phone, and map iframe -->
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" name="location" id="location" value="<?php echo $location; ?>" required>
                </div>

                <div class="form-group">
                    <label for="locationlink">Location link:</label>
                    <input type="text" class="form-control" name="locationlink" id="locationlink" value="<?php echo $locationLink; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone; ?>" required>
                </div>

                <div class="form-group">
                    <label for="mapIframe">Map Iframe:</label>
                    <textarea class="form-control" name="mapIframe" id="mapIframe" rows="4"><?php echo $mapIframe; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update Contact</button>
            </form>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
