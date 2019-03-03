<?php
/* 判斷使用者是否有輸入 wno 的資料 */
if (filter_has_var(INPUT_POST, 'Sno')) {
    /* 取得從前端傳來的 wno 變數的資料 */
    $Sno = filter_input(INPUT_POST, "Sno");
    /* 設定網頁內容顯示時的編碼，以避免中文亂碼 */
    header("Content-Type:text/html; charset=utf-8");
    $db_host = 'localhost';     //資料庫主機
    $db_user = 'root';          //資料庫使用者
    $db_password = '';          //資料庫使用者密碼
    $db_name = 'ConvenientStore';      //資料庫名稱
    /* 資料庫連接 */
    $link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    /* 以 utf8 編碼，避免中文亂碼 */
    mysqli_set_charset($link, "utf8");
    /* 檢查資料庫連接是否失敗 */
    if (!$link) {
        die("连接失败" . mysqli_connect_error()); //輸出資料庫連接錯誤
    }
    /* 定義 SQL 刪除語法 */
    $deleteStr = "delete from SevenEleven where Sno='$Sno'";
    /* 實際執行刪除語法 */
    $result = mysqli_query($link, $deleteStr);
    /* 檢查是否能正常執行 */
    if ($result) {
        echo "删除成功！";
    } else {
        echo "删除失败: " . mysqli_error($link); //輸出SQL語法錯誤
    }
    mysqli_close($link); //關閉資料庫連接
}
?>
