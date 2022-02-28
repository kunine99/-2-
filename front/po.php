<div>目前位置:首頁 > 分類網誌 > <span id="navTag">健康新知</span></div>
<div style="display:flex" ;>
    <!-- 複製home.php -->
    <!-- 改成fieldset 加legend ,改成p-->
    <fieldset style="width: 20%;">
        <legend>分類項目</legend>
        <a><p class="tag" data-type="1">健康新知</p></a>
        <a><p class="tag" data-type="2">菸害防制</p></a>
        <a><p class="tag" data-type="3">癌症防治</p></a>
        <a><p class="tag" data-type="4">慢性病防治</p></a>
    </fieldset>
    <!-- 從上面再複製一組 
    改文章列表 刪掉多的 後在外面加div-->
    <fieldset style="width: 70%;">
        <legend>文章列表</legend>
        <div id="newslist"></div>
        <div id="news" style="display: none;"></div>
    </fieldset>
</div>

<script>
    // 我要他一開始就執行,指定第一個類別
    getlist(1)

    // 當我畫面上的這個tag被點的時候
    $(".tag").on('click',function(){
        // 就告訴他我的文字let,拿到它之後
        let navtag=$(this).text()
        //把它放到我的畫面上的navTag裡面去
        //text(這邊放html也可以)
        $("#navTag").text(navtag)
        // 寫到這邊去後台資料庫news加資料
        let type=$(this).data('type')
        //為了我們點擊後顯示的文章會更改
        //所以這邊塞一個api程式,我會把我的type傳給你,你要回傳list給我
        // $.get("api/getlist.php",{type:$(this).data('type')},(list)=>{
        // $.get("api/getlist.php",{type},(list)=>{
            // 拿到list後我直接把東西放到我的文章列表裡面去
            //此時在上面新增一個div id是newslist
            //我要在這個newslist的地方把你給我的list放進去
            //因為我們放的是有含標籤的東西,所以是html
            //告訴他請你把我的list放進去
            // $("#newslist").html(list)
           
            //接下來在上面放data-type
            //然後將type修改成我點擊的當下的這個東西的data type去送到後台
            //或是直接設一個let type
        // })

        // 原本的事件這邊要多一行,當你點擊這個事件的時候
        //就getlist然後把type帶進去
        getlist(type)
        // 也就是說在這個ajax事件中,onclick點擊後他會把文字改掉同時把type放進去

    })

    //顯示完文字後,就要來拿文章內容
    //剪下上面的$.get("api/getlist.php",{type},(list)=>{
    // 跟$("#newslist").html(list) 在建立一個function,塞進去複製的東西

    // 這個getlist會吃一個參數type,哪一個類別文章的type,就做不一樣的事情
    function getlist(type){
         $.get("api/getlist.php",{type},(list)=>{
            $("#newslist").html(list)
            $("#newslist").show()
            $("#news").hide()

        })
    }
   
    // 複製上面的,裡面要改成放文章的id
    function getnews(id){
        //回來的東西會是我的news,上面要加一個id=news
         $.get("api/getnews.php",{id},(news)=>{
            $("#news").html(news)
            $("#news").show()
            $("#newslist").hide()
        })
    }
</script>