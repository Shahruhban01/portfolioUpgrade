<?php
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Establish database connection
$host = 'localhost';
$db = 'ruhbanab_contact';
$user = 'ruhbanab_contact';
$password = 'rUHBAN@12';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Delete a message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $messageId = $_POST['delete'];

        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->execute([$messageId]);
    } elseif (isset($_POST['deleteAll'])) {
        $stmt = $pdo->prepare("DELETE FROM messages");
        $stmt->execute();
    }

    // Redirect to the same page after deleting the message(s)
    header("Location: messages.php");
    exit();
}

// Set the number of entries to show
$entriesToShow = isset($_GET['entries']) ? $_GET['entries'] : 10;

$stmt = $pdo->prepare("SELECT * FROM messages ORDER BY id DESC LIMIT ?");
$stmt->bindValue(1, $entriesToShow, PDO::PARAM_INT);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Messages</h1>
        <table class="table table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Sno</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Timestamp</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $key => $message) { ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $message['name']; ?></td>
                        <td><?php echo $message['email']; ?></td>
                        <td><?php echo $message['subject']; ?></td>
                        <td>
                            <div class="message-content"><?php echo $message['message']; ?></div>
                            <button class="btn btn-info btn-sm copy-button">Copy</button>
                        </td>
                        <td><?php echo $message['timestamp']; ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                <input type="hidden" name="delete" value="<?php echo $message['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <a href="mailto:<?php echo $message['email']; ?>" class="btn btn-primary btn-sm mx-2 m-2">Reply</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="mt-3">
            <a href="logout.php" class="btn btn-secondary">Logout</a>
            <a href="messages.php" class="btn btn-primary">Refresh</a>
            <button class="btn btn-info" onclick="window.print();" >print</button>
            <form class="d-inline-block" action="messages.php" method="GET">
                <label for="entries">Entries to Show:</label>
                <select id="entries" name="entries" onchange="this.form.submit()" class="form-control">
                    <option value="5" <?php if ($entriesToShow == 5) echo 'selected'; ?>>5</option>
                    <option value="10" <?php if ($entriesToShow == 10) echo 'selected'; ?>>10</option>
                    <option value="20" <?php if ($entriesToShow == 20) echo 'selected'; ?>>20</option>
                    <option value="50" <?php if ($entriesToShow == 50) echo 'selected'; ?>>50</option>
                    <option value="100" <?php if ($entriesToShow == 100) echo 'selected'; ?>>100</option>
                </select>
            </form>
            <form class="d-inline-block" method="POST" onsubmit="return confirm('Are you sure you want to delete all messages?')">
                <input type="hidden" name="deleteAll" value="true">
                <button type="submit" class="btn btn-danger">Delete All</button>
            </form>
        </div>
    </div>

    <script>
        const copyButtons = document.querySelectorAll('.copy-button');
        copyButtons.forEach(button => {
            button.addEventListener('click', () => {
                const messageContent = button.parentNode.querySelector('.message-content');
                const tempTextArea = document.createElement('textarea');
                tempTextArea.value = messageContent.textContent;
                document.body.appendChild(tempTextArea);
                tempTextArea.select();
                document.execCommand('copy');
                document.body.removeChild(tempTextArea);
            });
        });
    </script>
</body>
</html>
