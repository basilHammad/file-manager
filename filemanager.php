<?php
session_start();
if ($_SESSION['id']) {
  $userId = $_SESSION['id'];
  $username = $_SESSION['name'];
  if (!file_exists('users-folders')) mkdir('users-folders', 0777, true);
  if (!file_exists("users-folders/$userId")) mkdir("users-folders/$userId", 0777, true);
} else header("Location:home.php");


$target_dir = 'users-folders/' . $userId . (!empty($_GET['fn']) ? '/' .  $_GET['fn'] : '');
// $target_dir = 'users-folders/' . $userId;
// if (empty($_SESSION['dir']) || empty($_GET['fn']))
//   $_SESSION['dir'] = $target_dir;
// else {
//   $target_dir = $_SESSION['dir'] . (!empty($_GET['fn']) ? '/' .  $_GET['fn'] : '');
//   $_SESSION['dir'] = $target_dir;
// };
// echo $target_dir . '<br>';
// echo $_SESSION['dir'] . '<br>';
// if (!empty($_GET['fn'])) echo $_GET['fn'];


if (!empty($_POST['create-folder'])) {
  if (!file_exists("users-folders/$userId" . '/' . $_POST['create-folder']))
    mkdir("users-folders/$userId" . '/' . $_POST['create-folder'], 0777, true);
}


if (!empty($_POST['upload-file'])) {
  $target_file = $target_dir . '/'  . basename($_FILES["file-to-upload"]["name"]);
  $uploadOk = true;
  // Check if file already exists
  if (file_exists($target_file)) {
    $uploadOk = false;
  }
  // Check if $uploadOk store the file
  if ($uploadOk) {
    move_uploaded_file($_FILES["file-to-upload"]["tmp_name"], $target_file);
  }
};

if (!empty($_POST['itemsToDelete'])) {
  print_r($_POST['itemsToDelete']);
  die;
}

print_r($_POST);
print_r($_REQUEST);

$userFiles = array_slice(scandir($target_dir), 2);

/* ------ ------ */
// delete files 
// preveiw imgs 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
  <link rel="stylesheet" href="./dist/css/main.css" />

  <title>File Manager</title>

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container p-3">
      <a class="navbar-brand" href="#"><strong> File Managment System </strong>
      </a>

      <div>
        <button class="btn btn-trans"><a href="logout.php">
            <i class="fas fa-sign-out-alt"></i>Log Out
          </a>
        </button>
        <button class="btn btn-trans">
          <i class="fas fa-user"></i><?php echo $username; ?>
        </button>
      </div>
    </div>
  </nav>
  <div class="container py-5">
    <div class="d-flex justify-content-between" id="navbarSupportedContent">
      <div>
        <i class="fas fa-folder-open fa-2x"></i>
        <h2 class="d-inline-block">File Manager</h2>
      </div>
      <div>
        <button class="btn btn-primary my-2 my-lg-0" type="button" data-toggle="modal" data-target="#create-folder-modal">
          Create Folder
        </button>
        <form enctype="multipart/form-data" action="" method="POST" class="d-inline-block">
          <label class="btn btn-primary my-0 ml-2">
            Upload File
            <input type="file" id="my_file" name="file-to-upload" hidden>
          </label>
          <input value="upload image" name='upload-file' type="submit" id="btnSubmit" hidden>
        </form>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" id="create-folder-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Folder</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="row">
              <div class="col-12">
                <input type="text" name="create-folder" class="form-control" />
              </div>
              <div class="col-12 mt-3 d-flex justify-content-end">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                  cancel
                </button>
                <button type="submit" class="btn btn-primary ml-3">
                  Create Folder
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="wrapper py-4">
    <div class="container">
      <table class="table table-striped bg-white">
        <thead>
          <tr>
            <th scope="col">Title/name</th>
            <th scope="col">File Type</th>
            <th scope="col">Date Added</th>
            <th scope="col">Manage</th>
            <th scope="col"><input type="checkbox" id="selectAll" /></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($userFiles as $file) {
            $name_file = "?fn=" . $file;
            $iconName = '';
            $fileType = basename(mime_content_type($target_dir . '/' . $file));

            if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
              $iconName = 'fa-folder-open';
            } else {
              $iconName = 'fa-eye';
            }
          ?>
            <tr>
              <th scope="row">
                <a <?= is_dir($target_dir . '/' . $file) ? 'href="filemanager.php' . $name_file . '"' : '' ?>>
                  <?= $file ?>
                </a>
              </th>
              <td><?= mime_content_type($target_dir . "/" . $file) == 'directory' ? 'Folder' : mime_content_type($target_dir . "/" . $file)  ?></td>
              <td><?= date("Y/m/d h:i:sa", fileatime($target_dir . "/" . $file)) ?></td>
              <td>
                <i class="fas <?= $iconName ?>  fa-2x text-success"></i><i class="fas fa-trash-alt fa-2x text-danger"></i>
              </td>
              <th scope="col"><input type="checkbox" class="select" value="<?= $file ?>" /></th>
            </tr>
          <?php } ?>

        </tbody>
      </table>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="app.js"></script>

</html>