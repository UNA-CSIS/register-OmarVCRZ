<?php session_start();
// session start here...
include_once 'validate.php';

if (!isset($_POST['user'], $_POST['pwd'], $_POST['repeat'])) {
    header('Location: index.php');
    exit();
}

// get all 3 strings from the form (and scrub w/ validation function)
$endUser = test_input($_POST['user']);
$endPwd = test_input($_POST['pwd']);
$repeat = test_input($_POST['repeat']);

// make sure that the two password values match!
if ($endPwd !== $repeat) {
    $_SESSION['error'] = "Passwords Do Not Match";
    header('Location: register.php');
    exit();
}

// login to the database

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

$sql = "SELECT * FROM users WHERE username='$endUser'";
$result = $conn->query($sql);

// make sure that the new user is not already in the database
if ($result->num_rows > 0) {
    $_SESSION['error'] = 'Username is already in used';
    header('Location: register.php');
    exit();
}

// insert username and password hash into db (put the username in the session
// or make them login)
$hashed_password = password_hash($endPwd, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (username, password) VALUES ('$endUser', '$hashed_password')";

if ($conn->query($sql) == TRUE) {
    $_SESSION['username'] = $endUser;
    $_SESSION['error'] = '';
    header("Location: index.php");
    exit();
} else {
    $_SESSION['error'] = 'Error in Developing User';
    header('Location: register.php');
    exit();
}
$conn->close();
?>
