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
$id_user = "";
$username = "";
$email = "";
$password = "";
$level = "";
$update_mode = false;

$sqlMaxId = "SELECT MAX(ID_USER) AS max_id FROM USER";
$result = $conn->query($sqlMaxId);
$row = $result->fetch_assoc();
$maxId = $row['max_id'];

$newId = $maxId + 1;
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Add user
  if (isset($_POST['add'])) {
    $username = sanitize($conn, $_POST['username']);
    $email = sanitize($conn, $_POST['email']);
    $password = sanitize($conn, $_POST['password']);
    $level = sanitize($conn, $_POST['level']);

    // Insert user into database
    $insertQuery = "INSERT INTO user (id_user, username, email, password, level) VALUES ('$newId','$username', '$email', '$password', '$level')";
    mysqli_query($conn, $insertQuery);

    // Redirect to user page
    header("Location: user.php");
    exit();
  }

  // Update user
  if (isset($_POST['update'])) {
    $id_user = sanitize($conn, $_POST['id_user']);
    $username = sanitize($conn, $_POST['username']);
    $email = sanitize($conn, $_POST['email']);
    $password = sanitize($conn, $_POST['password']);
    $level = sanitize($conn, $_POST['level']);

    // Update user in database
    $updateQuery = "UPDATE user SET username='$username', email='$email', password='$password', level='$level' WHERE id_user='$id_user'";
    mysqli_query($conn, $updateQuery);

    // Redirect to user page
    header("Location: user.php");
    exit();
  }

  // Delete user
  if (isset($_POST['delete'])) {
    $id_user = sanitize($conn, $_POST['id_user']);

    // Delete user from database
    $deleteQuery = "DELETE FROM user WHERE id_user='$id_user'";
    mysqli_query($conn, $deleteQuery);

    // Redirect to user page
    header("Location: user.php");
    exit();
  }

  // Edit user
  if (isset($_POST['edit'])) {
    $id_user = sanitize($conn, $_POST['id_user']);

    // Retrieve user from database
    $selectQuery = "SELECT * FROM user WHERE id_user='$id_user'";
    $userResult = mysqli_query($conn, $selectQuery);
    $user = mysqli_fetch_assoc($userResult);

    // Set form values for editing
    $id_user = $user['ID_USER'];
    $username = $user['USERNAME'];
    $email = $user['EMAIL'];
    $password = $user['PASSWORD'];
    $level = $user['LEVEL'];
    $update_mode = true;
  }
}

// Fetch data from the user table
$userQuery = "SELECT * FROM user";
$userResult = mysqli_query($conn, $userQuery);
$userRows = mysqli_num_rows($userResult);
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
              <a class="nav-link active" href="kategori.php">Kategori</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">User</a>
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
          <h1>User Management</h1>
          <hr>  

    <!-- Form Add/Edit User -->
    <form method="POST" action="user.php">
      <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" placeholder="Email" class="form-control" value="<?php echo $email; ?>" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" placeholder="Password" class="form-control" value="<?php echo $password; ?>" required>
      </div>
      <div class="mb-3">
        <label for="level" class="form-label">Level</label>
        <select name="level" class="form-select" required>
          <option value="">Select Level</option>
          <option value="admin" <?php if ($level == 'admin') echo 'selected'; ?>>admin</option>
          <option value="user" <?php if ($level == 'user') echo 'selected'; ?>>user</option>
        </select>
      </div>
      <?php if ($update_mode): ?>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
      <?php else: ?>
        <button type="submit" name="add" class="btn btn-success">Add</button>
      <?php endif; ?>
    </form>

    <hr>

    <!-- Table User -->
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Level</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
             <?php
             if ($userRows > 0) {
                while ($user = mysqli_fetch_assoc($userResult)) {
                    echo "<tr>";
                    echo "<td>" . $user['ID_USER'] . "</td>";
                    echo "<td>" . $user['USERNAME'] . "</td>";
                    echo "<td>" . $user['EMAIL'] . "</td>";
                    echo "<td>" . $user['LEVEL'] . "</td>";
                    echo "<td>";
                    echo "<form method='POST' action='user.php'>";
                    echo "<input type='hidden' name='id_user' value='" . $user['ID_USER'] . "'>";
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
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>