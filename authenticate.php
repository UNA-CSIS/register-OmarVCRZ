<?php session_start();

include_once 'validate.php';

if (!isset($_POST['user'],$_POST['pwd'])) {
    header("Location: index.php");
    exit();
}
$endUser = test_input($_POST['user']);
$endPwd = test_input($_POST['pwd']);

// login to the softball database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// select password from users where username = <what the user typed in>
$sql = "SELECT password FROM users WHERE username='$endUser'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
  // otherwise, password_verify(password from form, password from db)
  // if good, put username in session, otherwise send back to login
  if ($row = $result->fetch_assoc()) {
      $verified = password_verify($endPwd, trim($row['password']));
      if ($verified) {
          $_SESSION['username'] = $endUser;
          header('Location: games.php');
          exit();
      } else {
          header('Location: index.php');
          exit();
      }
  }
// if no rows, then username is not valid (but don't tell Mallory) just send
// her back to the login
} else {
    header('Location: index.php');
    exit();
}

$conn->close();
header("Location: index.php");
?>




