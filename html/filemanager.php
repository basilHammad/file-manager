<body>

    <?php include_once 'header.php'; ?>

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
            <div class="table-wrapper">
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
                        foreach ($userFiles as $file) {
                            $subDir = !empty($_GET['fn']) ? $_GET['fn'] . '&subdir=' .  $file : $file;
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
                                    <a <?= is_dir($targetDir . '/' . $file) ? 'href="' . $_GET['page'] . $name_file . '"' : "href=preview$name_file" ?>>
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
    </div>
</body>