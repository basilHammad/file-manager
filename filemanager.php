<?php
session_start();
// if ($_SESSION['user_id'])
// $user_id = $_SESSION['user_id'];
$user_id = 1;
// else
//   header("Location:login.php");

if (!empty($_POST['folder_name'])) {
  if (!file_exists('users')) {
    mkdir('users', 0777, true);
  }
  if (!file_exists('users/' . $user_id)) {
    mkdir('users/' . $user_id, 0777, true);
  }
  if (!file_exists('users/' . $user_id . '/' . $_POST['folder_name'])) {
    mkdir('users/' . $user_id . '/' . $_POST['folder_name'], 0777, true);
  }
}
$dir = 'users/' . $user_id . (!empty($_GET['fn']) ? '/' . $_GET['fn'] : '');

if ($_FILES['my_file']['name'] != "") {
  // var_dump($_FILES['my_file']['name']);die;
  // Where the file is going to be stored
  $target_dir = $dir . '/';
  $file = $_FILES['my_file']['name'];
  $path = pathinfo($file);
  $filename = $path['filename'];
  $ext = $path['extension'];
  $temp_name = $_FILES['my_file']['tmp_name'];
  $path_filename_ext = $target_dir . $filename . "." . $ext;

  // Check if file already exists
  // var_dump(move_uploaded_file($temp_name,$path_filename_ext),$temp_name,$path_filename_ext);die;
  move_uploaded_file($temp_name, $path_filename_ext);
}

$allFile = [];
if ($handle = opendir($dir)) {

  while (false !== ($entry = readdir($handle))) {

    // echo mime_content_type($entry);
    if ($entry != "." && $entry != "..") {

      $allFile[] = [
        'name' => $entry,
        'ext' => pathinfo($entry, PATHINFO_EXTENSION)
      ];
    }
  }

  closedir($handle);
}

// die;

// $allFile = scandir('users/'.$user_id);
// print_r($allFile);die;





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

  <title>Document</title>

  <style></style>
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
          <i class="fas fa-user"></i>Admin
        </button>
      </div>
    </div>
  </nav>
  <div class="container p-5">
    <div class="d-flex justify-content-between" id="navbarSupportedContent">
      <div>
        <i class="fas fa-folder-open fa-2x"></i>
        <h2 class="d-inline-block">File Manager</h2>
      </div>
      <div>
        <button class="btn btn-primary my-2 my-lg-0" type="button" data-toggle="modal" data-target="#create-folder-modal">
          Create Folder
        </button>
        <form id="upload_file" enctype="multipart/form-data" action="" method="POST">
          <label class="btn btn-primary my-0 ml-2">
            Upload File <input type="file" id="my_file" name="my_file" hidden>
          </label>
          <input type="submit" id="btnSubmit" style="visibility: hidden;" />

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
          <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
            <div class="row">
              <div class="col-12">
                <input type="text" name="folder_name" class="form-control" />
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
        <!-- <div class="modal-footer"> -->
        <!-- </div> -->
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
            <th scope="col"><input type="checkbox" /></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($allFile as $file) {
            $name_file = "?fn=" . $file['name'];
          ?>
            <tr>
              <th scope="row"><a <?= is_dir('users/' . $user_id . '/' . $file['name']) ? 'href="filemanager.php' . $name_file . '"' : '' ?>><?= $file['name'] ?></a></th>
              <td><?= $file['ext'] ?></td>
              <td>Otto</td>
              <td>
                <i class="fas fa-eye fa-2x text-success"></i><i class="fas fa-trash-alt fa-2x text-danger"></i>
              </td>
              <th scope="col"><input type="checkbox" /></th>
            </tr>
          <?php } ?>

        </tbody>
      </table>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</html>

<script>
  $("#my_file").on("change", function() {
    $("#btnSubmit").click();
  });
</script>