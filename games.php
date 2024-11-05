<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        Display games here...
        <?php
        
        $sql = "SELECT * FROM games";
        $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table border>
            <tr>
            <th>Opponent</th>
            <th>Site</th>
            <th>Result</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['opponent'] . "</td>";
            echo "<td>" . $row['site'] . "</td>";
            echo "<td>" . $row['result'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No Games were found!";
    }

        $conn->close();
        ?>
        <a href="index.php">Main Menu</a><br>
    </body>
</html>
