<?php
if (!empty($_POST)) {
  $user_data = json_decode(file_get_contents('user_data.json'), true);
  $user_id = count($user_data) + 1;
  $error_fname = false;
  $error_lname = false;
  $error_pass = false;
  $error = false;
  $data = $_POST;

  //validate
  foreach ($data as $key =>  $value) {
    if ($key == "firstname" || $key == "lastname") {
      if (empty($value)) {
        $error_lname = true;
        $error = true;
      }

      if ($key == "password") {
        if (empty($value)) {
          $error_pass = true;
          $error = true;
        }
      }
    }
  }
  if (!$error) {
    $data['id'] = $user_id;
    $user_data[] = $data;

    // encode array to json
    $json = json_encode($user_data);
    // var_dump($json);die;
    $file = fopen("user_data.json", "w");
    fwrite($file, $json);
    fclose($file);
    return $json;
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
  <div class="container h-75 form-wrapper">
    <div class="row flex-md-row h-100 bg-danger">
      <div class="col col-md-4 bg-info">
        <div class="d-flex flex-column ">
          <div class="col col-12 p-4 bg-danger  justify-self-stretch ">
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

      <div class="col col-md-8 bg-light py-4 px-5">
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" class="main-form needs-validation" novalidate>
          <div class="form-group">
            <label for="username">First Name</label>
            <input type="text" name="firstname" id="firstname" placeholder="Firstname" class="form-control " required />
            <div class=" invalid-feedback">first name is required</div>
          </div>
          <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" placeholder="Lastname" class="form-control <?= ($error_lname) ? "is-invalid" : '' ?>" />
            <div class="invalid-feedback">last name is required</div>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="Email" class="form-control <?= ($error_lname) ? "is-invalid" : '' ?>" />
            <div class="invalid-feedback">last name is required</div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control" required maxlength="20" minlength="6" />
            <div class="invalid-feedback">
              password should be at least 6 characters
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-checkbox checkbox-lg">
              <input type="checkbox" class="custom-control-input" id="terms" required />
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