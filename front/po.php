<div>目前位置:首頁 > 分類網誌 > <span id="navTag"></span></div>
<div style="display:flex" ;>
    <!-- 複製home.php -->
    <!-- 改成fieldset 加legend ,改成p-->
    <fieldset style="width: 20%;">
        <legend>分類項目</legend>
        <a><p>健康新知</p></a>
        <a><p>菸害防制</p></a>
        <a><p>癌症防治</p></a>
        <a><p>慢性病防治</p></a>
    </fieldset>
    <!-- 從上面再複製一組 
    改文章列表 刪掉多的 後在外面加div-->
    <fieldset style="width: 70%;">
        <legend>文章列表</legend>
    </fieldset>
</div>

<script>
    // 當我畫面上的這個tag被點的時候
    $("#tag").on('click',function(){
        // 就告訴他我的文字let,拿到它之後
        let navtag=$(this).text()
        //把它放到我的畫面上的navTag裡面去
        //text(這邊放html也可以)
        $("#navTag").text(navTag)

    })
</script>