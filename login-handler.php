<?PHP
function login($users, $newData)
{
    $errors = [];
    foreach ($users as $user) {
        if ($user['email'] == $newData['email']) {
            if ($user['password'] == $newData['password']) {
                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['firstname'];
                header("Location:filemanager.php");
                return;
            }
            return $errors['password'] = 'password not correct';
        }
        return $errors['email'] = 'email does not exist';
    }
}
