<?php
/* 此程式用來取得要作為起始點和到達點的位置資訊 */
$db_host = 'localhost';         //資料庫主機
$db_user = 'root';              //資料庫使用者
$db_password = '';              //資料庫使用者密碼
$db_name = 'ConvenientStore';         //資料庫名稱
//資料庫連接
$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$link) {
    die("連接失敗" . mysqli_connect_error()); //輸出資料庫連接錯誤
}
$queryData = null;

/* 設定 SQL 語法，此處取出 name 和 address 兩個欄位的資料 */
$sql = "SELECT Sname, Slocation FROM SevenEleven UNION SELECT Fname, Flocation FROM FamilyMart";
mysqli_set_charset($link, "utf8");      //設定查詢結果為utf8
$result = mysqli_query($link, $sql);    //執行sql語法
if ($result) {  // 檢查是否有正確執行 sql 查詢 
    if (mysqli_num_rows($result) > 0) {     // 檢查是否有查詢到至少一筆資料
        /* 將所有的查詢結果轉換成「關聯型」陣列 */
        $queryData = mysqli_fetch_all($result, MYSQLI_ASSOC);
        /* 「json_encode()」：此函數會將參數的值轉換成 json 格式回傳  */
        /* 此處是將「關聯型」陣列的查詢結果，輸出成 json 格式 */
        /* 接著，再藉由 echo 的輸出，傳送至前端 */
        echo json_encode($queryData);
        mysqli_free_result($result); //釋放查詢結果的記憶體
    } else {
        echo "沒有資料。";
    }
} else {
    echo "查詢錯誤: " . mysqli_error($link); //輸出SQL語法錯誤
}
mysqli_close($link); //關閉資料庫連接
?>