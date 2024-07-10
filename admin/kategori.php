<?php
// Include database configuration file
include('config.php');

// Function to sanitize user inputs
function sanitize($conn, $input)
{
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  $input = mysqli_real_escape_string($conn, $input);
  return $input;
}

// Initialize variables
$id_kategori = "";
$nama = "";
$update_mode = FALSE;

$sqlMaxId = "SELECT MAX(ID_KATEGORI) AS max_id FROM kategori";
$result = $conn->query($sqlMaxId);
$row = $result->fetch_assoc();
$maxId = $row['max_id'];

$newId = $maxId + 1;
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Add kategori
  if (isset($_POST['add'])) {
    $nama = sanitize($conn, $_POST['nama']);

    // Insert kategori into database
    $insertQuery = "INSERT INTO kategori (id_kategori, nama) VALUES ('$newId','$nama')";
    mysqli_query($conn, $insertQuery);

    // Redirect to kategori page
    header("Location: kategori.php");
    exit();
  }

  // Update kategori
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Edit kategori
    if (isset($_POST['edit'])) {
      $id_kategori = sanitize($conn, $_POST['id_kategori']);
  
      // Retrieve kategori from database
      $selectQuery = "SELECT * FROM kategori WHERE id_kategori='$id_kategori'";
      $kategoriResult = mysqli_query($conn, $selectQuery);
      $kategori = mysqli_fetch_assoc($kategoriResult);
  
      // Set form values for editing
      $id_kategori = $kategori['ID_KATEGORI'];
      $nama = $kategori['NAMA'];
      $update_mode = true;
    }
 }

 // Update kategori
 if (isset($_POST['update'])) {
    $id_kategori = sanitize($conn, $_POST['id_kategori']);
    $nama = sanitize($conn, $_POST['nama']);

    // Update kategori in database
    $updateQuery = "UPDATE kategori SET nama='$nama' WHERE id_kategori='$id_kategori'";
    mysqli_query($conn, $updateQuery);

    // Redirect to kategori page
    header("Location: kategori.php");
    exit();
  }

  // Delete kategori
  if (isset($_POST['delete'])) {
    $id_kategori = sanitize($conn, $_POST['id_kategori']);

    // Delete kategori from database
    $deleteQuery = "DELETE FROM kategori WHERE id_kategori='$id_kategori'";
    mysqli_query($conn, $deleteQuery);

    // Redirect to kategori page
    header("Location: kategori.php");
    exit();
  }
}

// Fetch data from the kategori table
$kategoriQuery = "SELECT * FROM kategori";
$kategoriResult = mysqli_query($conn, $kategoriQuery);
$kategoriRows = mysqli_num_rows($kategoriResult);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="img/logo.png" rel="icon">
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
      <!-- Sidebar -->
      <div class="col-md-2 col-sm-12 bg-dark text-light sidebar">
        <div class="sidebar-content">
          <h2>Admin Page</h2>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="admin.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="#">Kategori</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user.php">User</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="project.php">Project</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../index.php" rel="prev">Log Out</a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Content -->
      <div class="col-md-10 col-sm-12">
        <div class="content">
          <h1>Kategori</h1>
          <hr>

          <!-- Add / Edit Form -->
          <div class="mb-3">
            <!-- Form content -->
            <form method="POST" <?php if ($update_mode) echo 'action="kategori.php"'; ?>>
            <input type="hidden" name="id_kategori" value="<?php echo $id_kategori; ?>">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Kategori" value="<?php echo $nama; ?>" required>
                </div>
                <div class="col-md-2">
                  <?php if ($update_mode) : ?>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                  <?php else : ?>
                    <button type="submit" name="add" class="btn btn-success">Add</button>
                <?php endif; ?>
          </div>
        </div>
      </form>
          </div>
          <!-- Kategori Table -->
          <table class="table table-bordered">
          <thead>
            <tr>
            <th>ID Kategori</th>
            <th>Nama</th>
            <th>Action</th>
            </tr>
          </thead>
            <!-- Table content -->
            <tbody>
             <?php
             if ($kategoriRows > 0) {
                while ($kategori = mysqli_fetch_assoc($kategoriResult)) {
                    echo "<tr>";
                    echo "<td>" . $kategori['ID_KATEGORI'] . "</td>";
                    echo "<td>" . $kategori['NAMA'] . "</td>";
                    echo "<td>";
                    echo "<form method='POST' action='kategori.php'>";
                    echo "<input type='hidden' name='id_kategori' value='" . $kategori['ID_KATEGORI'] . "'>";
                    echo "<button type='submit' name='edit' class='btn btn-primary btn-sm'>Edit</button> ";
                    echo "<button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                } else {
             echo "<tr><td colspan='3'>No records found.</td></tr>";
             }
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>