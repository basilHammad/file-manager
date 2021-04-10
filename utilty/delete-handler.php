<?php

function deleteHandler($targetDir)
{
    $itemsToDelete = $_POST['itemsToDelete'];
    foreach ($itemsToDelete as $item) {
        if (is_dir($targetDir . '/' . $item)) {
            system('rm -rf -- ' . escapeshellarg($targetDir . '/' . $item), $retval);
        } else unlink($targetDir . '/' . $item);
    }
}
