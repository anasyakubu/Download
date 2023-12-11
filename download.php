<?php
if (isset($_POST['download'])) {
  // Database connection parameters
  $localhost = "localhost";
  $root = "root";
  $password = "";
  $db_name = "khadi_kaku-db";

  $con = mysqli_connect($localhost, $root, $password, $db_name);

  if (!$con) {
    die('Connection Failed' . mysqli_connect_error());
  }

  // Fetch data from the database
  $sql = "SELECT * FROM courses";
  $result = $con->query($sql);

  // Check if there are records
  if ($result->num_rows > 0) {
    // Set the headers for the SQL file
    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename="table_records.sql"');

    // Output the SQL dump
    echo "-- SQL Dump\n-- Generated on " . date("Y-m-d H:i:s") . "\n\n";

    // Output the INSERT statements
    while ($row = $result->fetch_assoc()) {
      $columns = implode(", ", array_keys($row));
      $values = implode("', '", array_values($row));
      $sqlInsert = "INSERT INTO courses ($columns) VALUES ('$values');";
      echo $sqlInsert . "\n";
    }
  } else {
    echo "No records found";
  }

  // Close the database connection
  $con->close();
  exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Download Records</title>
</head>

<body>

  <form method="post" action="download.php">
    <input type="submit" name="download" value="Download Records">
  </form>

  <script>
  // JavaScript to trigger the form submission when the button is clicked
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').addEventListener('submit', function() {
      // You can add additional logic here if needed
    });
  });
  </script>

</body>

</html>