<?php include_once "../base.php";
// 直接複製getlist
//把type改成id

// 剛剛它用get 的方式丟給了我一個type
$id=$_GET['id'];

$news=$News->find($id);

// 懶的話做到這裡就好了
echo  $news['text'];


//new line to br
// echo nl2br($news['text']);
