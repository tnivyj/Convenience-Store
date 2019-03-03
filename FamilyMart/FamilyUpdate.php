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
                color: #F7C242;
                font-family: i-medium;
            }
            .store{
                margin-top: -75px;
            }
        </style>
        <script>
            $(document).ready(function(){
                $('.tishi').css({"font-family":"i-medium","padding-left":"30px","font-size":"20px","color":"#F7C242","line-height":"20px"});
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
                    $("html,body").animate({scrollTop:$("#divUpdate").offset().top},1000);
                });
                $("#add").click(function(){
                    window.location.href = "FamilyAdd.php";
                });
                $("#search").click(function(){
                    window.location.href = "FamilySearch.php";
                });
                $("#update").click(function(){
                    $("html,body").animate({scrollTop:$("#divUpdate").offset().top},1000);
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
            
            //按下enter键后执行修改操作
            $(document).keyup(function(event){ 
                if(event.keyCode == 13){ //按下enter键
                  $("#btnUpdate").trigger("click"); 
                } 
            });
        </script>

<!--        update-->
        <script>
            function init(){
                var myUrl = "FamilyDB/FamilyDBUpdateInit.php";
                $.ajax({
                    url: myUrl,
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    /* 函式中的 backData 參數：伺服器回傳的查詢結果 */
                    success: function (backData, jqXHR) {
                        if (backData == "") {
                            document.getElementById('tishiUpdate').innerHTML = "找不到要修改的资料!";
                        } else {
                            console.log(backData);
                            /* 將伺服器回傳的查詢結果顯示在指定的位置 */
//                            document.getElementById('demoSEARCH').innerHTML = "新增一筆資料!";
                            showUpdate(backData);
                        }
                    },
                    error: function (textStatus) {
                        /* 顯示錯誤訊息! */
                        console.log(textStatus);
                        //console.log(" error!");
                        document.getElementById('tishiUpdate').innerHTML = "无法进行修改！";
                    }
                });
            }
            function showUpdate(allData){
                var str = '<font id="medium" style="color: #F7C242">Choose one to update</font>';
                str += '<br><br><table id="updatetable">';
                str += '<tr><td>店号</td><td>店名</td><td>地址</td><td>电话</td><td>修改</td></tr>';
                for(var i = 0; i < allData.length; i++){
                    str += '<tr><td>' + allData[i].Fno + '</td>';
                    str += '<td>' + allData[i].Fname + '</td>';
                    str += '<td>' + allData[i].Flocation + '</td>';
                    str += '<td>' + allData[i].Fphone + '</td>';
                    var one = JSON.stringify(allData[i]);
                    str += "<td><input type='button' value='修改' class='xiugaiCSS' onclick='takeOne(" + one + ")' /></td></tr>";
                }
                str += '</table>';
                document.getElementById('demoUpdate').innerHTML = str;
            }
            function takeOne(oneData){
                document.getElementById('update_Fno').value = oneData.Fno;
                document.getElementById('update_Fname').value = oneData.Fname;
                document.getElementById('update_Flocation').value = oneData.Flocation;
                document.getElementById('update_Fphone').value = oneData.Fphone;
            }
            function checkupdate(){
                var myFno = $('#update_Fno').val();
                var myFlocation = $('#update_Flocation').val();
                var myFphone = $('#update_Fphone').val();
                if(myFno == ''){
                    $('#tishiUpdate').text('请选择要更新的门市!');
                }else if(myFlocation == ''){
                    $('#tishiUpdate').text('请输入门市地址!');
                }else if(myFphone != '' && myFphone.indexOf('-') != 2){
                    $('#tishiUpdate').text('请输入正确格式的电话号码 EX:XX-XXXXXXX'); 
                }else if(myFphone != '' && myFphone.length != 10){
                    $('#tishiAdd').text('请输入正确长度的电话号码 EX:XX-XXXXXXX');
                }else{
                    $('#tishiUpdate').text('');
                    update();
                }
            }
//            正式进行更新作业
            function update(){
                var myFno = document.getElementById('update_Fno').value;
                var myFname = document.getElementById('update_Fname').value;
                var myFlocation = document.getElementById('update_Flocation').value;
                var myFphone = document.getElementById('update_Fphone').value;
                var updates = {Fno: myFno, Fname: myFname, Flocation: myFlocation, Fphone: myFphone};
                var myUrl = "FamilyDB/FamilyDBUpdate.php";
                $.ajax({
                    url: myUrl,
                    type: 'POST',
                    data: updates,
                    async: true,
//                    dataType: 'json',
                    /* 函式中的 backData 參數：伺服器回傳的查詢結果 */
                    success: function (backData, jqXHR) {   /* 後端 php 正常執行 */
                        document.getElementById('tishiUpdate').innerHTML = backData;
                        /* 呼叫 init() 函式，重新讀取 database 最新資料，並更新網頁畫面 */
                        init();
                    },
                    error: function (textStatus) {          /* 後端 php 執行失敗 */
                        document.getElementById('tishiUpdate').innerHTML = "无法进行修改！";
                    }
                });
            }
        </script>

    </head>
    <body onload="init()">
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
            <div id="divUpdate" class="store">
                <div id="demoUpdate" class="demo" style="width:50%;float:left;"></div>
                <div class="leftInput" style="font-size:20px;width:40%;float:right;">
                    <font id="medium" style="color: #F7C242">UPDATE</font>
                    <table>
                        <tr>
                            <td>门市店号</td>
                            <td><input type="text" id="update_Fno" placeholder="请输入门市店号" maxlength="6" class="input" disabled></td>
                        </tr>
                        <tr>
                            <td>门市店名</td>
                            <td><input type="text" id="update_Fname" placeholder="请输入门市店名" maxlength="5" class="input"></td>
                        </tr>
                        <tr>
                            <td>门市地址</td>
                            <td><input id="update_Flocation" placeholder="请输入门市地址" maxlength="30" class="input"></td>
                        </tr>
                        <tr>
                            <td>门市电话</td>
                            <td><input type="text" id="update_Fphone" placeholder="ex:XX-XXXXXXX" maxlength="10" class="input"></td>
                        </tr>
                    </table>
                    <input type="button" value="修改" onclick="checkupdate()" id="btnUpdate" class="btn"><br><br>
                    <div class="tishi" id="tishiUpdate"></div>
                </div>
            </div>
        </div>
    </body>
</html>