<?php



define('imgsExt', ['jpeg', 'gif', 'png', 'jpg']);
define('videosExt', ['mp4', 'mov', 'wmv', 'flv', 'avi', 'webm']);


function createFolderHandler($targetDir)
{
    if (!file_exists($targetDir . '/' . $_POST['create-folder'])) {
        mkdir($targetDir . '/' . $_POST['create-folder'], 0777, true);
        die(json_encode(true));
    } else die(json_encode(false));
}

function deleteHandler($targetDir)
{
    $itemsToDelete = $_POST['itemsToDelete'];
    foreach ($itemsToDelete as $item) {
        if (is_dir($targetDir . '/' . $item)) {
            system('rm -rf -- ' . escapeshellarg($targetDir . '/' . $item), $retval);
        } else unlink($targetDir . '/' . $item);
    }
}

function uploadHandler($targetDir)
{
    $file = pathinfo($_FILES["file-to-upload"]["name"]);
    $fileName = str_replace(' ', '', $file['filename']);
    $i = 1;
    while (file_exists($targetDir . '/' . $fileName . "." . $file['extension'])) {
        $fileName = $file['filename'] . " ($i)";
        $i++;
    }
    $targetFile = $targetDir . '/'  . $fileName . '.' . $file['extension'];

    move_uploaded_file($_FILES["file-to-upload"]["tmp_name"], $targetFile);
}
