<?php
    $conn = new mysqli('localhost', 'root', '', 'ruhban');

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    ?>