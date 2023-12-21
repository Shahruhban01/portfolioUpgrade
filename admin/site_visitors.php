<?php include "header.php"; ?>

<section class="content-header">
    <h1>Visitor Log</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">List of Visitors</h3>
                </div>
                <div class="box-body">
                    <table id="visitorTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>IP Address</th>
                                <th>Visit Datetime</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Assuming you have a database connection
                            include "config.php";

                            // Fetch visitor data
                            $visitorQuery = "SELECT * FROM visitors";
                            $visitorResult = $conn->query($visitorQuery);

                            if ($visitorResult->num_rows > 0) {
                                while ($row = $visitorResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['id']}</td>";
                                    echo "<td>{$row['ip_address']}</td>";
                                    echo "<td>{$row['visit_datetime']}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No visitors found</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        // Initialize DataTable
        $('#visitorTable').DataTable();
    });
</script>

<?php include "footer.php"; ?>
