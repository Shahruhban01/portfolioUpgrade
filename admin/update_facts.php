<?php
// Include your database connection file
include 'config.php';
include 'header.php';

// Initialize variables to store form data
$factsDescription = '';
$factBoxes = [];

// Fetch existing data for facts description
$factsQuery = "SELECT * FROM facts";
$factsResult = $conn->query($factsQuery);

if ($factsResult->num_rows > 0) {
    $factsData = $factsResult->fetch_assoc();

    // Assign existing data to variables
    $factsDescription = $factsData['facts_description'];
}

// Fetch existing data for fact boxes
$factBoxesQuery = "SELECT * FROM fact_boxes";
$factBoxesResult = $conn->query($factBoxesQuery);

if ($factBoxesResult->num_rows > 0) {
    while ($row = $factBoxesResult->fetch_assoc()) {
        $factBoxes[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle facts description form submission
    if (isset($_POST['facts_description'])) {
        $factsDescription = $_POST['facts_description'];

        // Update data in the 'facts' table using a prepared statement
        $factsUpdateQuery = "UPDATE facts SET facts_description = ?";
        $stmt = $conn->prepare($factsUpdateQuery);
        $stmt->bind_param("s", $factsDescription);
        $stmt->execute();  // Add this line to execute the statement
        $stmt->close();
    }

    // Handle fact boxes form submission
    if (isset($_POST['fact_boxes']) && is_array($_POST['fact_boxes'])) {
        $factBoxes = $_POST['fact_boxes'];

        // Clear existing data from the 'fact_boxes' table
        $clearFactBoxesQuery = "TRUNCATE TABLE fact_boxes";
        $conn->query($clearFactBoxesQuery);

        // Insert new data into the 'fact_boxes' table using a prepared statement
        $factBoxesInsertQuery = "INSERT INTO fact_boxes (icon_class, counter_value, fact_title) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($factBoxesInsertQuery);
        $stmt->bind_param("sss", $iconClass, $counterValue, $factTitle);

        foreach ($factBoxes as $factBox) {
            $iconClass = $factBox['icon_class'];
            $counterValue = $factBox['counter_value'];
            $factTitle = $factBox['fact_title'];

            $stmt->execute();
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>


<!-- ======= Facts Section ======= -->
<section id="facts" class="facts">
  <div class="container">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Update Facts</h3>
      </div>
      <div class="box-body">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group">
            <label for="facts_description">Facts Description:</label>
            <textarea class="form-control" name="facts_description"><?php echo $factsDescription; ?></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Update Facts Description</button>
        </form>
      </div>
    </div>

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Update Fact Boxes</h3>
      </div>
      <div class="box-body">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group">
            <label for="fact_boxes">Fact Boxes:</label>
            <?php foreach ($factBoxes as $key => $factBox): ?>
              <div class="form-group">
                <label for="icon_class">Icon Class:</label>
                <input type="text" class="form-control" name="fact_boxes[<?php echo $key; ?>][icon_class]" value="<?php echo $factBox['icon_class']; ?>">
              </div>
              <div class="form-group">
                <label for="counter_value">Counter Value:</label>
                <input type="text" class="form-control" name="fact_boxes[<?php echo $key; ?>][counter_value]" value="<?php echo $factBox['counter_value']; ?>">
              </div>
              <div class="form-group">
                <label for="fact_title">Fact Title:</label>
                <input type="text" class="form-control" name="fact_boxes[<?php echo $key; ?>][fact_title]" value="<?php echo $factBox['fact_title']; ?>">
              </div>
            <?php endforeach; ?>
            <div id="fact-boxes-container"></div>
            <button type="button" class="btn btn-success" onclick="addFactBox()">Add Fact Box</button>
          </div>
          <button type="submit" class="btn btn-primary">Update Fact Boxes</button>
        </form>
      </div>
    </div>

  </div>
</section><!-- End Facts Section -->

<script>
function addFactBox() {
  var container = document.getElementById('fact-boxes-container');
  var newFactBox = document.createElement('div');
  var index = container.childElementCount;
  newFactBox.innerHTML = `
    <div class="form-group">
      <label for="icon_class">Icon Class:</label>
      <input type="text" class="form-control" name="fact_boxes[${index}][icon_class]" value="">
    </div>
    <div class="form-group">
      <label for="counter_value">Counter Value:</label>
      <input type="text" class="form-control" name="fact_boxes[${index}][counter_value]" value="">
    </div>
    <div class="form-group">
      <label for="fact_title">Fact Title:</label>
      <input type="text" class="form-control" name="fact_boxes[${index}][fact_title]" value="">
    </div>`;
  container.appendChild(newFactBox);
}
</script>

<?php include 'footer.php'; ?>
