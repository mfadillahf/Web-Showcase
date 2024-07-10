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
$id_project = "";
$id_kategori = "";
$id_user = "";
$nama_project = "";
$tahun_project = "";
$tim_project = "";
$email_project = "";
$deskripsi_project = "";
$gambar_project = "";
$link_project = "";
$update_mode = false;

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Update project
  if (isset($_POST['update'])) {
    $id_project = sanitize($conn, $_POST['id_project']);
    $id_kategori = sanitize($conn, $_POST['id_kategori']);
    $id_user = sanitize($conn, $_POST['id_user']);
    $nama_project = sanitize($conn, $_POST['nama_project']);
    $tahun_project = sanitize($conn, $_POST['tahun_project']);
    $tim_project = sanitize($conn, $_POST['tim_project']);
    $email_project = sanitize($conn, $_POST['email_project']);
    $deskripsi_project = sanitize($conn, $_POST['deskripsi_project']);
    $gambar_project = sanitize($conn, $_POST['gambar_project']);
    $link_project = sanitize($conn, $_POST['link_project']);

    // Update project in database
    $updateQuery = "UPDATE project SET id_kategori='$id_kategori',nama_project='$nama_project', tahun_project='$tahun_project', tim_project='$tim_project', email='$email_project', deskripsi='$deskripsi_project', gambar='$gambar_project', link='$link_project' WHERE id_project='$id_project'";
    mysqli_query($conn, $updateQuery);

    // Redirect to project page
    header("Location: project.php");
    exit();
  }

  // Delete project
  if (isset($_POST['delete'])) {
    $id_project = sanitize($conn, $_POST['id_project']);

    // Delete project from database
    $deleteQuery = "DELETE FROM project WHERE id_project='$id_project'";
    mysqli_query($conn, $deleteQuery);

    // Redirect to project page
    header("Location: project.php");
    exit();
  }

  // Edit project
  if (isset($_POST['edit'])) {
    $id_project = sanitize($conn, $_POST['id_project']);

    // Retrieve project from database
    $selectQuery = "SELECT * FROM project WHERE id_project='$id_project'";
    $projectResult = mysqli_query($conn, $selectQuery);
    $project = mysqli_fetch_assoc($projectResult);

    // Set form values for editing
    $id_project = $project['ID_PROJECT'];
    $id_kategori = $project['ID_KATEGORI'];
    $id_user = $project['ID_USER'];
    $nama_project = $project['NAMA_PROJECT'];
    $tahun_project = $project['TAHUN_PROJECT'];
    $tim_project = $project['TIM_PROJECT'];
    $email_project = $project['EMAIL'];
    $deskripsi_project = $project['DESKRIPSI'];
    $gambar_project = $project['GAMBAR'];
    $link_project = $project['LINK'];
    $update_mode = true;
  }
}

// Fetch data from the project table
$projectQuery = "SELECT * FROM project";
$projectResult = mysqli_query($conn, $projectQuery);
$projectRows = mysqli_num_rows($projectResult);
?>

<!-- Rest of the HTML code... -->



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
              <a class="nav-link active" href="kategori.php">Kategori</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user.php">User</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Project</a>
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
          <h1>Project Management</h1>
          <hr>  

    <!-- Form Add/Edit User -->
    <form method="POST" action="project.php">
      <input type="hidden" name="id_project" value="<?php echo $id_project; ?>">

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
          $userQuery = "SELECT * FROM user";
          $userResult = mysqli_query($conn, $userQuery);

          while ($user = mysqli_fetch_assoc($userResult)) {
            $selected = ($user['id_user'] == $id_user) ? 'selected' : '';
            echo '<option value="' . $user['id_user'] . '" ' . $selected . '>' . $user['username'] . '</option>';
          }
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="nama_project" class="form-label">Nama Project</label>
        <input type="text" class="form-control" name="nama_project" placeholder="Nama Project" id="nama_project" value="<?php echo $nama_project; ?>">
      </div>

      <div class="mb-3">
        <label for="tahun_project" class="form-label">Tahun Project</label>
        <input type="date" class="form-control" name="tahun_project" id="tahun_project" value="<?php echo $tahun_project; ?>">
      </div>

      <div class="mb-3">
        <label for="tim_project" class="form-label">Tim Project</label>
        <input type="text" class="form-control" name="tim_project" placeholder="Tim Project" id="tim_project" value="<?php echo $tim_project; ?>">
      </div>

      <div class="mb-3">
        <label for="email_project" class="form-label">Email</label>
        <input type="email" class="form-control" name="email_project" placeholder="Email" id="email_project" value="<?php echo $email_project; ?>">
      </div>

      <div class="mb-3">
        <label for="deskripsi_project" class="form-label">Deskripsi</label>
        <textarea class="form-control" name="deskripsi_project" id="deskripsi_project"><?php echo $deskripsi_project; ?></textarea>
      </div>

      <div class="mb-3">
        <label for="link_project" class="form-label">Link</label>
        <input type="text" class="form-control" name="link_project" placeholder="Link" id="link_project" value="<?php echo $link_project; ?>">
      </div>

      <button type="submit" name="update" class="btn btn-primary">Update</button>
      <a href="project.php" class="btn btn-secondary">Cancel</a>
    </form>

    <hr>

    <!-- Table User -->
    <table class="table">
      <thead>
      <tr>
          <th>ID</th>
          <th>Kategori</th>
          <th>User</th>
          <th>Nama Project</th>
          <th>Tahun Project</th>
          <th>Tim Project</th>
          <th>Email</th>
          <th>Deskripsi</th>
          <th>Link</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
             <?php
             if ($projectRows > 0) {
                while ($project = mysqli_fetch_assoc($projectResult)) {
                    echo "<tr>";
                    echo '<td>' . $project['ID_PROJECT'] . '</td>';
                    echo '<td>' . $project['ID_KATEGORI'] . '</td>';
                    echo '<td>' . $project['ID_USER'] . '</td>';
                    echo '<td>' . $project['NAMA_PROJECT'] . '</td>';
                    echo '<td>' . $project['TAHUN_PROJECT'] . '</td>';
                    echo '<td>' . $project['TIM_PROJECT'] . '</td>';
                    echo '<td>' . $project['EMAIL'] . '</td>';
                    echo '<td>' . $project['DESKRIPSI'] . '</td>';
                    echo '<td>' . $project['LINK'] . '</td>';
                    echo "<td>";
                    echo "<form method='POST' action='project.php'>";
                    echo "<input type='hidden' name='id_project' value='" . $project['ID_PROJECT'] . "'>";
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function() {
      // Edit button click event
      $('.edit-btn').click(function() {
        // Get the project ID from the button's data attribute
        var projectId = $(this).data('id');

        // Set the project ID in the edit form
        $('#editIdProject').val(projectId);

        // Hide the table and show the edit form
        $('table').hide();
        $('#editForm').show();
      });

      // Cancel button click event
      $('.cancel-btn').click(function() {
        // Show the table and hide the edit form
        $('table').show();
        $('#editForm').hide();
      });
    });
  </script>
</body>
</html>