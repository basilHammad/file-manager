<body>

    <?php include_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class=" col-sm-12 col-md-6 d-flex flex-column justify-content-center align-items-stretch">


                <?php
                if (in_array($fileType, imgsExt)) {
                ?>
                    <img class="info-img" src="<?= $file ?>" data-item-name="<?= $file ?>" alt="">
                <?php } else if (in_array($fileType, videosExt)) { ?>
                    <video class="info-img" controls data-item-name="<?= $file ?>">
                        <source src="<?= $file ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php } else {
                ?>
                    <img class="info-img" src="html/imgs/Cosa-sono-i-codici-di-errore-HTTP-I-codici-comuni-e-Come-risolverli-768x403.png" alt="">
                    <strong class="errore-msg">we can't prview this file</strong>
                <?php
                }
                ?>

            </div>
            <div class="col-sm-12 col-md-6  pt-5 px-4">
                <h3> File Name :<?= $fileName ?></h3>
                <h3> File date :<?= $fileDate ?></h3>
                <h3> File Size :<?= $fileSize ?></h3>
                <h3> File Type :<?= $fileType ?></h3>
            </div>
        </div>
    </div>

</body>