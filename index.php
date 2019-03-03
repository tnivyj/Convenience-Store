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
        <title>CONVENIENT STORE</title>
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
            .store{
                width: 100%;
                height: 730px;
                margin-right:0px;
            }
            #map{
                height: 650px;
                top: 70px;
            }
            /*看大小 测试用*/
            #googlemap{
/*                border: solid blue;*/
                margin-top: -70px;
            }
            #seven{
/*                border: solid red;*/
            }
            #family{
/*                border: solid yellow;*/
                background-color: rgba(244, 244, 244, 1);
            }
            #chart{
/*                border: solid green;*/
                padding-top: 5px; 
            }
            .right{
                float: right;
            }
            .mid,.left{
                float: left;
            }
            .leftdetail{
/*                border: solid pink;*/
                text-align: center;
                width: 5%;
                padding: 30px 0px 20px 20px;
                margin: 20px;
                margin-top: 140px;
            }
            .middetail{
/*                border: solid pink;*/
                text-align: center;
                width: 55%;
                height: 550px;
                margin-top: 100px;
            }
            .rightdetail{
/*                border: solid pink;*/
                text-align: center;
                width: 30%;
                height: 550px;
                margin: 20px;
                margin-top: 100px;
                padding-bottom:20px;
            }
            .homemini{
                width:50px;
                padding-top: 20px;
                padding-bottom: 20px;
            }
            #sevenChart,#familyChart{
                height: 550px;
                overflow-x: auto;
                overflow-y: hidden;
            }
            #Mapchart{
                width: 60%;
                height: 70%;
            }
        </style>
        <script>
            $(document).ready(function(){
                var clickTime = 0;
                $("#nav").click(function(){
                    if(clickTime % 2 == 0){
                        document.getElementById("mySidenav").style.width = "250px";
                        document.getElementById("main").style.marginLeft = "250px";
                        document.getElementById("content").style.marginLeft = "250px";
                        document.getElementById("content").style.transition = "1.5s";
                        clickTime++;
                        var myIcon = document.getElementsByClassName("icon");
                        for(var i = 0; i < myIcon.length; i++){
                            myIcon[i].style.paddingLeft = "0px";
                            myIcon[i].style.transition = "1.5s";
                        }
                    }else{
                        $("#mini").show();
                        document.getElementById("mySidenav").style.width = "80px";
                        document.getElementById("main").style.marginLeft= "80px";
                        document.getElementById("content").style.marginLeft = "80px";
                        document.getElementById("content").style.transition = "1.5s";
                        clickTime++;
                        var myIcon = document.getElementsByClassName("icon");
                        for(var i = 0; i < myIcon.length; i++){
                            myIcon[i].style.paddingLeft = "80px";
                            myIcon[i].style.transition = "1.5s";
                        }
                        $(".sidenav > a").css({"padding-left":"20px"});
                    }
                });
            });

            //侧边栏小图标的jquery
            var miniClick = 0;
            $(document).ready(function(){
                $("#nav").click(function(){
                    if(miniClick % 2 == 0){
                        $(".mini").hide();
                        miniClick++;
                    }else{
                        $(".mini").delay(1000).fadeIn(600);
                        miniClick++;
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
                $("#top").click(function(){
                    $("html,body").animate({scrollTop:$("#googlemap").offset().top},1000);
                });
                $("#signSeven").click(function(){
                    $("html,body").animate({scrollTop:$("#seven").offset().top},1000);
                });
                $("#signFamily").click(function(){
                    $("html,body").animate({scrollTop:$("#family").offset().top},1000);
                });
                $("#signChart").click(function(){
                    window.location.href = "locationSearch.php";
                });
            });
        </script>
    </head>
    <body onload="init()">
        <div id="mySidenav" class="sidenav">
            <a id="signSeven"><img src="images/mini-711.png" alt="mini-711" class="mini"><img src="images/7-11.png" alt="7-11" class="icon"></a>
            <a id="signFamily"><img src="images/mini-familymart.png" alt="mini-familymart" class="mini"><img src="images/FamilyMart.png" alt="FamilyMart" class="icon"></a>
            <a id="signChart"><img src="images/Fullmap.png" alt="GoogleChart" class="mini"><img src="images/Fullmap.png" alt="GoogleMap" class="icon" style="height:80px;width:80px;margin-left:50px;"></a>
        </div>
        <div id="main">
            <span style="font-size:30px;cursor:pointer;" id="nav">&#9776; <font style="font-size:15px;letter-spacing:10px;" id="menu">MENU</font></span>
        </div>
<!--        <font id="Mname"></font>-->
<!--        用户名-->
<!--        <a id="login"><font>LogIn</font></a>-->
<!--        登陆/登出按钮-->
        <a id="top"><img src="images/mountains10.png" title="backTop" style="width:40px"></a>
        <div id="content">
            <div id="googlemap" class="store">
<!--                googlemap-->
                <div id="map"></div>
            </div>
            <div id="seven" class="store">
                <div class="leftdetail left">
                    <table class="action">
                        <tr><td class="hide"><a href="SevenEleven/SevenAdd.php"><img src="images/add.png" class="homemini" title="Add"></a></td></tr>
                        <tr><td class="hide"><a href="SevenEleven/SevenSearch.php"><img src="images/search.png" class="homemini" title="Search"></a></td></tr>
                        <tr><td class="hide"><a href="SevenEleven/SevenUpdate.php"><img src="images/update.png" class="homemini" title="Update"></a></td></tr>
                        <tr><td class="hide"><a href="SevenEleven/SevenDelete.php"><img src="images/delete.png" class="homemini" title="Delete"></a></td></tr>
                    </table>
                </div>
                <div class="middetail mid" id="sevenChart"></div>
                <div class="rightdetail right">
                    <font>SevenEleven分布热力图</font>
                    <img src="images/taiwan-seven.png" style="height:100%;">
                </div>
            </div>
            <div id="family" class="store">
                <div class="leftdetail left">
                    <table class="action">
                        <tr><td class="hide"><a href="FamilyMart/FamilyAdd.php"><img src="images/add.png" class="homemini" title="Add"></a></td></tr>
                        <tr><td class="hide"><a href="FamilyMart/FamilySearch.php"><img src="images/search.png" class="homemini" title="Search"></a></td></tr>
                        <tr><td class="hide"><a href="FamilyMart/FamilyUpdate.php"><img src="images/update.png" class="homemini" title="Update"></a></td></tr>
                        <tr><td class="hide"><a href="FamilyMart/FamilyDelete.php"><img src="images/delete.png" class="homemini" title="Delete"></a></td></tr>
                    </table>
                </div>
                <div class="middetail mid" id="familyChart"></div>
                <div class="rightdetail right">
                    <font>FamilyMart分布热力图</font>
                    <img src="images/taiwan-family.png" style="height:100%;">
                </div>
            </div>
<!--
            <div id="chart" class="store">
                <div>
                    <select id="selectLocation" onchange="drawMap()">
                        <option value="长荣大学" selected="selected">请选择超商...</option>
                    </select>
                    还有问题！！！
                </div>
                <div id="mapSearch"></div>
            </div>
-->
        </div>
        
<!--        All SuperMarket Google Chart-->
        <script>
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChartSeven);

            function drawChartSeven() {
                var data1 = google.visualization.arrayToDataTable([
                    ['Location', ''],
                    ['新北市', 1295],
                    ['台南市', 785],
                    ['台北市', 769],
                    ['台中市', 645],
                    ['桃园市', 582],
                    ['高雄市', 530],
                    ['彰化县', 190],
                    ['新竹县', 153],
                    ['屏东市', 142],
                    ['新竹市', 139],
                    ['苗栗县', 104],
                    ['云林县', 100],
                    ['南投县', 90],
                    ['嘉义县', 87],
                    ['宜兰县', 85],
                    ['花莲县', 84],
                    ['基隆市', 73],
                    ['嘉义市', 58],
                    ['台东县', 55],
                    ['澎湖县', 25],
                    ['金门县', 16],
                    ['连江县', 8]
                ]);
                var options = {
                    title: 'SevenEleven',
                    width: 1200,
                    subtitle: '各县市数量',
                    // bars: 'horizontal', // Required for Material Bar Charts.
                    titleTextStyle: {fontName: 'i-medium', fontSize: 30},
                    bar: { groupWidth: '75%' },
                    colors: '#1b9e77'
                };

                var chart = new google.charts.Bar(document.getElementById('sevenChart'));
                chart.draw(data1, google.charts.Bar.convertOptions(options));
            }
        </script>
        <script>
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChartFamily);

            function drawChartFamily() {
                var data = google.visualization.arrayToDataTable([
                    ['Location', ''],
                    ['新北市', 754],
                    ['台南市', 185],
                    ['台北市', 467],
                    ['台中市', 433],
                    ['桃园市', 293],
                    ['高雄市', 276],
                    ['彰化县', 98],
                    ['新竹县', 74],
                    ['屏东市', 73],
                    ['新竹市', 86],
                    ['苗栗县', 70],
                    ['云林县', 65],
                    ['南投县', 57],
                    ['嘉义县', 43],
                    ['宜兰县', 58],
                    ['花莲县', 42],
                    ['基隆市', 57],
                    ['嘉义市', 33],
                    ['台东县', 30],
                    ['澎湖县', 11],
                    ['金门县', 0],
                    ['连江县', 0]
                ]);
                var options = {
                    title: 'FamilyMart',
                    width: 1200,
                    backgroundColor: '#f4f4f4',
                    subtitle: '各县市数量',
                    // bars: 'horizontal', // Required for Material Bar Charts.
                    titleTextStyle: {fontName: 'i-medium', fontSize: 30},
                    bar: { groupWidth: '75%' },
                    colors: '#7570b3'
                };

                var chart = new google.charts.Bar(document.getElementById('familyChart'));
                chart.draw(data, google.charts.Bar.convertOptions(options));
          }
      </script>
        
        
<!--        Google Map-->
        <script>
            function init(){
                var myUrl = "indexDB.php";
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
                            console.log(backData);
                            initMap(backData);
                        }
                    },
                    error: function (textStatus) {
                        console.log(" error!");
                    }
                });
            }
            var map;
            function initMap(inData) {
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 7.87,
                    center: new google.maps.LatLng(23.7, 121.044),
                    styles: [
                      {
                        "elementType": "geometry",
                        "stylers": [{"color": "#f5f5f5"}]
                      },
                      {
                        "elementType": "labels.icon",
                        "stylers": [{"visibility": "off"}]
                      },
                      {
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#616161"}]
                      },
                      {
                        "elementType": "labels.text.stroke",
                        "stylers": [{"color": "#f5f5f5"}]
                      },
                      {
                        "featureType": "administrative.land_parcel",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#bdbdbd"}]
                      },
                      {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [{"color": "#eeeeee"}]
                      },
                      {
                        "featureType": "poi",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#757575"}]
                      },
                      {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [{"color": "#e5e5e5"}]
                      },
                      {
                        "featureType": "poi.park",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#9e9e9e"}]
                      },
                      {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [{"color": "#ffffff"}]
                      },
                      {
                        "featureType": "road.arterial",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#757575"}]
                      },
                      {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [{"color": "#dadada"}]
                      },
                      {
                        "featureType": "road.highway",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#616161"}]
                      },
                      {
                        "featureType": "road.local",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#9e9e9e"}]
                      },
                      {
                        "featureType": "transit.line",
                        "elementType": "geometry",
                        "stylers": [{"color": "#e5e5e5"}]
                      },
                      {
                        "featureType": "transit.station",
                        "elementType": "geometry",
                        "stylers": [{"color": "#eeeeee"}]
                      },
                      {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{"color": "#c9c9c9"}]
                      },
                      {
                        "featureType": "water",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#9e9e9e"}]
                      }
                    ]
                });
                
                var iconBase = 'images/';
                var icons = {
                    seven: {
                        url: iconBase + 'mini-711.png',
                        scaledSize: new google.maps.Size(25, 31.25)
                    },
                    family: {
                        url: iconBase + 'mini-familymart.png',
                        scaledSize: new google.maps.Size(35, 35)
                    }
                };
                
                var features = [
                    {
                        position: new google.maps.LatLng(25.291881, 121.567658), //全台最北
                        type: 'seven',
                        title: '全台最北'
                    },{
                        position: new google.maps.LatLng(21.934119, 120.823397), //全台最南
                        type: 'seven',
                        title: '全台最南'
                    },{
                        position: new google.maps.LatLng(23.062286, 120.129728), //全台最西
                        type: 'seven',
                        title: '全台最西'
                    },{
                        position: new google.maps.LatLng(25.016135, 121.944955), //全台最东
                        type: 'seven',
                        title: '全台最东'
                    },{
                        position: new google.maps.LatLng(24.156498, 120.665207), //博物馆特色门店
                        type: 'family',
                        title: '博物馆'
                    },{
                        position: new google.maps.LatLng(25.063211, 121.48838), //全台最霹雳
                        type: 'seven',
                        title: '全台最霹雳'
                    },{
                        position: new google.maps.LatLng(23.667522, 119.60062), //澎湖seven
                        type: 'seven',
                        title: '澎湖门店'
                    },{
                        position: new google.maps.LatLng(22.753148, 121.153315), //台东大同店
                        type: 'family',
                        title: '台东大同'
                    },{
                        position: new google.maps.LatLng(22.646285, 120.30927), //高雄医学店
                        type: 'family',
                        title: '高雄医学店'
                    },{
                        position: new google.maps.LatLng(25.036845, 121.568655), //全台最大
                        type: 'seven',
                        title: '全台最大'
                    },{
                        position: new google.maps.LatLng(23.986651, 121.601591), //花莲全家
                        type: 'family',
                        title: '花莲全家'
                    },{
                        position: new google.maps.LatLng(24.681581, 121.806562), //带民宿
                        type: 'seven',
                        title: '民宿'
                    },{
                        position: new google.maps.LatLng(25.11025, 121.84527), //九份特色门店
                        type: 'family',
                        title: '九份全家'
                    },{
                        position: new google.maps.LatLng(24.488541, 118.413651), //金门seven
                        type: 'seven',
                        title: '金门7-11'
                    },{
                        position: new google.maps.LatLng(23.574339, 119.578146), //澎湖全家
                        type: 'family',
                        title: '澎湖全家'
                    }
                ];
                
                window.onload = function(){
                    for (var i = 0; i < features.length; i++) {
                        addMarkerWithTimeout(features[i], i * 200);
                    }
                }
                var j = 0;
                function addMarkerWithTimeout(position, timeout) {
                    window.setTimeout(function() {
                        var marker = new google.maps.Marker({
                            map: map,
                            position: features[j].position,
                            title: features[j].title,
                            icon: icons[features[j].type],
                            animation: google.maps.Animation.DROP
                        });
                        j++;
                    }, timeout);
                }
          }
        </script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCW7BiAmAM-n5G3UnbRGj2pfKJRmn9NQ-o&callback=initMap">
        </script>
    </body>
</html>