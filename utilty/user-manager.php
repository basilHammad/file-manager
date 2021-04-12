<?php

function signupHandler(&$isSubmitted, &$errors, $usersData, $formData, $userId, $file)
{
    $isSubmitted = true;
    // validate and test the form   
    $errors =  validation($formData, 'signup');

    // check if the email exist 
    foreach ($usersData as $user) {
        if ($user['email'] == $formData['email'])
            $errors['email'] = 'email exist try to log in';
    };

    if (!$errors) {
        // create users file  and register new users
        $formData['id'] = $userId;
        $usersData[] = $formData;
        $json = json_encode($usersData);
        fwrite($file, $json);
        fclose($file);


        // start the session and redirect the user 
        $_SESSION['id'] = $userId;
        $_SESSION['name'] = $formData['firstname'];
        header("Location:index.php?page=filemanager");
    }
}


function loginHandler(&$isSubmitted, &$errors, $usersData, $formData)
{
    $isSubmitted = true;
    // validate and test the form
    $errors = validation($formData, 'login');
    // check if the user is valid and redirect him
    if (!$errors) {
        if (!empty($usersData)) {
            foreach ($usersData as $user) {
                if ($user['email'] == $formData['email']) {
                    if ($user['password'] == $formData['password']) {
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['name'] = $user['firstname'];
                        header("Location:index.php?page=filemanager");
                    } else {
                        $errors['password'] = 'password not correct';
                    }
                } else {
                    $errors['email'] = 'email does not exist';
                }
            }
        } else {
            $errors['email'] =  'email does not exist';
        }
    }
}

function validation($data, $page)
{
    $errors = [];
    foreach ($data as $key => &$value) {
        // test form data
        $value = testInput($value);
        // validate form data
        if ($page == 'signup') {
            if ($key == 'firstname' && empty($value)) $errors['firstname'] = 'first name is required!';
            if ($key == 'lastname' && empty($value)) $errors['lastname'] = 'last name is required!';
            if ($key == 'email') {
                if (empty($value))  $errors['email'] = 'email is required!';
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'please enter a valid email';
            };
            if ($key == 'password') {
                if (empty($value)) $errors['password'] = 'password is required!';
                if (strlen($value) < 6) $errors['password'] = 'password should be at least 6 characters';
            };
        } else {
            if ($key == 'email') {

                if (empty($value)) $errors['email'] = 'email is required!';
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'please enter a valid email';
            };
            if ($key == 'password') {
                if (empty($value)) $errors['password'] = 'password is required!';
                if (strlen($value) < 6) {
                    $errors['password'] = 'password should be at least 6 characters';
                }
            };
        }
    };
    return $errors;
}


function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};
