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
                        <p class="text-white">Sign in with your email and password</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-9 bg-light py-4 px-5">
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" class="main-form needs-validation" novalidate>
                    <div class="form-group">
                        <label for="username">First Name</label>
                        <input type="text" name="firstname" value="<?= $_POST['firstname'] ? $_POST['firstname'] : ''  ?>" id="firstname" placeholder="Firstname" class="form-control <?php echo $errors['firstname'] ?  'is-invalid' : ''; ?> " autocomplete="off" required />
                        <div class=" invalid-feedback"><?php echo $isSubmitted ? $errors['firstname'] : 'first name is required !' ?></div>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" value="<?= $_POST['lastname'] ? $_POST['lastname'] : ''  ?>" id="lastname" placeholder="Lastname" class="form-control <?php echo $errors['lastname'] ?  'is-invalid' : ''; ?>" autocomplete="off" required />
                        <div class="invalid-feedback"><?php echo $isSubmitted ?  $errors['lastname'] : 'last name is required !' ?></div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" value="<?= $_POST['email'] ? $_POST['email'] : ''  ?>" id="email" placeholder="Email" class="form-control <?php echo $errors['email'] ?  'is-invalid' : ''; ?>" autocomplete="off" required />
                        <div class="invalid-feedback"><?php echo $isSubmitted ? $errors['email'] : 'email is required !' ?></div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control <?php echo $errors['password'] ?  'is-invalid' : ''; ?>" autocomplete="off" required />
                        <div class="invalid-feedback">
                            <?php echo $isSubmitted ? $errors['password'] : 'password is required !' ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox checkbox-lg">
                            <input type="checkbox" name='terms' value="accepted" class="custom-control-input" id="terms" required />
                            <label class="custom-control-label" for="terms">I Agree with the terms and conitions</label>
                        </div>
                    </div>

                    <div class="buttons">
                        <button name="signup" type="submit" class="btn btn-success btn-lg">
                            Submit
                        </button>
                        <span class="or">Or</span>
                        <a href="login" class="btn btn-light btn-lg">Log In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>