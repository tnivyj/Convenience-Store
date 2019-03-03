<!DOCTYPE html>
<?php session_start();
    if(isset($_SESSION['userName'])){
        echo "<font id='Mname'>".$_SESSION['userName']."</font>";
        echo "<a id='logout' class='log'><font id='haha'>LogOut</font></a>";
    }else{
        echo "<font id='Mname'></font>";
        echo "<a id='login' class='log'><font id='haha'>LogIn</font></a>";
    }
?>
<html>
    <head>
        <title>Map Search</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/Main.css">
        <link rel="stylesheet" type="text/css" href="css/fonts.css">
        <link rel="stylesheet" type="text/css" href="css/log.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <style>
            ::selection{background-color:rgba(207,74,92,0.15)}
            ::-moz-selection{background-color:rgba(207,74,92,0.15)}
            ::-webkit-selection{background-color:rgba(207,74,92,0.15)}
            #backindex{
                position: fixed;
                right: 20px;
                top: 20px;
                cursor:pointer;
                z-index: 1;
            }
            .store{
                width: 100%;
                height: 600px;
                margin-right:0px;
            }
            #chart{
                padding-top: 5px;
                margin-top:70px;
                height:630px;
            }
            #chaxundizhi{
                text-align: center;
            }
            .sidenav a{
                padding-left: 20px;
                margin: 0 0 100px 0;
            }
            #selectLocation{
                width: 130px;
                height: 30px;
            }
        </style>
        <script>
            $(document).ready(function(){
                var clickTime = 0;
                $("#nav").click(function(){
                    if(clickTime % 2 == 0){
                        document.getElementById("mySidenav").style.width = "80px";
                        document.getElementById("main").style.marginLeft= "80px";
                        document.getElementById("content").style.marginLeft = "80px";
                        document.getElementById("content").style.transition = "1.5s";
                        clickTime++;
                    }else{
                        document.getElementById("mySidenav").style.width = "0px";
                        document.getElementById("main").style.marginLeft = "0px";
                        document.getElementById("content").style.marginLeft = "0px";
                        document.getElementById("content").style.transition = "1.5s";
                        clickTime++;
                    }
                });
            });
            
            $(document).ready(function(){
                //点击前往登陆画面
                $("#login").click(function(){
                    window.location.href = "login.html";
                });
                //登出
                $("#logout").click(function(){
                    window.location.href = "logout.php";
                });
                
                var log = document.getElementById("haha").innerText;
                if(log == "LogIn"){
                    $(".hide").hide();
                }else if(log == "LogOut"){
                    $(".hide").show();
                }
            });

            //点击图标实现缓慢移动 1s
            $(document).ready(function(){
//                $("#top").click(function(){
//                    $("html,body").animate({scrollTop:$("#selectLocation").offset().top},1000);
//                });
                $("#backindex").click(function(){
                    window.location.href = "index.php";
                });
                $("#signSeven").click(function(){
                    window.location.href = "index.php#seven";
                });
                $("#signFamily").click(function(){
                    window.location.href = "index.php#family";
                });
                $("#signChart").click(function(){
                    window.location.href = "locationSearch.php";
                });
            });
        </script>
    </head>
    <body onload="init()">
        <div id="mySidenav" class="sidenav">
            <a id="signSeven"><img src="images/mini-711.png" alt="mini-711" class="mini"></a>
            <a id="signFamily"><img src="images/mini-familymart.png" alt="mini-familymart" class="mini"></a>
            <a id="signChart"><img src="images/Fullmap.png" alt="GoogleChart" class="mini"></a>
        </div>
        <div id="main">
            <span style="font-size:30px;cursor:pointer;" id="nav">&#9776; <font style="font-size:15px;letter-spacing:10px;" id="menu">MENU</font></span>
        </div>
<!--        <font id="Mname"></font>-->
<!--        用户名-->
<!--        <a id="login"><font>LogIn</font></a>-->
<!--        登陆/登出按钮-->
<!--        <a id="top"><img src="images/mountains10.png" title="backTop" style="width:40px"></a>-->
        <a id="backindex"><img src="images/home.png" title="backIndex" style="width:40px"></a>
        <div id="content">
            <div id="chart" class="store">
                <div id="chaxundizhi">
                    请选择要查询的超商店名: 
                    <select id="selectLocation">
                        <option selected="selected">请选择超商...</option>
                    </select>
                </div><hr>
                <div id="map" class="store"></div>
            </div>
        </div>
        
        <script>
            var Location;
            function init() {
                var myUrl = "selectDB.php";
                $.ajax({
                    url: myUrl,
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    /* 函式中的 backData 參數：伺服器回傳的查詢結果 */
                    success: function (backData, jqXHR) {
                        if (backData == "null") {
                            alert("沒有任何位置資料!");
                        } else {
                            //console.log(backData);
                            /* 將伺服器回傳的查詢結果傳給 addLocationOption()函式，以便增加路線規劃的選項 */
                            addLocationOption(backData);
                        }
                    },
                    error: function (textStatus) {
                        console.log(" error!");
                    }
                });
            }


            function addLocationOption(inData) {
                console.log(inData);

                var myLocation = document.getElementById('selectLocation');
                /* 取得「到達點」下拉式選單的元素 */
                for (var i = 0; i < inData.length; i++) {
                    /* 取出陣列中的位置資訊，加入作為「起始點」的選項之一 */
                    var Loc = new Option(inData[i].Sname, inData[i].Slocation);
                    /* 將新選項加入「起始點」的下拉式選單中 */
                    myLocation.options.add(Loc);
                    // console.log(startLoc);
                }
            }
            /* 此函式初始化 google map，同時載入 google chart API */
            function initMap() {
                /* 建立一個可用來計算 2 至多個位置的路徑服務物件 */
                var directionsService = new google.maps.DirectionsService;
                /* 建立一個用來呈現 or 描繪從路徑服務所獲得路徑的物件 */
                var directionsDisplay = new google.maps.DirectionsRenderer;
                /* 初始化網頁一執行時的地圖 */
                /* 此處的中心點為「長榮大學」的經緯度 */
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: {lat: 22.906853, lng: 120.273351}
                });
                /* 設定用來呈現地圖路徑的物件 */
                directionsDisplay.setMap(map);
                /* 定義事件處理函式，以便給下拉式選單改變選項時呼叫 */
                var onChangeHandler = function () {
                    calculateAndDisplayRoute(directionsService, directionsDisplay);
                };
                /* 增加「起始點」下拉式選單(start)改變選項時的事件處理函式 */
                document.getElementById('selectLocation').addEventListener('change', onChangeHandler);
                /* 新增一個小視窗，如果接收到位置就顯示我在這，否則顯示你沒開定位 */
//                var infoWindow = new google.maps.InfoWindow({map: map});
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var location = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        Location = location;
                        var marker = new google.maps.Marker({map: map,position: Location,title: '当前位置',animation: google.maps.Animation.DROP});
                        map.setCenter(Location);
                    }, function () {
                        handleLocationError(true, infoWindow, map.getCenter());
                    });
                } else {
                    // 你沒開定位
                    handleLocationError(false, infoWindow, map.getCenter());
                }
            }
            function handleLocationError(browserHasGeolocation, infoWindow, position) {
                infoWindow.setPosition(position);
                infoWindow.setContent(browserHasGeolocation ?
                        'Error: 未开启定位.' :
                        'Error: 你的浏览器不支持定位功能.');
                infoWindow.open(map);
            }
            /* 定義一個函式，用來計算兩點間的路徑，並且顯示路徑 */
            /* 傳入此函式的兩個參數，分別是計算路徑的物件，以及顯示路徑的物件 */
            function calculateAndDisplayRoute(directionsService, directionsDisplay) {
                /* 計算路徑的 directionsService 物件，其 route() 共需兩個參數 */
                /* 第一個參數：要用來計算路徑服務的查詢請求 */
                /* 此參數是一個 DirectionsRequest 物件，它具有多個特性 */
                /* 此處使用到的特性為：origin 是起點，destination 是終點 */
                /* travelMode 是前進模式，例如 開車、步行、騎單車、公共運輸 */
                /* 第二個參數：計算路徑後所要回呼執行的函式 */

                directionsService.route({
                    origin: Location,
                    destination: document.getElementById('selectLocation').value,
                    travelMode: google.maps.TravelMode.DRIVING

                            /* 回呼的函式有二個參數，第一個參數 response 將接收到所計算出來的路徑 */
                            /* 第二個參數則是計算路徑服務的執行狀態 */
                }, function (response, status) {     /* 當它是 OK 時，代表正常執行 */
                    if (status === google.maps.DirectionsStatus.OK) {
                        /* 描繪路徑的 directionsDisplay 物件 */
                        /* 此物件呼叫 setDirections() 方法來呈現路徑在畫面中 */
                        directionsDisplay.setDirections(response);
                    } else {    /* 若計算路徑的服務無法正常執行，則顯示錯誤訊息 */
                        window.alert('Directions request failed due to ' + status);
                    }
                });
            }
        </script>
        <!-- 底下 https 中，在 key 後方一直到符號 & 之間的金鑰 -->
        <!-- 必須換成自己申請的 key 值，以避免無法正常運作 -->
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCW7BiAmAM-n5G3UnbRGj2pfKJRmn9NQ-o&callback=initMap">
        </script>
    </body>
</html>