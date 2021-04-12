<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container p-3">

        <a class="navbar-brand" href="index.php?page=filemanager">
            <strong> File Managment System </strong>
        </a>

        <div>
            <button class="btn btn-trans"><a class="log-out" href="index.php?page=logout">
                    <i class="fas fa-sign-out-alt"></i>Log Out
                </a>
            </button>
            <button class="btn btn-trans">
                <i class="fas fa-user"></i><?= $username; ?>
            </button>
        </div>
    </div>
</nav>