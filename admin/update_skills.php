<?php
// Include your database connection file
include 'config.php';
include 'header.php';

// Initialize variables to store form data
$skillsDescription = '';
$skillsData = [];

// Fetch existing data for skills description
$skillsDescriptionQuery = "SELECT * FROM skills_description";
$skillsDescriptionResult = $conn->query($skillsDescriptionQuery);

if ($skillsDescriptionResult->num_rows > 0) {
    $skillsDescriptionData = $skillsDescriptionResult->fetch_assoc();

    // Assign existing data to variables
    $skillsDescription = $skillsDescriptionData['description'];
}

// Fetch existing data for skills
$skillsQuery = "SELECT * FROM skills";
$skillsResult = $conn->query($skillsQuery);

if ($skillsResult->num_rows > 0) {
    while ($row = $skillsResult->fetch_assoc()) {
        $skillsData[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle skills description form submission
    if (isset($_POST['skills_description'])) {
        $skillsDescription = $_POST['skills_description'];

        // Update data in the 'skills_description' table using a prepared statement
        $skillsDescriptionUpdateQuery = "UPDATE skills_description SET description = ?";
        $stmt = $conn->prepare($skillsDescriptionUpdateQuery);
        $stmt->bind_param("s", $skillsDescription);
        $stmt->execute();
        $stmt->close();
    }

    // Handle skills data form submission
    if (isset($_POST['skills']) && is_array($_POST['skills'])) {
        $skillsData = $_POST['skills'];

        // Clear existing data from the 'skills' table
        $clearSkillsQuery = "TRUNCATE TABLE skills";
        $conn->query($clearSkillsQuery);

        // Insert new data into the 'skills' table using a prepared statement
        $skillsInsertQuery = "INSERT INTO skills (skill_name, skill_percentage) VALUES (?, ?)";
        $stmt = $conn->prepare($skillsInsertQuery);
        $stmt->bind_param("si", $skillName, $skillPercentage);

        foreach ($skillsData as $skill) {
            $skillName = $skill['skill_name'];
            $skillPercentage = $skill['skill_percentage'];

            $stmt->execute();
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!-- ======= Skills Section ======= -->
<section id="skills" class="skills section-bg">
    <div class="container">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Skills Update</h3>
            </div>
            <div class="box-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="skills_description">Skills Description:</label>
                        <textarea class="form-control" name="skills_description"><?php echo $skillsDescription; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="skills">Skills:</label>
                        <?php foreach ($skillsData as $key => $skill): ?>
                            <hr style="border: 1px solid #3c8dbc;"> 
                            <div class="form-group">
                                <label for="skill_name">Skill Name:</label>
                                <input type="text" class="form-control" name="skills[<?php echo $key; ?>][skill_name]" value="<?php echo $skill['skill_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="skill_percentage">Skill Percentage:</label>
                                <input type="text" class="form-control" name="skills[<?php echo $key; ?>][skill_percentage]" value="<?php echo $skill['skill_percentage']; ?>">
                            </div>
                        <?php endforeach; ?>
                        <div id="skills-container"></div>
                        <button type="button" class="btn btn-success" onclick="addSkill()">Add Skill</button>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Skills</button>
                </form>
            </div>
        </div>

    </div>
</section><!-- End Skills Section -->

<script>
    function addSkill() {
        var container = document.getElementById('skills-container');
        var newSkill = document.createElement('div');
        var index = container.childElementCount;
        newSkill.innerHTML = `
        <hr style="border: 1px solid #3c8dbc;"> 
            <div class="form-group">
                <label for="skill_name">Skill Name:</label>
                <input type="text" class="form-control" name="skills[${index}][skill_name]" value="">
            </div>
            <div class="form-group">
                <label for="skill_percentage">Skill Percentage:</label>
                <input type="text" class="form-control" name="skills[${index}][skill_percentage]" value="">
            </div><hr>`;
        container.appendChild(newSkill);
    }
</script>

<?php include 'footer.php'; ?>
