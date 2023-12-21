<?php
include "header.php";
// include 'config.php';

// Initialize variables to store form data
$summary = $education = $experience = [];

// Fetch existing data for summary
$summaryQuery = "SELECT * FROM summary";
$summaryResult = $conn->query($summaryQuery);

if ($summaryResult->num_rows > 0) {
    $summary = $summaryResult->fetch_assoc();
}

// Fetch existing data for education
$educationQuery = "SELECT * FROM education";
$educationResult = $conn->query($educationQuery);

if ($educationResult->num_rows > 0) {
    $education = $educationResult->fetch_assoc();
}

// Fetch existing data for experience
$experienceQuery = "SELECT * FROM experience";
$experienceResult = $conn->query($experienceQuery);

if ($experienceResult->num_rows > 0) {                                                                                                                                              
    $experience = $experienceResult->fetch_assoc();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle summary form submission
    if (isset($_POST['summary'])) {
        $summary = $_POST['summary'];

        // Update data in the 'summary' table
        $summaryUpdateQuery = "UPDATE summary SET name = ?, designation = ?, address = ?, phone = ?, email = ?, description = ?";
        $stmt = $conn->prepare($summaryUpdateQuery);
        $stmt->bind_param("ssssss", $summary['name'], $summary['designation'], $summary['address'], $summary['phone'], $summary['email'], $summary['description']);
        $stmt->execute();
        $stmt->close();
    }

    // Handle education form submission
    if (isset($_POST['education'])) {
        $education = $_POST['education'];

        // Update data in the 'education' table
        $educationUpdateQuery = "UPDATE education SET degree = ?, year = ?, institution = ?, description = ?";
        $stmt = $conn->prepare($educationUpdateQuery);
        $stmt->bind_param("ssss", $education['degree'], $education['year'], $education['institution'], $education['description']);
        $stmt->execute();
        $stmt->close();
    }

    // Handle experience form submission
    if (isset($_POST['experience'])) {
        $experience = $_POST['experience'];

        // Update data in the 'experience' table
        $experienceUpdateQuery = "UPDATE experience SET position = ?, year = ?, location = ?, responsibilities = ?";
        $stmt = $conn->prepare($experienceUpdateQuery);
        $stmt->bind_param("ssss", $experience['position'], $experience['year'], $experience['location'], $experience['responsibilities']);
        $stmt->execute();
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<section class="content-header">
    <div class="container">
        <h1>Resume Update</h1>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1>This is Resume Update Page</h1>
            </div>

            <!-- Summary Form -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Update Summary</h2>
                <div class="form-group">
                    <label for="summary_name">Name:</label>
                    <input type="text" class="form-control" name="summary[name]" value="<?php echo isset($summary['name']) ? $summary['name'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="summary_designation">Designation:</label>
                    <input type="text" class="form-control" name="summary[designation]" value="<?php echo isset($summary['designation']) ? $summary['designation'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="summary_address">Address:</label>
                    <input type="text" class="form-control" name="summary[address]" value="<?php echo isset($summary['address']) ? $summary['address'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="summary_phone">Phone:</label>
                    <input type="text" class="form-control" name="summary[phone]" value="<?php echo isset($summary['phone']) ? $summary['phone'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="summary_email">Email:</label>
                    <input type="email" class="form-control" name="summary[email]" value="<?php echo isset($summary['email']) ? $summary['email'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="education_description">Description:</label>
                    <textarea class="form-control" name="summary[description]" rows="4"><?php echo isset($summary['description']) ? $summary['description'] : ''; ?></textarea>
                </div>


                <input type="submit" class="btn btn-primary" value="Update Summary">
            </form>

            <!-- Education Form -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Update Education</h2>
                <div class="form-group">
                    <label for="education_degree">Degree:</label>
                    <input type="text" class="form-control" name="education[degree]" value="<?php echo isset($education['degree']) ? $education['degree'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="education_year">Year:</label>
                    <input type="text" class="form-control" name="education[year]" value="<?php echo isset($education['year']) ? $education['year'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="education_institution">Institution:</label>
                    <input type="text" class="form-control" name="education[institution]" value="<?php echo isset($education['institution']) ? $education['institution'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="education_description">Description:</label>
                    <textarea class="form-control" name="education[description]" rows="4"><?php echo isset($education['description']) ? $education['description'] : ''; ?></textarea>
                </div>

                <input type="submit" class="btn btn-primary" value="Update Education">
            </form>

            <!-- Experience Form -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Update Experience</h2>
                <div class="form-group">
                    <label for="experience_position">Position:</label>
                    <input type="text" class="form-control" name="experience[position]" value="<?php echo isset($experience['position']) ? $experience['position'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="experience_year">Year:</label>
                    <input type="text" class="form-control" name="experience[year]" value="<?php echo isset($experience['year']) ? $experience['year'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="experience_location">Location:</label>
                    <input type="text" class="form-control" name="experience[location]" value="<?php echo isset($experience['location']) ? $experience['location'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="experience_responsibilities">Responsibilities:</label>
                    <textarea class="form-control" name="experience[responsibilities]" rows="4"><?php echo isset($experience['responsibilities']) ? $experience['responsibilities'] : ''; ?></textarea>
                </div>


                <input type="submit" class="btn btn-primary" value="Update Experience">
            </form>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
