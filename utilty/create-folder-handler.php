<?php

function createFolderHandler($targetDir)
{
    if (!file_exists($targetDir . '/' . $_POST['create-folder'])) {
        mkdir($targetDir . '/' . $_POST['create-folder'], 0777, true);
        die(json_encode(true));
    } else die(json_encode(false));
}
