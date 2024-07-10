<?php
session_start();
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_showcase";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengambil data dari form log in
$username = $_POST['username' ];
$password = $_POST['password'];

// Melakukan query untuk memeriksa kecocokan username dan password
$query = "SELECT * FROM user WHERE USERNAME = '$username' AND PASSWORD = '$password'";
$result = mysqli_query($conn, $query);
$cek = mysqli_num_rows($result);

// Memeriksa apakah data pengguna ditemukan di database
if ($cek> 0)  {
    $data = mysqli_fetch_assoc($result);
    // Log in berhasil
    if($data['LEVEL']=="admin"){
		// buat session login dan username
        $_SESSION['ID_USER'] = $data['ID_USER'];
		$_SESSION['username'] = $username;
		$_SESSION['LEVEL'] = "admin";
		header("location:admin/admin.php");
    }elseif($data['LEVEL']=="user"){
        $_SESSION['ID_USER'] = $data['ID_USER'];
        $_SESSION['username'] = $username;
		$_SESSION['level'] = "user";
        header ("location:setelahlogin.php");
    }
    // Lakukan tindakan yang diperlukan, seperti menyimpan informasi pengguna ke dalam sesi
} else {
    // Log in gagal
    echo '<script>alert("Username atau Password salah.");</script>';
    echo '<script>window.location.href = "form-login.php";</script>';
}

// Menutup koneksi ke database
mysqli_close($conn);
?>
