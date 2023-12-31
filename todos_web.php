<?php
session_start();
include('db_conn.php');

?>



<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Todo App</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="./css/styleIndex.css">


</head>

<body>


      <nav class="nav-todo">
            <div class="content">
                  <h2 class="list-wrapper">Task Lists</h2>

            </div>
            <div class="container-icon">
                  <button type="button" class="btn btn-primary position-relative m-3" id="notificationButton">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" id="counter">
                              <span id="output" class="badge rounded-pill bg-success">

                                    <?php

                                    $sqlNotifications = 'SELECT message, datetime FROM notifications ORDER BY datetime DESC LIMIT 5'; // Fetch the latest 5 notifications ordered by datetime
                                    $result = $db->query($sqlNotifications);

                                    if ($result->num_rows > 0) {
                                          while ($row = $result->fetch_assoc()) {
                                                // echo   $row["message"] . "<br>";
                                                echo $row["message"] . " - " . $row["datetime"] . "<br>";
                                          }
                                    } else {
                                          // echo '0';
                                    }

                                    // mysqli_close($conn);
                                    ?>
                              </span>
                        </span>
                        <?php
                        $sql = "SELECT COUNT(*) AS count FROM todos WHERE status = 'Pending'";
                        $result = mysqli_query($db, $sql);
                        $count = mysqli_fetch_assoc($result)['count'];
                        echo $count;
                        ?>
                  </button>

            </div>
            <script>
                  document.addEventListener("DOMContentLoaded", function() {
                        const notificationButton = document.getElementById("notificationButton");
                        const notificationCounter = document.getElementById("counter");
                        let notificationsVisible = false;

                        // Hide the notifications initially
                        notificationCounter.style.display = "none";

                        // Add a click event listener to toggle the visibility of notifications
                        notificationButton.addEventListener("click", function() {
                              if (notificationsVisible) {
                                    notificationCounter.style.display = "none";
                              } else {
                                    notificationCounter.style.display = "block";
                              }

                              notificationsVisible = !notificationsVisible;
                        });
                  });
            </script>
      </nav>


      <div class="container">
            <form action="queryProcess.php" method="POST">
                  <div class="todo-table">

                        <h1>Lists Of Tasks</h1>
                        <h6><?php
                              $sql = "SELECT * FROM todos";
                              $result = mysqli_query($db, $sql);
                              $todos = mysqli_fetch_all($result);
                              $total = count($todos);
                              $complete = 0;

                              foreach ($todos as $todo) {

                                    if ($todo[2] == true) {
                                          $complete++;
                                    }
                                    // print_r($todo);
                              }
                              echo $total . " Total, " . $complete . " Complete," . ($total - $complete) . " Pending.";


                              ?>
                        </h6>

                        <div class="btn-holder">
                              <a href="add-todo.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Todo</a>
                              <button name="action" value="edit" class="btn btn-secondary"><i class="fa fa-edit"></i>
                                    Edit Todo</button>
                              <button name="action" value="delete" class="btn btn-danger"><i class="fa fa-times"></i>
                                    Delete Todo</button>
                              <button name="action" value="complete" class="btn btn-purple"><i class="fa fa-thumbs-up"></i> Mark
                                    Complete</button>
                              <button name="action" value="pending" class="btn btn-orange"><i class="fa fa-thumbs-down"></i> Mark
                                    Pending</button>

                              <a href="todo_history.php" class="history"><i class="fa fa-history"></i> History
                                    Log</a>
                        </div>

                        <table>
                              <thead>
                                    <tr>
                                          <th>S.N</th>
                                          <th>Todo Title</th>
                                          <th>Status</th>
                                          <th>Date-Time</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    <?php
                                    foreach ($todos as $todo) {
                                    ?>
                                          <tr class="<?php echo $todo[2] ? 'complete' : ''; ?>">
                                                <td><input type="radio" required name="todo" value="<?php echo $todo[0]; ?>" id="">
                                                </td>
                                                <td><?php echo $todo[1]; ?></td>
                                                <td><?php echo $todo[2] ? 'Complete' : 'Pending'; ?>
                                                </td>

                                                <td><?php echo $todo[3]; ?>

                                                </td>

                                          </tr>
                                    <?php } ?>

                              </tbody>
                        </table>
                  </div>

            </form>
      </div>
</body>

</html>