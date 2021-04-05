<?php


session_start();
if ($_SESSION['id']) {
    $userId = $_SESSION['id'];
    $username = $_SESSION['name'];
} else header("Location:index.php"); // redirect the user if he dont have a vaild id session

$file = 'users-folders/' . $userId . (!empty($_GET['fn']) ? '/' .  $_GET['fn'] : '');
$fileName = basename($file);
$fileType = basename(mime_content_type($file));
$fileDate =  date("Y/m/d h:i:sa", fileatime($file));
$fileSize = filesize($file);
$imgsExt = ['jpeg', 'gif', 'png', 'jpg'];
$videosExt = ['mp4', 'mov', 'wmv', 'flv', 'avi', 'webm'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="dist/css/main.css" />

    <title>Document</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container p-3">

            <a class="navbar-brand" href="index.php">
                <strong> File Managment System </strong>
            </a>

            <div>
                <button class="btn btn-trans"><a class="log-out" href="filemanager.php">
                        <i class="fas fa-sign-out-alt"></i>Log Out
                    </a>
                </button>
                <button class="btn btn-trans">
                    <i class="fas fa-user"></i><?= $username; ?>
                </button>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col col-sm-12 col-md-6">


                <?php
                if (in_array($fileType, $imgsExt)) {
                ?>
                    <img class="info-img" src="<?= $file ?>" data-item-name="<?= $file ?>" alt="">
                <?php } else if (in_array($fileType, $videosExt)) { ?>
                    <video class="info-img" controls data-item-name="<?= $file ?>">
                        <source src="<?= $file ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php } else {
                ?>
                    <h1>We Can't Preview This File!!</h1>
                <?php
                }
                ?> ;

            </div>
            <div class="col col-sm-12 col-md-6  pt-5">
                <h2> File Name :<?= $fileName ?></h2>
                <h2> File date :<?= $fileDate ?></h2>
                <h2> File Size :<?= $fileSize ?></h2>
                <h2> File Type :<?= $fileType ?></h2>
            </div>
        </div>
    </div>

</body>

</html>