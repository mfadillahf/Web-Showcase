<?php
// Mengambil data yang dikirim melalui metode POST
$email = $_POST["email"];
$password = $_POST["password"];

// Lakukan validasi data sesuai kebutuhan
// ...

// Menghubungkan ke database dan melakukan update password
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "db_showcase";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $dbpassword, $dbname);

// Memeriksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Update password baru ke dalam tabel pengguna
$sql = "UPDATE user SET password='$password' WHERE EMAIL='$email'";

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Password berhasil diubah.");</script>';
    echo '<script>window.location.href = "form-login.php";</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi ke database
$conn->close();
?>
