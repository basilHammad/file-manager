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
$txt1 = "Learn PHP";
$txt2 = "basil ahmad hammad";
$x = '7.656565';
$y;

define('names', ['basil', 'omar', 'yazeed']);

function test()
{
    print_r(names);
};


// $arr = ['name' => 'basil', 'age' => 20, 'lastn' => 'hammad'];
// echo $arr->name;
// $arr['name'] = 'omar';
// echo $arr['name'];

$cars = [['bmw', 'ss', 'asdas'], ['mrecides', '30', 'asda']];
// echo $cars[0][0] . ' ' . $cars[1][0];

for ($i = 0; $i < count($cars); $i++) {
    for ($j = 0; $j < count($cars[$i]); $j++) {
        echo $cars[$i][$j] . '<br>';
    }
}


// foreach ($arr as $key => $value) {
//     echo $key  . '<br>';
// }
