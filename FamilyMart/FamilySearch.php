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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            ::selection{background-color:rgba(207,74,92,0.15)}
            ::-moz-selection{background-color:rgba(207,74,92,0.15)}
            ::-webkit-selection{background-color:rgba(207,74,92,0.15)}
            .input{
                font-size: 15px;
                text-align: center;
                color: #0089A7;
                font-family: i-medium;
            }
            .store{
                margin-top: -75px;
            }
        </style>
        <script>
            $(document).ready(function(){
                $('.tishi').css({"font-family":"i-medium","padding-left":"30px","font-size":"20px","color":"#0089A7"});
                document.getElementById('tishiSearch').innerHTML = "可输入模糊店名进行查询";
//                可输入模糊店名进行查询
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
                    $("html,body").animate({scrollTop:$("#divSearch").offset().top},1000);
                });
                $("#add").click(function(){
                    window.location.href = "FamilyAdd.php";
                });
                $("#search").click(function(){
                    $("html,body").animate({scrollTop:$("#divSearch").offset().top},1000);
                });
                $("#update").click(function(){
                    window.location.href = "FamilyUpdate.php";
                });
                $("#delete").click(function(){
                    window.location.href = "FamilyDelete.php";
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
                  $("#btnSearch").trigger("click"); 
                } 
            });
        </script>

<!--        search-->
        <script>
            function search(){
                /* 取得输入内容 */
                var search_Fname = document.getElementById('search_Fname').value;
                var searchs = {searchFname: search_Fname};
                var myUrl = "FamilyDB/FamilyDBSearch.php";
                $.ajax({
                    url: myUrl,
                    type: 'POST',
                    data: searchs,
                    dataType: 'json',
                    async: true,
                    /* 函式中的 backData 參數：伺服器回傳的查詢結果 */
                    success: function (backData, jqXHR) {
                        if (backData == "") {
                            document.getElementById('tishiSearch').innerHTML = "查无资料!";
                        } else {
//                            console.log(backData);
                            /* 將伺服器回傳的查詢結果顯示在指定的位置 */
//                            document.getElementById('tishiSearch').innerHTML = "backData";
                            showSearch(backData);
                        }
                    },
                    error: function (textStatus) {
                        /* 顯示錯誤訊息! */
//                        console.log(textStatus);
                        document.getElementById('tishiSearch').innerHTML = "查无资料！";
                    }
                });
            }
            function showSearch(allData){
                document.getElementById('tishiSearch').innerHTML = "";
                var str = '<font id="medium" style="color: #0089A7">What you search</font>';
                str += '<br><br><table id="searchtable">';
                str += '<tr><td>店号</td><td>店名</td><td>地址</td><td>电话</td></tr>';
                for(var i = 0; i < allData.length; i++){
                    str += '<tr><td>' + allData[i].Fno + '</td>';
                    str += '<td>' + allData[i].Fname + '</td>';
                    str += '<td>' + allData[i].Flocation + '</td>';
                    str += '<td>' + allData[i].Fphone + '</td></tr>';
                }
                str += '</table>';
                document.getElementById("demoSearch").innerHTML = str;
                }
        </script>

    </head>
    <body>
        <div id="mySidenav" class="sidenav">
            <a id="home"><img src="../images/home.png" title="Home" class="mini"></a>
            <a><hr></a>
            <a id="add"><img src="../images/add.png" title="Add" class="mini"></a>
            <a id="search"><img src="../images/search.png" title="Search" class="mini"></a>
            <a id="update"><img src="../images/update.png" title="Update" class="mini"></a>
            <a id="delete"><img src="../images/delete.png" title="Delete" class="mini"></a>
        </div>
        <div id="main">
<!--            <span style="font-size:30px;cursor:pointer;" onclick="Nav()">&#9776; <font style="font-size:15px;letter-spacing:10px;" id="menu">MENU</font></span>-->
            <span style="font-size:30px;cursor:pointer;" onclick="Nav()">&#9776; <img src="../images/FamilyMart.png" style="height: 25px;"></span>
        </div>
        <a id="top"><img src="../images/mountains10.png" title="backTop" style="width:40px"></a>
        <div id="content">
            <div id="divSearch" class="store">
                <div class="leftInput" style="font-size:20px; width:40%;">
                    <font id="medium" style="color: #0089A7">SEARCH</font>
                    <table>
                        <tr>
                            <td>门市店名</td>
                            <td><input type="text" id="search_Fname" placeholder="请输入门市店名" maxlength="5" class="input"></td>
                        </tr>
                    </table>
                    <input type="button" value="查询" onclick="search()" id="btnSearch" class="btn">
                    <div class="tishi" id="tishiSearch"></div>
                </div>
                <div id="demoSearch" class="demo" style="width: 50%;"></div>
            </div>
            
        </div>
    </body>
</html>