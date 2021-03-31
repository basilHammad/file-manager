<?php

require 'validation.php';

$usersData = json_decode(file_get_contents('user-data.json'), true);
$formData = $_POST;
$isSubmitted = false;
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isSubmitted = true;
  // validate and test the form
  $errors = validation($formData, 'login');
  // check if the user is valid and redirect him
  if (!$errors) {
    foreach ($usersData as $user) {
      if ($user['email'] == $formData['email']) {
        if ($user['password'] == $formData['password']) {
          session_start();
          $_SESSION['id'] = $user['id'];
          $_SESSION['name'] = $user['firstname'];
          header("Location:filemanager.php");
        } else {
          $errors['password'] = 'password not correct';
        }
      } else {
        $errors['email'] = 'email does not exist';
      }
    }
  }
}
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
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" class="main-form needs-validation " novalidate>
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

          <div class="buttons">
            <button type="submit" class="btn btn-success btn-lg">
              Log In
            </button>
            <span class="or">Or</span>
            <a href="./home.php" class="btn btn-light btn-lg">Sign Up</a>
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