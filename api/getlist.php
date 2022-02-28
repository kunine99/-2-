<?php include_once "../base.php";

// 剛剛它用get 的方式丟給了我一個type
$type=$_GET['type'];

//然後文章內容就是news去連資料庫
//全部的文章裡面,把'type'=>$type的文章通通顯示出來
$news=$News->all(['type'=>$type]);

foreach ($news as $key => $value) {
    //只有a標籤會連在一起,所以加個p標籤分開
    // #字號表示不會有內容
    //onclick的時候我想要它幫我去執行一個程式
    //執行時這個城市會去幫我getnews 它會去幫我抓我對應的文章
    //幫我找這邊文章的id,寫完後去po.php加function
    echo "<p><a href='#' onclick='getnews({$value['id']})'>";
    // 這邊顯示我的title
    echo $value['title'];
    echo "</a></p>";
}
//寫完後回到po.php

