<!DOCTYPE html>
<?php session_start();
    if(!isset($_SESSION['userName'])){
        header('location:../login.html');
    }else{
        echo "<font id='Mname'>".$_SESSION['userName']."</font>";
        echo "<a id='logout' class='log'><font>LogOut</font></a>";
    }
?>
<html>
    <head>
        <title>FAMILY-MART</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/Main.css">
        <link rel="stylesheet" type="text/css" href="../css/fonts.css">
        <link rel="stylesheet" type="text/css" href="../css/log.css">
        <link rel="stylesheet" type="text/css" href="../css/DB.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <style>
            ::selection{background-color:rgba(207,74,92,0.15)}
            ::-moz-selection{background-color:rgba(207,74,92,0.15)}
            ::-webkit-selection{background-color:rgba(207,74,92,0.15)}
            .input{
                font-size: 15px;
                text-align: center;
                color: #EB7A77;
                font-family: i-medium;
            }
            .store{
                margin-top: -75px;
            }
        </style>
        <script>
            $(document).ready(function(){
                $('.tishi').css({"font-family":"i-medium","padding-left":"30px","font-size":"20px","color":"#EB7A77"});
                document.getElementById('tishiDelete').innerHTML = "可输入模糊店名进行查询";
            });
            var clickTime = 0;
            function Nav() { // 通过改变main左边内边距
                if(clickTime % 2 != 0){
                    document.getElementById("mySidenav").style.width = "80px";
                    document.getElementById("main").style.marginLeft = "80px";
                    document.getElementById("content").style.marginLeft = "80px";
                    document.getElementById("content").style.transition = "1.5s";
                    clickTime++;
                }else{
                    document.getElementById("mySidenav").style.width = "0px";
                    document.getElementById("main").style.marginLeft= "0px";
                    document.getElementById("content").style.marginLeft = "0px";
                    document.getElementById("content").style.transition = "1.5s";
                    clickTime++;
                }
            }
            
            //点击图标实现缓慢移动 1s
            $(document).ready(function(){
                $("#home").click(function(){
                    window.location.href = "../index.php#family";
                });
                $("#top").click(function(){
                    $("html,body").animate({scrollTop:$("#divDelete").offset().top},1000);
                });
                $("#add").click(function(){
                    window.location.href = "FamilyAdd.php";
                });
                $("#search").click(function(){
                    window.location.href = "FamilySearch.php";
                });
                $("#update").click(function(){
                    window.location.href = "FamilyUpdate.php";
                });
                $("#delete").click(function(){
                    $("html,body").animate({scrollTop:$("#divDelete").offset().top},1000);
                });
            });
            
            $(document).ready(function(){
                //登出
                $("#logout").click(function(){
                    window.location.href = "../logout.php";
                });
            });
            
            //按下enter键后执行查询操作
            $(document).keyup(function(event){ 
                if(event.keyCode == 13){ //按下enter键
                  $("#btnDelete").trigger("click"); 
                } 
            });
        </script>
        
<!--        delete-->
        <script>
//            模糊查询
            function deleteA(){
                document.getElementById('tishiDelete').innerHTML = "";
//                console.log(myAcc, myPw);
                /* 取得输入内容 */
                var delete_Fname = document.getElementById('delete_Fname').value;
                var deletes = {deleteFname: delete_Fname};
                var myUrl = "FamilyDB/FamilyDBDeleteInit.php";
                $.ajax({
                    url: myUrl,
                    type: 'POST',
                    data: deletes,
                    dataType: 'json',
                    async: true,
                    /* 函式中的 backData 參數：伺服器回傳的查詢結果 */
                    success: function (backData, jqXHR) {
                        if (backData == "") {
                            document.getElementById('tishiDelete').innerHTML = "找不到任何的資料!";
                        } else {
    //                            console.log(backData);
                                /* 將伺服器回傳的查詢結果顯示在指定的位置 */
    //                            document.getElementById('demoSEARCH').innerHTML = "新增一筆資料!";
                            showDelete(backData);
                        }
                    },
                    error: function (textStatus) {
                    /* 顯示錯誤訊息! */
    //                        console.log(textStatus);
                        document.getElementById('tishiDelete').innerHTML = "無法進行查詢！";
                    }
                });
            }
            function showDelete(inData){
                var str = '<font id="medium" style="color: #EB7A77">Choose one to delete</font>';
                str += '<br><br><table id="deletetable">';
                str += '<tr><td>店号</td><td>店名</td><td>地址</td><td>电话</td><td>删除</td></tr>';
                    for(var i = 0; i < inData.length; i++){
                        str += '<tr><td>' + inData[i].Fno + '</td>';
                        str += '<td>' + inData[i].Fname + '</td>';
                        str += '<td>' + inData[i].Flocation + '</td>';
                        str += '<td>' + inData[i].Fphone + '</td>';
                        str += "<td><input type='button' value='確定刪除' class='shanchuCSS' onclick='execDelete(" + inData[i]['Fno'] + ",this)' /></td></tr>";
                    }
                    str += '</table>';
                    document.getElementById("demoDelete").innerHTML = str;
            }
            
            function execDelete(fid,heihei){
                var deletes = {Fno: fid};
                var myUrl = "FamilyDB/FamilyDBDelete.php";
                $.ajax({
                    url: myUrl,
                    type: 'POST',
                    data: deletes,
                    async: true,
                    //dataType: 'json',
                    /* 函式中的 backData 參數：伺服器回傳的執行結果 */
                    success: function (backData, jqXHR) {
                        /* 若是後端 php 正常執行，顯示其回傳的值 backData */
//                        document.getElementById('tishiDelete').innerHTML = backData;
//                        deleteA();
                        var hehe = $(heihei).parent().parent();
                        $(hehe).remove();
                        document.getElementById('tishiDelete').innerHTML = "删除成功！";
                    },
                    /* 若是後端 php 在執行時出現錯誤 */
                    error: function (textStatus) {
                        document.getElementById('tishiDelete').innerHTML = "無法進行刪除！";
                    }
                });
            }
        </script>
        
    </head>
    <body>
        <div id="mySidenav" class="sidenav">
            <a id="home"><img src="../images/home.png" title="Home" class="mini"></a>
            <a><hr></a>
            <a id="add"><img src="../images/add.png" title="Add" class="mini"></a>
            <a id="search"><img src="../images/search.png" title="Search" class="mini" style="height: 45px;"></a>
            <a id="update"><img src="../images/update.png" title="Update" class="mini"></a>
            <a id="delete"><img src="../images/delete.png" title="Delete" class="mini"></a>
        </div>
        <div id="main">
<!--            <span style="font-size:30px;cursor:pointer;" onclick="Nav()">&#9776; <font style="font-size:15px;letter-spacing:10px;" id="menu">MENU</font></span>-->
            <span style="font-size:30px;cursor:pointer;" onclick="Nav()">&#9776; <img src="../images/FamilyMart.png" style="height: 25px;"></span>
        </div>
        <a id="top"><img src="../images/mountains10.png" title="backTop" style="width:40px"></a>
        <div id="content">
            <div id="divDelete" class="store">
                <div class="leftInput" style="font-size: 20px;width:40%;">
                    <font id="medium" style="color: #EB7A77">DELETE</font>
                    <table>
                        <tr>
                            <td>门市店名</td>
                            <td><input type="text" id="delete_Fname" placeholder="请输入门市店名" maxlength="6" class="input"></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input type="button" value="查询" onclick="deleteA()" id="btnDelete" class="btn"></td>
                        </tr>
                    </table>
                    <div class="tishi" id="tishiDelete"></div>
                </div>
                <div id="demoDelete" class="demo" style="width: 50%;"></div>
            </div>
        </div>
    </body>
</html>