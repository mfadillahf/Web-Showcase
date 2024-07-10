<?php
session_start();
$servername = "localhost"; // ganti dengan nama server database Anda
$username = "root"; // ganti dengan username database Anda
$password = ""; // ganti dengan password database Anda
$dbname = "db_showcase"; // ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$idUser = $_SESSION['ID_USER'];

// Function to sanitize user inputs
function sanitize_input($input)
{
    global $conn;
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

if (isset($_POST['update'])) {
    $id_project = sanitize_input($_POST['id_project']);
    $id_kategori = sanitize_input($_POST['id_kategori']);
    $nama_project = sanitize_input($_POST['nama_project']);
    $tahun_project = sanitize_input($_POST['tahun_project']);
    $tim_project = sanitize_input($_POST['tim_project']);
    $email_project = sanitize_input($_POST['email_project']);
    $deskripsi_project = sanitize_input($_POST['deskripsi_project']);
    $link = sanitize_input($_POST['link']);

    // Prepare image data
    // Prepare image data
$gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
$gambar2 = addslashes(file_get_contents($_FILES['gambar2']['tmp_name']));
$gambar3 = addslashes(file_get_contents($_FILES['gambar3']['tmp_name']));
$gambar4 = addslashes(file_get_contents($_FILES['gambar4']['tmp_name']));
$gambar5 = addslashes(file_get_contents($_FILES['gambar5']['tmp_name']));

// Get the existing image filenames from the database
$query_select_filenames = "SELECT GAMBAR, GAMBAR2, GAMBAR3, GAMBAR4, GAMBAR5 FROM project WHERE ID_PROJECT = '$id_project'";
$result_select_filenames = mysqli_query($conn, $query_select_filenames);
$row_select_filenames = mysqli_fetch_assoc($result_select_filenames);

$existing_gambar = $row_select_filenames['GAMBAR'];
$existing_gambar2 = $row_select_filenames['GAMBAR2'];
$existing_gambar3 = $row_select_filenames['GAMBAR3'];
$existing_gambar4 = $row_select_filenames['GAMBAR4'];
$existing_gambar5 = $row_select_filenames['GAMBAR5'];

// Update project in database
// Update project in database
$query = "UPDATE project SET ID_KATEGORI = '$id_kategori', NAMA_PROJECT = '$nama_project', TAHUN_PROJECT = '$tahun_project', TIM_PROJECT = '$tim_project', EMAIL = '$email_project', DESKRIPSI = '$deskripsi_project', LINK = '$link'";

if (!empty($_FILES['gambar']['name'])) {
    // Prepare and update the new image in database
    $gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
    $query .= ", GAMBAR = '$gambar'";
}

if (!empty($_FILES['gambar2']['name'])) {
    // Prepare and update the new image in database
    $gambar2 = addslashes(file_get_contents($_FILES['gambar2']['tmp_name']));
    $query .= ", GAMBAR2 = '$gambar2'";
}

if (!empty($_FILES['gambar3']['name'])) {
    // Prepare and update the new image in database
    $gambar3 = addslashes(file_get_contents($_FILES['gambar3']['tmp_name']));
    $query .= ", GAMBAR3 = '$gambar3'";
}

if (!empty($_FILES['gambar4']['name'])) {
    // Prepare and update the new image in database
    $gambar4 = addslashes(file_get_contents($_FILES['gambar4']['tmp_name']));
    $query .= ", GAMBAR4 = '$gambar4'";
}

if (!empty($_FILES['gambar5']['name'])) {
    // Prepare and update the new image in database
    $gambar5 = addslashes(file_get_contents($_FILES['gambar5']['tmp_name']));
    $query .= ", GAMBAR5 = '$gambar5'";
}

$query .= " WHERE ID_PROJECT = '$id_project'";


// Perform the database update query
if (mysqli_query($conn, $query)) {
    header("Location: setelahlogin.php");
} else {
    echo "Terjadi kesalahan: " . mysqli_error($conn);
}

}

$id_project = $_GET['id']; // ID proyek yang akan diedit

$query = "SELECT * FROM project WHERE ID_PROJECT = '$id_project'";
$result = mysqli_query($conn, $query);
$project = mysqli_fetch_assoc($result);

?>

<!-- Rest of the HTML code... -->



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <style>
      .content {
      margin-left: 250px;
      padding: 20px;
    }

    @media (max-width: 767px) {
      .sidebar {
        width: 100%;
        position: static;
        height: auto;
        margin-bottom: 20px;
      }

      .content {
        margin-left: 0;
      }
    }
  </style>
  <title>PNB WEB EXPO</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
    <div class="col-md-10 col-sm-12">
        <div class="content">
          <h2>Edit Project</h2>
          <hr>  

    <!-- Form Add/Edit User -->
    <form method="POST" action="edit_project.php" enctype="multipart/form-data">
    <input type="hidden" name="id_project" value="<?php echo $project['ID_PROJECT']; ?>">

    <div class="mb-3">
        <label for="id_kategori" class="form-label">Kategori</label>
        <select class="form-select" name="id_kategori" id="id_kategori">
            <?php
            // Fetch categories from the database
            $kategoriQuery = "SELECT * FROM kategori";
            $kategoriResult = mysqli_query($conn, $kategoriQuery);

            while ($kategori = mysqli_fetch_assoc($kategoriResult)) {
                $selected = ($kategori['ID_KATEGORI'] == $project['ID_KATEGORI']) ? 'selected' : '';
                echo '<option value="' . $kategori['ID_KATEGORI'] . '" ' . $selected . '>' . $kategori['NAMA'] . '</option>';
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="id_user" class="form-label">User</label>
        <select class="form-select" name="id_user" id="id_user" disabled>
            <?php
            // Fetch users from the database
            $userQuery = "SELECT * FROM user WHERE ID_USER = '$idUser'";
            $userResult = mysqli_query($conn, $userQuery);

            while ($user = mysqli_fetch_assoc($userResult)) {
                $selected = ($user['ID_USER'] == $project['ID_USER']) ? 'selected' : '';
                echo '<option value="' . $user['ID_USER'] . '" ' . $selected . '>' . $user['ID_USER'] . '</option>';
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="nama_project" class="form-label">Nama Project</label>
        <input type="text" class="form-control" name="nama_project" placeholder="Nama Project" id="nama_project" value="<?php echo $project['NAMA_PROJECT']; ?>">
    </div>

    <div class="mb-3">
        <label for="tahun_project" class="form-label">Tahun Project</label>
        <input type="date" class="form-control" name="tahun_project" id="tahun_project" value="<?php echo $project['TAHUN_PROJECT']; ?>">
    </div>

    <div class="mb-3">
        <label for="tim_project" class="form-label">Tim Project</label>
        <input type="text" class="form-control" name="tim_project" placeholder="Tim Project" id="tim_project" value="<?php echo $project['TIM_PROJECT']; ?>">
    </div>

    <div class="mb-3">
        <label for="email_project" class="form-label">Email</label>
        <input type="email" class="form-control" name="email_project" placeholder="Email" id="email_project" value="<?php echo $project['EMAIL']; ?>">
    </div>

    <div class="mb-3">
        <label for="deskripsi_project" class="form-label">Deskripsi</label>
        <textarea class="form-control" name="deskripsi_project" id="deskripsi_project"><?php echo $project['DESKRIPSI']; ?></textarea>
    </div>

    <div class="mb-3">
        <label for="gambar" class="form-label">Gambar 1</label>
        <input type="file" class="form-control" id="gambar" name="gambar">
    </div>

    <div class="mb-3">
        <label for="gambar2" class="form-label">Gambar 2</label>
        <input type="file" class="form-control" id="gambar2" name="gambar2">
    </div>

    <div class="mb-3">
        <label for="gambar3" class="form-label">Gambar 3</label>
        <input type="file" class="form-control" id="gambar3" name="gambar3">
    </div>

    <div class="mb-3">
        <label for="gambar4" class="form-label">Gambar 4</label>
        <input type="file" class="form-control" id="gambar4" name="gambar4">
    </div>

    <div class="mb-3">
        <label for="gambar5" class="form-label">Gambar 5</label>
        <input type="file" class="form-control" id="gambar5" name="gambar5">
    </div>

    <div class="mb-3">
        <label for="link_project" class="form-label">Link</label>
        <input type="text" class="form-control" name="link" placeholder="Link" id="link_project" value="<?php echo $project['LINK']; ?>">
    </div>

    <button type="submit" name="update" class="btn btn-primary">Update</button>
    <a href="coba.php" class="btn btn-danger">Back</a>
</form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>