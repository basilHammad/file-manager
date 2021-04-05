<?php
$imgsExt = ['jpeg', 'gif', 'png', 'jpg'];
$videosExt = ['mp4', 'mov', 'wmv', 'flv', 'avi', 'webm'];

// start the session and take the user id and name from it
session_start();
if ($_SESSION['id']) {
  $userId = $_SESSION['id'];
  $username = $_SESSION['name'];
  // create the main folder and the user folder if not exist
  if (!file_exists('users-folders')) mkdir('users-folders', 0777, true);
  if (!file_exists("users-folders/$userId")) mkdir("users-folders/$userId", 0777, true);
} else header("Location:index.php"); // redirect the user if he dont have a vaild id session

$targetDir = 'users-folders/' . $userId . (!empty($_GET['fn']) ? '/' .  $_GET['fn'] : '');

// handle creating folders
if (!empty($_POST['create-folder'])) {
  if (!file_exists($targetDir . '/' . $_POST['create-folder'])) {
    mkdir($targetDir . '/' . $_POST['create-folder'], 0777, true);
    die(json_encode(true));
  } else die(json_encode(false));
}

// handle uploading files
if (!empty($_POST['upload-file'])) {
  $file = pathinfo($_FILES["file-to-upload"]["name"]);
  $fileName = $file['filename'];
  $i = 1;
  while (file_exists($targetDir . '/' . $fileName . "." . $file['extension'])) {
    $fileName = $file['filename'] . " ($i)";
    $i++;
  }
  $targetFile = $targetDir . '/'  . $fileName . '.' . $file['extension'];

  move_uploaded_file($_FILES["file-to-upload"]["tmp_name"], $targetFile);
};

// handle delete files and folders
if (!empty($_POST['itemsToDelete'])) {
  $itemsToDelete = $_POST['itemsToDelete'];
  foreach ($itemsToDelete as $item) {
    if (is_dir($targetDir . '/' . $item)) {
      system('rm -rf -- ' . escapeshellarg($targetDir . '/' . $item), $retval);
    } else unlink($targetDir . '/' . $item);
  }
}
// scan the directory for files and folders
$userFiles = array_slice(scandir($targetDir), 2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
  <link rel="stylesheet" href="dist/css/main.css" />

  <title>File Manager</title>

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container p-3">

      <a class="navbar-brand" href="index.php">
        <strong> File Managment System </strong>
      </a>

      <div>
        <button class="btn btn-trans"><a class="log-out" href="logout.php">
            <i class="fas fa-sign-out-alt"></i>Log Out
          </a>
        </button>
        <button class="btn btn-trans">
          <i class="fas fa-user"></i><?= $username; ?>
        </button>
      </div>
    </div>
  </nav>
  <div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between" id="navbarSupportedContent">
      <div>
        <i class="fas fa-folder-open fa-2x"></i>
        <h2 class="d-inline-block">File Manager</h2>
      </div>
      <div class="">
        <button class="btn btn-primary my-2 my-lg-0" type="button" data-toggle="modal" data-target="#create-folder-modal">
          Create Folder
        </button>
        <form enctype="multipart/form-data" action="" method="POST" class="d-inline-block">
          <label class="btn btn-primary my-0 ml-2">
            Upload File
            <input type="file" id="file-to-upload" name="file-to-upload" hidden>
          </label>
          <input name='upload-file' type="submit" id="btnSubmit" hidden>
        </form>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" id="create-folder-modal">
    <div class="container pt-4" id="create-alert">
      <div class="alert alert-warning" role="alert">
        File already exists !
      </div>
    </div>
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
                <div class="form-group">
                  <input type="text" name="create-folder" class="form-control" id="create-folder-input" />
                  <div class="invalid-feedback">Invalid Folder Name !</div>
                </div>
              </div>
              <div class="col-12 mt-3 d-flex justify-content-end">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                  cancel
                </button>
                <button id="create-folder" type="submit" class="btn btn-primary ml-3">
                  Create Folder
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade bd-example-modal-lg" id="image" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

      <div class="modal-content">
        <?php
        // rendering imgs to view them
        foreach ($userFiles as $file) {
          $fileType = basename(mime_content_type($targetDir . '/' . $file));
          if (in_array($fileType, $imgsExt)) {
        ?>
            <img src="<?= $targetDir . '/' . $file ?>" data-item-name="<?= $file ?>" alt="">
          <?php } else if (in_array($fileType, $videosExt)) { ?>
            <video controls data-item-name="<?= $file ?>">
              <source src="<?= $targetDir . '/' . $file ?>" type="video/mp4">
              Your browser does not support the video tag.
            </video>
        <?php }
        } ?>
      </div>
    </div>
  </div>

  <div class="wrapper py-4">
    <div class="container">
      <i class="fas fa-arrow-circle-left fa-2x text-primary" id="back"></i>
      <table class="table table-striped bg-white mt-3">
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
          <?php
          // rendering files and folders
          foreach ($userFiles as $file) {
            $subDir = !empty($_GET['fn']) ? $_GET['fn'] . '/' .  $file : $file;
            $name_file = "?fn=" .  $subDir;
            $iconName = '';
            $fileType = basename(mime_content_type($targetDir . '/' . $file));
            if (in_array($fileType, $imgsExt) || in_array($fileType, $videosExt)) {
              $iconName = 'fa-eye';
            } else {
              $iconName = 'fa-folder-open';
            }
          ?>
            <tr>
              <th scope="row" class="file-name">
                <a <?= is_dir($targetDir . '/' . $file) ? 'href="filemanager.php' . $name_file . '"' : 'href="preview.php'  . $name_file . '"' ?>>
                  <?= $file ?>
                </a>
              </th>
              <td><?= mime_content_type($targetDir . "/" . $file) == 'directory' ? 'Folder' : mime_content_type($targetDir . "/" . $file)  ?></td>
              <td><?= date("Y/m/d h:i:sa", fileatime($targetDir . "/" . $file)) ?></td>
              <td>
                <i class="fas <?= $iconName ?> text-dark"></i><i class="fas fa-trash-alt text-dark"></i>
              </td>
              <th scope="col"><input type="checkbox" class="select" value="<?= $file ?>" /></th>
            </tr>
          <?php } ?>

        </tbody>
      </table>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <script src="app.js"></script>
</body>

</html>