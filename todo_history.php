<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

// Create a MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
} else {
      // Connection successful!
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Todo Item History</title>
      <link rel="stylesheet" href="./css/history.css">
</head>

<body>
      <?php


      $sql = "SELECT * FROM todo_history";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
            echo '<h1>Todo Item History</h1>';
            echo '<table>';
            echo '<tr>
                  <th>Todo ID</th>
                  <th>Action</th>
                  <th>Title</th>
                  <th>Datetime</th>
                  <th>Timestamp</th>
                  </tr>';
            while ($row = $result->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td>' . $row["todo_id"] . '</td>';
                  echo '<td>' . $row["action"] . '</td>';
                  echo '<td>' . $row["title"] . '</td>';
                  echo '<td>' . $row["datetime"] . '</td>';
                  echo '<td>' . $row["timestamp"] . '</td>';
                  echo '</tr>';
            }
            echo '</table>';
      } else {
            echo "No todos found in the todo_history table.";
      }

      $conn->close();
      ?>
</body>

</html>