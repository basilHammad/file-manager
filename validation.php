<?php

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
                if (strlen($value) < 6) $errors['password'] = 'password should be at least 6 characters';
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
