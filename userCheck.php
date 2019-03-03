<?php session_start(); ?>
<?php
/* 確認是否有填寫必填的資料欄位 */
if (filter_has_var(INPUT_POST, 'phpAccount') && filter_has_var(INPUT_POST, 'phpPassword')) {
    /* 設定變數接收使用者輸入的資料 */
    $Mname = filter_input(INPUT_POST, 'phpAccount');
    $Mpassword = filter_input(INPUT_POST, 'phpPassword');
//    $Mname = filter_
    $db_host = 'localhost';          //資料庫主機
    $db_user = 'root';               //資料庫使用者
    $db_password = '';               //資料庫使用者密碼
    $db_name = 'ConvenientStore';          //資料庫名稱
    /* 建立資料庫的連結 */
    $link = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    if (!$link) {  //輸出資料庫連接錯誤
        die("連接失敗" . mysqli_connect_error());
    }
    /* 新增資料的 SQL 語法 */
    $sql = "SELECT * FROM Manager where Mname='$Mname';";
    $_SESSION['userName'] = $Mname;
    mysqli_set_charset($link, "utf8");      // 設定連接資料庫及執行SQL的編碼為 utf8
    $result = mysqli_query($link, $sql);    // 執行SQL語法
    if ($result) {
        if(mysqli_num_rows($result) == 1){
            /* 將所有的查詢結果轉換成「關聯型」陣列 */
            $queryData = mysqli_fetch_all($result, MYSQLI_ASSOC);
            /* 將「關聯型」陣列的查詢結果，輸出成 json 格式 */
            /* 接著，再藉由 echo 的輸出，傳送至前端 */
            echo json_encode($queryData);
            mysqli_free_result($result); //釋放查詢結果
        }else{
            echo "查无资料";
        }
    } else {   //輸出SQL語法錯誤
        echo "查询錯誤: " . mysqli_error($link); //輸出SQL語法錯誤
    }
}
?>

