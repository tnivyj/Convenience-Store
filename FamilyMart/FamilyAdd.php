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
                color: #00896C;
                font-family: i-medium;
            }
            .store{
                margin-top: -75px;
            }
        </style>
        
        <script>
            $(document).ready(function(){
                $('.tishi').css({"font-family":"i-medium","padding-left":"30px","font-size":"20px","color":"#00896C"});
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
                    $("html,body").animate({scrollTop:$("#divAdd").offset().top},1000);
                });
                $("#add").click(function(){
                    $("html,body").animate({scrollTop:$("#divAdd").offset().top},1000);
                });
                $("#search").click(function(){
                    window.location.href = "FamilySearch.php";
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
            
            //按下enter键后执行新增操作
            $(document).keyup(function(event){ 
                if(event.keyCode == 13){ //按下enter键
                  $("#btnAdd").trigger("click"); 
                } 
            });
        </script>
        
<!--        add-->
        <script>
            function checkadd(){
                document.getElementById('tishiAdd').value = "";
                var myFno = $('#add_Fno').val();
                var myFlocation = $('#add_Flocation').val();
                var myFphone = $('#add_Fphone').val();
                if(myFno == '' && myFlocation == ''){
                    $('#tishiAdd').text('请输入门市店号和门市地址!');
                }else if(myFno == ''){
                    $('#tishiAdd').text('请输入门市店号');
                }else if(myFlocation == ''){
                    $('#tishiAdd').text('请输入门市地址');
                }else if(myFphone != '' && myFphone.indexOf('-') != 2){
                    $('#tishiAdd').text('请输入正确格式的电话号码 EX:XX-XXXXXXX');
                }else if(myFphone != '' && myFphone.length != 10){
                    $('#tishiAdd').text('请输入正确长度的电话号码 EX:XX-XXXXXXX');
                }else if(myFno != '' && myFlocation != ''){
                    $('#tishiAdd').text('');
                    add();
                }
            }
            function add(){
                /* 取得输入内容 */
                var add_Fno = document.getElementById('add_Fno').value;
                var add_Fname = document.getElementById('add_Fname').value;
                var add_Flocation = document.getElementById('add_Flocation').value;
                var add_Fphone = document.getElementById('add_Fphone').value;
                var adds = {addFno: add_Fno, addFname: add_Fname, addFlocation: add_Flocation, addFphone: add_Fphone};
                var myUrl = "FamilyDB/FamilyDBAdd.php";
                $.ajax({
                    url: myUrl,
                    type: 'POST',
                    data: adds,
//                    dataType: 'json',
                    async: true,
                    /* 函式中的 backData 參數：伺服器回傳的查詢結果 */
                    success: function (backData, jqXHR) {
                        if (backData == "") {
                            document.getElementById('tishiAdd').innerHTML = "新增失败!";
                        } else {
//                            console.log(backData);
                            /* 將伺服器回傳的查詢結果顯示在指定的位置 */
                            document.getElementById('tishiAdd').innerHTML = backData;
                            if(backData == "新增成功。"){
                                showAdd();
//                                init(); //刷新下方修改表格
                            }
                        }
                    },
                    error: function (textStatus) {
                        /* 顯示錯誤訊息! */
//                        console.log(textStatus);
                        document.getElementById('tishiAdd').innerHTML = extStatus;
                    }
                });
                
                function showAdd(){
                    var str = '<font id="medium" style="color: #00896C">What you add</font>';
                    str += '<br><br><table id="addtable">';
                    str += '<tr><td>门市店号</td><td>' + add_Fno + '</td></tr>';
                    str += '<tr><td>门市店名</td><td>' + add_Fname + '</td></tr>';
                    str += '<tr><td>门市地址</td><td>' + add_Flocation + '</td></tr>';
                    str += '<tr><td>门市电话</td><td>' + add_Fphone + '</td></tr>';
                    str += '</table>';
//                    $("#demoAdd").append(str);
                    document.getElementById("demoAdd").innerHTML = str;
//                    清空输入内容
                    document.getElementById("add_Fno").value = "";
                    document.getElementById("add_Fname").value = "";
                    document.getElementById("add_Flocation").value = "";
                    document.getElementById("add_Fphone").value = "";
                }
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
            <div id="divAdd" class="store">
                <div class="leftInput" style="font-size: 20px;">
                    <font id="medium" style="color: #00896C">ADD</font>
                    <table>
                        <tr>
                            <td>门市店号</td>
                            <td><input type="text" id="add_Fno" placeholder="请输入门市店号" maxlength="6" class="input"></td>
                        </tr>
                        <tr>
                            <td>门市店名</td>
                            <td><input type="text" id="add_Fname" placeholder="请输入门市店名" maxlength="5" class="input"></td>
                        </tr>
                        <tr>
                            <td>门市地址</td>
                            <td><input id="add_Flocation" placeholder="请输入门市地址" maxlength="30" class="input"></td>
                        </tr>
                        <tr>
                            <td>门市电话</td>
                            <td><input type="text" id="add_Fphone" placeholder="ex:XX-XXXXXXX" maxlength="10" class="input"></td>
                        </tr>
                    </table>
                    <input type="button" value="新增" onclick="checkadd()" id="btnAdd" class="btn"><br><br>
                    <div class="tishi" id="tishiAdd"></div>
                </div>
                <div id="demoAdd" class="demo" style="font-size: 20px;"></div>
            </div>
        </div>
    </body>
</html>