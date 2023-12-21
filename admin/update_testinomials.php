<?php
include "header.php";

// Include your database connection file
include "config.php";

// Folder to store testimonial images
$uploadFolder = "assets/img/testimonials/";

// Function to insert a new testimonial
function insertTestimonial($text, $image_url, $customer_name, $customer_title)
{
    global $conn;

    $text = mysqli_real_escape_string($conn, $text);
    $image_url = mysqli_real_escape_string($conn, $image_url);
    $customer_name = mysqli_real_escape_string($conn, $customer_name);
    $customer_title = mysqli_real_escape_string($conn, $customer_title);

    $insertQuery = "INSERT INTO testimonials (text, image_url, customer_name, customer_title)
                    VALUES ('$text', '$image_url', '$customer_name', '$customer_title')";

    return mysqli_query($conn, $insertQuery);
}

// Function to delete a testimonial
function deleteTestimonial($testimonialId)
{
    global $conn;

    $testimonialId = mysqli_real_escape_string($conn, $testimonialId);

    $deleteQuery = "DELETE FROM testimonials WHERE id = '$testimonialId'";

    return mysqli_query($conn, $deleteQuery);
}

// Fetch existing testimonials
$fetchTestimonialsQuery = "SELECT * FROM testimonials";
$testimonialsResult = $conn->query($fetchTestimonialsQuery);
$existingTestimonials = $testimonialsResult->fetch_all(MYSQLI_ASSOC);

// Check if the form is submitted for adding a testimonial
if (isset($_POST['add_testimonial'])) {
    $text = $_POST['testimonial_text'];
    $customer_name = $_POST['testimonial_customer_name'];
    $customer_title = $_POST['testimonial_customer_title'];

    // Upload image
    $imageFileName = basename($_FILES["testimonial_image"]["name"]);
    $imageFilePath = $uploadFolder . $imageFileName;
    $upfolder = "../assets/img/testimonials/" . $imageFileName;
    move_uploaded_file($_FILES["testimonial_image"]["tmp_name"], $upfolder);

    // Insert the new testimonial
    insertTestimonial($text, $imageFilePath, $customer_name, $customer_title);
}

// Check if the form is submitted for deleting a testimonial
if (isset($_POST['delete_testimonial'])) {
    $testimonialIdToDelete = $_POST['testimonial_id_to_delete'];

    // Delete the testimonial
    deleteTestimonial($testimonialIdToDelete);
}

?>

<section class="content-header">
    <h1>Update Testimonials</h1>
</section>

<section class="content">
    <div class="row">
        <!-- Form for adding a testimonial -->
        <div class="col-md-6">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <h2>Add Testimonial</h2>
                </div>
                <div class="mb-3">
                    <label class="form-label">Text:</label>
                    <textarea class="form-control" name="testimonial_text" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Customer Name:</label>
                    <input type="text" class="form-control" name="testimonial_customer_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Customer Title:</label>
                    <input type="text" class="form-control" name="testimonial_customer_title" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload Image:</label>
                    <input type="file" class="form-control" name="testimonial_image" accept="image/*" required>
                </div>
                <button type="submit" name="add_testimonial" class="btn btn-primary">Add Testimonial</button>
            </form>
        </div>

        <!-- Form for deleting a testimonial -->
        <div class="col-md-6">
            <form action="" method="post">
                <div class="mb-3">
                    <h2>Delete Testimonial</h2>
                </div>
                <div class="mb-3">
                    <label class="form-label">Testimonial ID to Delete:</label>
                    <input type="text" class="form-control" name="testimonial_id_to_delete" required>
                </div>
                <button type="submit" name="delete_testimonial" class="btn btn-danger">Delete Testimonial</button>
            </form>
        </div>
    </div>

    <!-- Display existing testimonials -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Existing Testimonials</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Text</th>
                        <th>Image</th>
                        <th>Customer Name</th>
                        <th>Customer Title</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($existingTestimonials as $testimonial) { ?>
                        <tr>
                            <td><?php echo $testimonial['id']; ?></td>
                            <td><?php echo $testimonial['text']; ?></td>
                            <td><img src="../<?php echo $testimonial['image_url']; ?>" alt="Testimonial Image" style="max-width: 100px;"></td>
                            <td><?php echo $testimonial['customer_name']; ?></td>
                            <td><?php echo $testimonial['customer_title']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
