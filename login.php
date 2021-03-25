<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors', 1);
error_reporting(-1);

$user_data = json_decode(file_get_contents('user_data.json'), true);
if (!empty($_POST)) {
  foreach ($user_data as $user) {
    if ($user['email'] == $_POST['email']) {
      if ($user['password'] == $_POST['password']) {
        session_start();
        $_SESSION["user_id"] = $user['id'];
        $_SESSION["name"] = $user['firstname'];
        header("Location:filemanager.php");
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
    <div class="row flex-md-row h-100 ">
      <div class="col col-md-4 bg-info">
        <div class="row">
          <div class="col col-12 p-4">
            <h1 class="text-white">Sign Up</h1>
            <p class="text-white">
              Sign up with your simple details,it will not be cross checked
              with the adminstration
            </p>
          </div>
          <div class="col col-12 p-4">
            <h1 class="text-white">Sign In</h1>
            <p class="text-white">Sign in with username and password</p>
          </div>
        </div>
      </div>

      <div class="col col-md-8 bg-light py-4 px-5   ">
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" class="main-form needs-validation " novalidate>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="Email" required class="form-control" />
            <div class="invalid-feedback">last name is required</div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control" required maxlength="20" minlength="6" />
            <div class="invalid-feedback">
              password should be at least 6 characters
            </div>
          </div>

          <button class="btn btn-success btn-lg">Log In</button>
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