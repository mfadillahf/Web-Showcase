<?php
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];

$servername = "localhost";
$username_db = "root";
$password_db = "";
$database = "db_showcase";

$conn = new mysqli($servername, $username_db, $password_db, $database);
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
$sqlMaxId = "SELECT MAX(ID_USER) AS max_id FROM user";
$result = $conn->query($sqlMaxId);
$row = $result->fetch_assoc();
$maxId = $row['max_id'];

$newId = $maxId + 1;

//$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$currentTime = date('Y-m-d H:i:s');

$sql = "INSERT INTO user (ID_USER, USERNAME, EMAIL, PASSWORD, LEVEL, CREATED, UPDATED) VALUES ('$newId', '$username', '$email', '$password', 'user', '$currentTime', '$currentTime')";

if ($conn->query($sql) === TRUE) {
    header("Location: form-login.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
