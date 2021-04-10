<?php
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
