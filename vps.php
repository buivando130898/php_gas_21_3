<?php

    $hour = 0;
    $today = date("Y-m-d");

    if(isset($_GET["date_gas"]) )
    {
        $date_gas = $_GET["date_gas"];
    } else {
        $date_gas = $today;
    }

    $servername = "172.17.0.2";
    $username = "root";
    $password = "ngangongao05";
    $dbname = "update_gas";
    $conn = mysqli_connect($servername,$username,$password,$dbname);

    $sql = "SELECT * FROM gas WHERE gas_date = '$date_gas'  ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $gas_time_0[]=$row["gas_time"];       
            $gas_price[]=$row["average"];
            $gas_price_low[]=$row["low"];
            $gas_price_high[]=$row["high"];

            $gas_time_1 = $row["gas_time"];

            $time2 = FLOOR((strtotime($gas_time_1)-strtotime("00:00:00"))/60);
            $time2_hour = FLOOR($time2/60);
            $gas_price_1=$row["average"];
            $time2 = $time2 % 60;


            if($time2>=53 || $time2 <=7)
            {
                $array_time[$time2_hour][0][] = $time2;
                $array_value_low[$time2_hour][0][] = $row["low"];
                $array_value_high[$time2_hour][0][] = $row["high"];
                $array_value[$time2_hour][0][] = $row["average"];
                
            }
            else if($time2>=8 && $time2<=22) 
            {
                $array_time[$time2_hour][1][] = $time2;
                $array_value_low[$time2_hour][1][] = $row["low"];
                $array_value_high[$time2_hour][1][] = $row["high"];
                $array_value[$time2_hour][1][] = $row["average"];
            }
            else if($time2>=23 && $time2<=37)
            {

                $array_time[$time2_hour][2][] =$time2;
                $array_value_low[$time2_hour][2][] = $row["low"];
                $array_value_high[$time2_hour][2][] = $row["high"];
                $array_value[$time2_hour][2][] = $row["average"];
            }
            else if($time2>=38 && $time2<=52)
            {
                $array_time[$time2_hour][3][] = $time2;
                $array_value_low[$time2_hour][3][] = $row["low"];
                $array_value_high[$time2_hour][3][] = $row["high"];
                $array_value[$time2_hour][3][] = $row["average"];
            }

        }   
    }
    
 
    for($i=0;$i<24;$i++){
            for($h=0; $h<4; $h++){
                $dem = 0;
                $value = 0;
                $value_low = 0;
                $value_high = 0;
                
                if(isset($array_time[$i][$h])) {
                for($j=0; $j<count($array_time[$i][$h]); $j++)
                {
                    if(isset($array_time[$i][$h][$j])){
                        //echo $array_time[$i][$h][$j]."  :   ".$array_value[$i][$h][$j]."........." ;
                        //echo "       ";
                        $dem++;
                        $value = $value + $array_value[$i][$h][$j];
                        $value_low = $value_low + $array_value_low[$i][$h][$j];
                        $value_high = $value_high + $array_value_high[$i][$h][$j];
                    }   
                }
                }
                if($h != 0)
                    $gas_time[] = $i.":".($h*15); 
                else $gas_time[] = $i.":"."00";
                //echo "     ".$i.":".$h."......";

                if($dem != 0)
                {
                    $gas_value[] = FLOOR($value/$dem);
                    $gas_value_low[] = FLOOR($value_low/$dem);
                    $gas_value_high[] = FLOOR($value_high/$dem);
                    //echo FLOOR($value/$dem);
                }
                else {
                    $gas_value[] = null;
                    $gas_value_low[] = null;
                    $gas_value_high[] = null;
                }
            
                
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Gas _Ether</title>
        <meta charset="utf-8" />
        <meta name="description" content="Gas _Price" />
        <meta name="keywords" content="gas price, price gas, chart gas, ether, ethereum">
        <meta name="author" content="77" />
        <meta http-equiv="Content-Language" content="Vi"> <!-- Khai bao ngôn ngữ -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">     <!-- Đặt chế độ xem  -->
        <link rel="stylesheet" href="./index1.css"> <!-- Thẻ nhúng file CSS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script> 
        <link rel="shortcut icon" type="image/png" href="https://iothello.tk/img/gas1.png"/>
    </head>

<body>

    <div class="header">
        <div class="logo" id="logo_login" >
            <img id="imglogo" src="https://iothello.tk/img/gas1.png" alt="" width="40px" height="40px">
            <h1 id="logo"> <a href=""> Gas Prices </a></h1>    
        </div>
        <div class="contact">
            <ul>
                <li><a href="https://t.me/meepne"><img id="tele" src="https://iothello.tk/img/tele.png" alt=""></a></li>
                <li><a href="https://discord.gg/hUyQuYvJ"><img id="discord" src="https://iothello.tk/img/discord2.png" alt=""></a></li>
            </ul>
        </div>

    </div>

    <div  class="price_gas">
        <ul  class="root">
            <li class="price1"><div class="price"><center><p class="text">Low</p><h1 id="low" style="color: #00c9a7 ;"></h1></center></div></li>
            <li class="price1"><div class="price"><center><p class="text">Average</p><h1 id="average"  style="color: #3498db ;"></h1></center></div></li>
            <li class="price1"><div class="price"><center><p class="text">High</p><h1 id="high"  style="color: rgb(165, 42, 42) ;"></h2></center></div></li>
        </ul>
    </div>
    
    <center><p><i id="second">0</i>s ago</p> </center>
        
    <div class = "moth_average">
    <center>
        <h2 > <p style="color:whitesmoke">Monthly average gas price chart</p></h2>
        <a href="ava.php" id="ava">go to >></a>
    </center>
    </div>
        
    <div class = "chart">
       <div class="title_his"><h2 style="color:#2b2b7e">Gas price by day</h2></div>
        <h3 style="padding: 20px;">
            <form name="date_gas" action="" method="GET">
                <label>DATE:</label>
                <select  name="date_gas">
                    <?php 
                        $sql = "SELECT DISTINCT gas_date  FROM  gas";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {  
                            while($row = $result->fetch_assoc()) {  ?>
                                <option value="<?php echo  $row["gas_date"];?>"  <?php if($row["gas_date"]==$date_gas)  echo "selected"; ?>><?php echo  $row["gas_date"];?></option>
                            <?php
                            }
                        }  
                        
                    ?>
                </select>

                <input type="submit" value="UPDATE">
            </form>
        </h3>
        <div class="line_chart" ><canvas id="line_chart" ></canvas></div>
        <hr>
        <h3 style="margin-top:20px;margin-left:20px;">FULL DATA:</h3>
        <div class="line_chart" ><canvas id="line_chart2" ></canvas></div>
    
    </div>
    
</body>


</html>



<script>

    var seconds=0;
    function gas() {
        const endpoint = 'https://api.etherscan.io/api?module=gastracker&action=gasoracle&apikey=A3MXYC2RACK6CAKUN1J1GDFIF78F9QYKKI';
        fetch(endpoint)
            .then((response) => response.json())
            .then((data) => {
                console.log(data)
                document.getElementById("low").innerHTML=data.result.SafeGasPrice;
                document.getElementById("average").innerHTML=data.result.ProposeGasPrice;
                document.getElementById("high").innerHTML=data.result.FastGasPrice;
                
                
                });
    }

    gas();

    setInterval(function() {
        ++seconds;
        if(seconds==10){
            gas();
            seconds=0;
        }
        document.getElementById("second").innerHTML=seconds;
    }, 1000)

    var CHART = document.getElementById("line_chart").getContext('2d');
    var line_chart = new Chart(CHART,{
        type: 'line',
        data:{
            labels: <?php  echo json_encode($gas_time, JSON_NUMERIC_CHECK);   ?>,

            datasets: [{
                label: "low",
                data: <?php echo json_encode($gas_value_low, JSON_NUMERIC_CHECK);   ?>,
               
                fill: false,
                backgroundColor: '#00c9a7',
                borderColor: '#00c9a7',
                borderWidth: 0
            },
                {
                label: "average",
                data: <?php echo json_encode($gas_value, JSON_NUMERIC_CHECK);   ?>,
               
                fill: false,
                backgroundColor: '#3498db',
                borderColor: '#3498db',
                borderWidth: 0
            },
            {
                label: "high",
                data: <?php echo json_encode($gas_value_high, JSON_NUMERIC_CHECK);   ?>,
               
                fill: false,
                backgroundColor: 'rgb(165, 42, 42)',
                borderColor: 'rgb(165, 42, 42)',
                borderWidth: 0
            }
    
        ]},
        options: {
            elements: {
                    point:{
                        //radius: 0
                    }
                },


            scales: {
                xAxes: [{
                    afterTickToLabelConversion: function(data){
                        var xLabels = data.ticks;

                        xLabels.forEach(function (labels, i) {
                            if (i % 4 != 0){
                                xLabels[i] = '';
                            }
                        });
                    } 
                }],
                
                yAxes: [{
                        ticks: {
                        // suggestedMin: 0,
                            //suggestedMax: 140,
                        // stepSize: 20

                                }
                        }]

                }   
        }
    });

    var CHART = document.getElementById("line_chart2").getContext('2d');
    var line_chart2 = new Chart(CHART,{
        type: 'line',
        data:{
            labels: <?php echo json_encode($gas_time_0, JSON_NUMERIC_CHECK);   ?>,
            //xAxisID: a,
            datasets: [{
                label: "low",
                data: <?php echo json_encode($gas_price_low, JSON_NUMERIC_CHECK);   ?>,
                fill: false,
                backgroundColor: '#00c9a7',
                borderColor: '#00c9a7',
                borderWidth: 0
            },
                {
                label: "average",
                data: <?php echo json_encode($gas_price, JSON_NUMERIC_CHECK);   ?>,
               
                fill: false,
                backgroundColor: '#3498db',
                borderColor: '#3498db',
                borderWidth: 0
            },
            {
                label: "high",
                data: <?php echo json_encode($gas_price_high, JSON_NUMERIC_CHECK);   ?>,
               
                fill: false,
                backgroundColor: 'rgb(165, 42, 42)',
                borderColor: 'rgb(165, 42, 42)',
                borderWidth: 0
            }        
        ]},
        options: {
            elements: {
                    point:{
                        radius: 0
                    }
                },


            scales: {
                xAxes: [{
                    /*
                    afterTickToLabelConversion: function(data){
                    var xLabels = data.ticks;

                    xLabels.forEach(function (labels, i) {
                        if (xLabels[i] % 60 != 0){
                            xLabels[i] = '';
                        }
                    });
                    } 
                    */
                }],
                
                yAxes: [{
                        ticks: {
                        // suggestedMin: 0,
                        //  suggestedMax: 140,
                        //  stepSize: 20
                                }
                        }]
                    }   
            }




    });


</script>