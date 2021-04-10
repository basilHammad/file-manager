<?php

function signupHandler(&$isSubmitted, &$errors, $usersData, $formData, $userId)
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
        $file = fopen('user-data.json', 'w');
        fwrite($file, $json);
        fclose($file);

        // start the session and redirect the user 
        $_SESSION['id'] = $userId;
        $_SESSION['name'] = $formData['firstname'];
        header("Location:index.php?page=filemanager");
    }
}
