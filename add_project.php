<?php
// Include database configuration file
session_start();
$servername = "localhost"; // ganti dengan nama server database Anda
$username = "root"; // ganti dengan username database Anda
$password =""; // ganti dengan password database Anda
$dbname = "db_showcase"; // ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$sqlMaxId = "SELECT MAX(ID_PROJECT) AS max_id FROM project";
$result = $conn->query($sqlMaxId);
$row = $result->fetch_assoc();
$maxId = $row['max_id'];

$newId = $maxId + 1;

function sanitize_input($input)
{
    global $conn;
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

$idUser = $_SESSION['ID_USER'];
// Function to sanitize user inputs
if (isset($_POST['update'])) {
    $newId = $_POST['id_project'];
    $id_kategori = $_POST['id_kategori'];
    $nama_project = $_POST['nama_project'];
    $tahun_project = $_POST['tahun_project'];
    $tim_project = $_POST['tim_project'];
    $email_project = $_POST['email_project'];
    $deskripsi_project = $_POST['deskripsi_project'];
    $gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
    $gambar2 = addslashes(file_get_contents($_FILES['gambar2']['tmp_name']));
    $gambar3 = addslashes(file_get_contents($_FILES['gambar3']['tmp_name']));
    $gambar4 = addslashes(file_get_contents($_FILES['gambar4']['tmp_name']));
    $gambar5 = addslashes(file_get_contents($_FILES['gambar5']['tmp_name']));
    $link = $_POST['link'];


    // Update project in database
    $query = "INSERT INTO project (ID_PROJECT, ID_KATEGORI, ID_USER, NAMA_PROJECT, TAHUN_PROJECT, TIM_PROJECT, EMAIL, DESKRIPSI, GAMBAR, GAMBAR2, GAMBAR3, GAMBAR4, GAMBAR5, LINK) VALUES ('$newId','$id_kategori','$idUser', '$nama_project', '$tahun_project', '$tim_project', '$email_project', '$deskripsi_project', '$gambar', '$gambar2', '$gambar3', '$gambar4', '$gambar5', '$link')";
    if (mysqli_query($conn, $query)) {
        header("Location: coba.php");
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
    // Redirect to project page
}
// Fetch data from the project table
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
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 250px;
      background-color: #343a40;
      color: #fff;
      padding: 20px;
      transition: all 0.3s;
    }

    .sidebar ul.nav.flex-column {
      margin-top: 40px;
    }

    .sidebar ul.nav.flex-column li.nav-item {
      margin-bottom: 10px;
    }

    .sidebar ul.nav.flex-column li.nav-item a.nav-link {
      color: #fff;
    }

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
          <h2>Upload Project</h2>
          <hr>  

    <!-- Form Add/Edit User -->
    <form method="POST" action="add_project.php" enctype="multipart/form-data">
      <input type="hidden" name="id_project" id="id_project" value="<?php echo $newId; ?>">

      <div class="mb-3">
        <label for="id_kategori" class="form-label">Kategori</label>
        <select class="form-select" name="id_kategori" id="id_kategori">
          <?php
          // Fetch categories from the database
          $kategoriQuery = "SELECT * FROM kategori";
          $kategoriResult = mysqli_query($conn, $kategoriQuery);

          while ($kategori = mysqli_fetch_assoc($kategoriResult)) {
            $selected = ($kategori['ID_KATEGORI'] == $id_kategori) ? 'selected' : '';
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
            $selected = ($user['ID_USER'] == $id_user) ? 'selected' : '';
            echo '<option value="' . $user['ID_USER'] . '" ' . $selected . '>' . $user['ID_USER'] . '</option>';
          }
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="nama_project" class="form-label">Nama Project</label>
        <input type="text" class="form-control" name="nama_project" placeholder="Nama Project" id="nama_project">
      </div>

      <div class="mb-3">
        <label for="tahun_project" class="form-label">Tahun Project</label>
        <input type="date" class="form-control" name="tahun_project" id="tahun_project">
      </div>

      <div class="mb-3">
        <label for="tim_project" class="form-label">Tim Project</label>
        <input type="text" class="form-control" name="tim_project" placeholder="Tim Project" id="tim_project">
      </div>

      <div class="mb-3">
        <label for="email_project" class="form-label">Email</label>
        <input type="email" class="form-control" name="email_project" placeholder="Email" id="email_project">
      </div>

      <div class="mb-3">
        <label for="deskripsi_project" class="form-label">Deskripsi</label>
        <textarea class="form-control" name="deskripsi_project" id="deskripsi_project"></textarea>
      </div>

      <div class="mb-3">
        <label for="gambar" class="form-label">Gambar 1</label>
        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/jpeg, image/png" maxlength="65536">
        <small class="form-text text-muted">Ukuran maksimum: 64 KB</small>
      </div>

      <div class="mb-3">
        <label for="gambar2" class="form-label">Gambar 2</label>
        <input type="file" class="form-control" id="gambar2" name="gambar2" accept="image/jpeg, image/png" maxlength="65536">
        <small class="form-text text-muted">Ukuran maksimum: 64 KB</small>
      </div>

      <div class="mb-3">
        <label for="gambar3" class="form-label">Gambar 3</label>
        <input type="file" class="form-control" id="gambar3" name="gambar3" accept="image/jpeg, image/png" maxlength="65536">
        <small class="form-text text-muted">Ukuran maksimum: 64 KB</small>
      </div>

      <div class="mb-3">
        <label for="gambar4" class="form-label">Gambar 4</label>
        <input type="file" class="form-control" id="gambar4" name="gambar4" accept="image/jpeg, image/png" maxlength="65536">
        <small class="form-text text-muted">Ukuran maksimum: 64 KB</small>
      </div>

      <div class="mb-3">
        <label for="gambar5" class="form-label">Gambar 5</label>
        <input type="file" class="form-control" id="gambar5" name="gambar5" accept="image/jpeg, image/png" maxlength="65536">
        <small class="form-text text-muted">Ukuran maksimum: 64 KB</small>
      </div>

      <div class="mb-3">
        <label for="link_project" class="form-label">Link</label>
        <input type="text" class="form-control" name="link" placeholder="Link" id="link_project">
      </div>

      <button type="submit" name="update" class="btn btn-primary">Upload</button>
      <a href="coba.php" class="btn btn-danger">Back</a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>