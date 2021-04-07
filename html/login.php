<body class="main-container">
    <div class="container form-wrapper">
        <div class="row">
            <div class="col-sm-12 col-md-3 bg-info d-flex">
                <div class="row py-4">
                    <div class="col-sm-6 col-md-12">
                        <h1 class="text-white">Sign Up</h1>
                        <p class="text-white">
                            Sign up with your simple details,it will not be cross checked
                            with the adminstration
                        </p>
                    </div>
                    <div class="col-sm-6 col-md-12">
                        <h1 class="text-white">Sign In</h1>
                        <p class="text-white">Sign in with username and password</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-9 bg-light py-4 px-5 ">
                <form action="" method="POST" class="main-form needs-validation " novalidate>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="<?= $_POST['email'] ? $_POST['email'] : ''  ?>" id="email" autocomplete="off" placeholder="Email" class="form-control <?php echo $errors['email'] ?  'is-invalid' : ''; ?>" required />
                        <div class="invalid-feedback"><?php echo $isSubmitted ? $errors['email'] : 'email is required !' ?></div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" value="<?= $_POST['password'] ? $_POST['password'] : ''  ?>" id="password" autocomplete="off" placeholder="Password" class="form-control <?php echo $errors['password'] ?  'is-invalid' : ''; ?>" required />
                        <div class="invalid-feedback">
                            <?php echo $isSubmitted ? $errors['password'] : 'password is required !' ?>
                        </div>
                    </div>

                    <div class="buttons">
                        <button name='login' type="submit" class="btn btn-success btn-lg">
                            Log In
                        </button>
                        <span class="or">Or</span>
                        <a href="index.php" class="btn btn-light btn-lg">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>