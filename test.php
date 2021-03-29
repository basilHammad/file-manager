<?php



// function test()
// {
//     static  $x = 0;
//     echo $x . '<br>';
//     $x++;
// };

// test();
// test();
// test();
// $txt1 = "Learn PHP";
// $txt2 = "basil ahmad hammad";
// $x = '7.656565';
// $y;

// define('names', ['basil', 'omar', 'yazeed']);

// function test()
// {
//     print_r(names);
// };


// $arr = ['name' => 'basil', 'age' => 20, 'lastn' => 'hammad'];
// echo $arr->name;
// $arr['name'] = 'omar';
// echo $arr['name'];

// $cars = [['bmw', 'ss', 'asdas'], ['mrecides', '30', 'asda']];
// echo $cars[0][0] . ' ' . $cars[1][0];

// for ($i = 0; $i < count($cars); $i++) {
//     for ($j = 0; $j < count($cars[$i]); $j++) {
//         echo $cars[$i][$j] . '<br>';
//     }
// }




// foreach ($arr as $key => $value) {
//     echo $key  . '<br>';
// }

// $gg = "<script>location.href('http://www.hacked.com')</script>";

// $gg =  htmlspecialchars("<script>location.href('http://www.hacked.com')</script>");

// echo $gg;

// echo "Today is " . date("Y/m/d") . "<br>";
// echo "Today is " . date("Y.m.d") . "<br>";
// echo "Today is " . date("Y,m,d") . "<br>";
// echo "Today is " . date("l") . "<br>";
// date_default_timezone_set("Jordan");
// echo "The time is " . date("h:i:s a");

// $userDataFile = fopen('user_data.json', 'r');
// $userData = json_decode(fread($userDataFile, filesize("user_data.json")));
// echo '<pre>';
// var_dump($userData);
// echo '<pre>';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $userData = json_decode(file_get_contents('test.json'), true) ?: [];
//     $userId = count($userData) + 1;
//     $userData[] = $_POST;
//     $json = json_encode($userData);
//     $file = fopen('test.json', 'w');
//     fwrite($file, $json);
//     fclose($file);
// }
?>

<?php
// if (basename($_FILES["fileToUpload"]["name"])) {
//     echo $_FILES["fileToUpload"]["name"] . '<br>';
//     echo $_FILES["fileToUpload"]["type"] . '<br>';
//     echo $_FILES["fileToUpload"]["tmp_name"] . '<br>';
//     echo $_FILES["fileToUpload"]["name"] . "was last modified: " . date("F d Y H:i:s.", filemtime($_FILES["fileToUpload"]["name"]));
//     echo strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

//     die;
// }
// echo $target_file;
// die;
if (!empty($_POST['submit'])) {
    print_r($_POST);
    die;

    if (!file_exists('uploads')) mkdir('uploads', 0777, true);
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        die;
        // if everything is ok, try to upload file
    } else {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }
}





?>
<!DOCTYPE html>
<html>

<body>

    <form action="test.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>

</body>

</html>