<?php

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
