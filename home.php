<?php
require 'validation.php';

$isSubmitted = false;
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userData = json_decode(file_get_contents('user_data.json'), true) ?: [];
    $userId = count($userData) + 1;
    $formData = $_POST;
    $isSubmitted = true;

    // validate and test the form   
    $errors =  validation($formData, 'home');

    // check if the email exist 
    foreach ($userData as $user) {
        if ($user['email'] == $formData['email'])
            $errors['email'] = 'email exist try to log in';
    };

    if (!$errors) {
        // create users file  and register new users
        $formData['id'] = $userId;
        $userData[] = $formData;
        $json = json_encode($userData);
        $file = fopen('user_data.json', 'w');
        fwrite($file, $json);
        fclose($file);

        // start the session and redirect the user 
        session_start();
        $_SESSION['id'] = $userId;
        $_SESSION['name'] = $formData['firstname'];
        header("Location:newmanager.php");
    }
};



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <title>File Managment System</title>
    <link rel="stylesheet" href="dist/css/main.css" />
</head>

<body class="main-container">

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

                <div class="col-sm-12 col-md-9 bg-light py-4 px-5">
                    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" class="main-form needs-validation" novalidate>
                        <div class="form-group">
                            <label for="username">First Name</label>
                            <input type="text" name="firstname" id="firstname" placeholder="Firstname" class="form-control <?php echo $errors['firstname'] ?  'is-invalid' : ''; ?> " required />
                            <div class=" invalid-feedback"><?php echo $isSubmitted ? $errors['firstname'] : 'first name is required !' ?></div>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" id="lastname" placeholder="Lastname" class="form-control <?php echo $errors['lastname'] ?  'is-invalid' : ''; ?>" required />
                            <div class="invalid-feedback"><?php echo $isSubmitted ?  $errors['lastname'] : 'last name is required !' ?></div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" placeholder="Email" class="form-control <?php echo $errors['email'] ?  'is-invalid' : ''; ?>" required />
                            <div class="invalid-feedback"><?php echo $isSubmitted ? $errors['email'] : 'email is required !' ?></div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" class="form-control <?php echo $errors['password'] ?  'is-invalid' : ''; ?>" required />
                            <div class="invalid-feedback">
                                <?php echo $isSubmitted ? $errors['password'] : 'password is required !' ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox checkbox-lg">
                                <input type="checkbox" name='terms' value="accepted" class="custom-control-input <?php echo $errors['terms'] ?  'is-invalid' : ''; ?>" id="terms" required />
                                <label class="custom-control-label" for="terms">I Agree with the terms and conitions</label>
                            </div>
                        </div>

                        <div class="buttons">
                            <button type="submit" class="btn btn-success btn-lg">
                                Submit
                            </button>
                            <span class="or">Or</span>
                            <a href="./login.php" class="btn btn-light btn-lg">Log In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            const form = document.querySelector(".main-form");
            form.addEventListener("submit", (e) => {
                if (form.checkValidity() === false) {
                    e.preventDefault();
                    e.stopPropagation();
                    form.classList.add("was-validated");
                }
            });
        </script>
    </body>

</html>