<?php

date_default_timezone_set("Asia/Taipei");
session_start();

class DB
{
    // 題組二第一次練習
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=web_21";
    protected $user = 'root';
    protected $pw = '';
    protected $pdo;
    protected $table;

    //建立建構式，在建構時帶入table名稱會建立資料庫的連線
    public function __construct($table)
    {
        $this->table = $table;
        $this->pdo = new PDO($this->dsn, $this->user, $this->pw);
    }
    //此方法可能會有不帶參數，一個參數及二個參數的用法，因此使用不定參數的方式來宣告
    public function all(...$arg)
    {
        //在class中要引用內部的成員使用$this->成員名稱或方法
        //當參數數量不為1或2時，那麼此方法就只會執行選取全部資料這一句SQL語法
        $sql = "SELECT * FROM $this->table ";
        //依參數數量來決定進行的動作因此使用switch...case
        switch (count($arg)) {
            case 1:
                //第一個參數必須為陣列，使用迴圈來建立條件語句的陣列
                foreach ($arg[0] as $key => $value) {
                    $tmp[] = "`$key`='$value'";
                }
                //將條件語句的陣列使用implode()來轉成字串，最後再接上第二個參數(必須為字串)
                $sql .= " WHERE " . implode(" AND ", $tmp) . " " . $arg[1];
                break;
            case 2:
                //判斷參數是否為陣列
                if (is_array($arg[0])) {
                    //使用迴圈來建立條件語句的字串型式，並暫存在陣列中
                    foreach ($arg[0] as $key => $value) {
                        $tmp[] = "`$key`='$value'";
                    }
                    //使用implode()來轉換陣列為字串並和原本的$sql字串再結合
                    $sql .= " WHERE " . implode(" AND ", $tmp);
                } else {
                    //如果參數不是陣列，那應該是SQL語句字串，因此直接接在原本的$sql字串之後即可
                    $sql .= $arg[0];
                }
                break;
                //執行連線資料庫查詢並回傳sql語句執行的結果
        }
        //fetchAll()加上常數參數FETCH_ASSOC是為了讓取回的資料陣列中只有欄位名稱
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function math($math, $col, ...$arg)
    {
        // 複製all *改成$math($col)
        //return的fetchall改成fetchColumn()
        $sql = "SELECT $math($col) FROM $this->table ";
        switch (count($arg)) {
            case 1:
                //第一個參數必須為陣列，使用迴圈來建立條件語句的陣列
                foreach ($arg[0] as $key => $value) {
                    $tmp[] = "`$key`='$value'";
                }
                //將條件語句的陣列使用implode()來轉成字串，最後再接上第二個參數(必須為字串)
                $sql .= " WHERE " . implode(" AND ", $tmp) . " " . $arg[1];
                break;
            case 2:
                //判斷參數是否為陣列
                if (is_array($arg[0])) {
                    //使用迴圈來建立條件語句的字串型式，並暫存在陣列中
                    foreach ($arg[0] as $key => $value) {
                        $tmp[] = "`$key`='$value'";
                    }
                    //使用implode()來轉換陣列為字串並和原本的$sql字串再結合
                    $sql .= " WHERE " . implode(" AND ", $tmp);
                } else {
                    //如果參數不是陣列，那應該是SQL語句字串，因此直接接在原本的$sql字串之後即可
                    $sql .= $arg[0];
                }
                break;
                //執行連線資料庫查詢並回傳sql語句執行的結果
        }
        //fetchColumn()只會取回的指定欄位資料預設是查詢結果的第1欄位的值
        return $this->pdo->query($sql)->fetchColumn();
    }

    public function save($array)
    {
        //判斷資料陣列中是否有帶有 'id' 這個欄位，有則表示為既有資料的更新
        //沒有 'id' 這個欄位則表示為新增的資料
        if (isset($array['id'])) {
            //update
            foreach($array as $key =>$value){
                $tmp[]="`$key`='$value'";
            }
            //建立更新資料(update)的sql語法
            $sql="update $this->table set ".implode(',',$tmp)." WHERE `id`='{$array['id']}'"; 
        } else {
            //insert
            $sql="insert into $this->table (`".implode("`,`",array_keys($array))."`)values('".implode("`,`",$array)."')";

            //建立新增資料(insert)的sql語法
            /* 覺得一行式寫法太複雜可以利用變數把語法拆成多行再組合
             * $cols=implode("`,`",array_keys($array));
             * $values=implode("','",$array);
             * $sql="INSERT INTO $table (`$cols`) VALUES('$values')";        
             */
        }
        
        //echo $sql;
        return $this->pdo->exec($sql);
    }

    public function find($id)
    {
        //複製 all的sql語句,句尾多了where
        $sql = "SELECT * FROM $this->table WHERE ";

        //複製 all的is_array那部分
        //將arg[0]改成id
        //刪除where
        //else部分的要改成`id`='$id'
        if (is_array($id)) {
            foreach ($id as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            $sql .= implode(" AND ", $tmp);
        } else {
            $sql .= "`id`='$id'";
        }
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public function del($id)
    {
        // 從id複製來的
        //select * 要改成delete
        //return要改成exec($sql)
        $sql = "DELETE  FROM $this->table WHERE ";

        if (is_array($id)) {
            foreach ($id as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            $sql .= implode(" AND ", $tmp);
        } else {
            $sql .= "`id`='$id'";
        }
        return $this->pdo->exec($sql);
    }


    public function q($sql)
    {
        // 從all 複製來的
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}



function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

//此函式會獨立在 DB 這個類別外，但是會和共用檔放在一起，然後include到所有的頁面去使用
//主要目的是簡化header指令的語法，避免拚字錯誤之類的事發生。
function to($url)
{
    header("location:" . $url);
}


//建議使用首字母大寫來代表這是資料表的變數，方便和全小寫的變數做出區隔

//etc......