<?php
require './utilty/validation.php';
require './utilty/signup-handler.php';
require './utilty/login-handler.php';
require './utilty/create-folder-handler.php';
require './utilty/upload-handler.php';
require './utilty/delete-handler.php';


$imgsExt = ['jpeg', 'gif', 'png', 'jpg'];
$videosExt = ['mp4', 'mov', 'wmv', 'flv', 'avi', 'webm'];

session_start();
// redirect the user if have id session
if (isset($_SESSION['id']) && !isset($_GET['page'])) {
    header('Location:index.php?page=filemanager');
}


$usersData = json_decode(file_get_contents('user-data.json'), true) ?: []; // all users
$userId = count($usersData) + 1; //unique id for every user
$errors = [];
$isSubmitted = false;
$formData = [
    'firstname' => $_POST['firstname'],
    'lastname'    => $_POST['lastname'],
    'email' => $_POST['email'],
    'password' => $_POST['password']
];

if (!empty($formData && isset($_POST['signup']))) {
    signupHandler($isSubmitted, $errors, $usersData, $formData, $userId);
};

if (!empty($formData) && isset($_POST['login']))
    loginHandler($isSubmitted, $errors, $usersData, $formData);


if ($_GET['page'] == 'filemanager') {
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];
        $username = $_SESSION['name'];
        $targetDir = 'users-folders/' . $userId . (!empty($_GET['fn']) ? '/' .  $_GET['fn'] : '');

        // create the main folder and the user folder if not exist
        if (!file_exists('users-folders')) mkdir('users-folders', 0777, true);
        if (!file_exists("users-folders/$userId")) mkdir("users-folders/$userId", 0777, true);
    } else header("Location:index.php"); // redirect the user if he dont have a vaild id session

    // handle creating folders
    if (!empty($_POST['create-folder'])) createFolderHandler($targetDir);

    // handle uploading files
    if (!empty($_POST['upload-file'])) uploadHandler($targetDir);

    // handle delete files and folders
    if (!empty($_POST['itemsToDelete']))  deleteHandler($targetDir);
}

if ($_GET['page'] == 'preview') {
    if ($_SESSION['id']) {
        $userId = $_SESSION['id'];
        $username = $_SESSION['name'];
    } else header("Location:index.php"); // redirect the user if he dont have a vaild id session

    $file = 'users-folders/' . $userId . (!empty($_GET['fn']) ? '/' .  $_GET['fn'] : '');
    $fileName = basename($file);
    $fileType = basename(mime_content_type($file));
    $fileDate =  date("Y/m/d h:i:sa", fileatime($file));
    $fileSize = filesize($file);
}


if ($_GET['page'] == 'logout') {
    session_destroy();
    header("Location:index.php");
}

$userFiles = array_slice(scandir(preg_replace("/(\.\.\/)/", "", $targetDir)), 2);
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
    <title>File Managment System</title>
</head>
<?php

switch ($_GET['page']) {
    case 'login':
        include_once './html/login.php';
        break;
    case 'filemanager':
        include_once './html/filemanager.php';
        break;
    case 'preview':
        include_once './html/preview.php';
        break;
    default:
        include_once './html/signup.php';
};
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="app.js"></script>

</html>