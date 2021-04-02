<?php

    function gas_month() 
    {
        $servername = "172.17.0.2";
        $username = "root";
        $password = "ngangongao05";
        $dbname = "update_gas";
        $conn = mysqli_connect($servername,$username,$password,$dbname);
        $sql = "SELECT DISTINCT MONTH(gas_date) FROM gas";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {  
            while($row = $result->fetch_assoc()) 
            {
                $gas_month[]=$row["MONTH(gas_date)"];
            }
        }
        return $gas_month;

    }

    function array_gas($date_gas, $gas_month_select) 
    {
        $servername = "172.17.0.2";
        $username = "root";
        $password = "ngangongao05";
        $dbname = "update_gas";

        //SELECT AVG(low),AVG(average),AVG(high) FROM `gas` WHERE HOUR(gas_time)=0 AND gas_date="2021-03-02"
        $conn = mysqli_connect($servername,$username,$password,$dbname);
        $sql = "SELECT * FROM gas where gas_date = '$date_gas' AND MONTH(gas_date) = '$gas_month_select' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) 
            {
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

    
        for($i=0;$i<24;$i++)
        {
            for($h=0; $h<4; $h++)
            {
                $dem = 0;
                $value = 0;
                $value_low = 0;
                $value_high = 0;
                if(isset($array_time[$i][$h])) 
                {
                    for($j=0; $j<count($array_time[$i][$h]); $j++)
                    {
                        if(isset($array_time[$i][$h][$j]))
                        {
                            //echo $array_time[$i][$h][$j]."  :   ".$array_value[$i][$h][$j]."........." ;
                            //echo "       ";
                            $dem++;
                            $value = $value + $array_value[$i][$h][$j];
                            $value_low = $value_low + $array_value_low[$i][$h][$j];
                            $value_high = $value_high + $array_value_high[$i][$h][$j];
                            //echo $j."  ";
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
                else 
                {
                    $gas_value[] = 0;
                    $gas_value_low[] = 0;
                    $gas_value_high[] = 0;
                }        
            }
        }

        $ar_value[0] = $gas_value_low;
        $ar_value[1] = $gas_value;
        $ar_value[2] = $gas_value_high;
        return $ar_value;    
    }

    function array_gas_full($date_gas, $shear) 
    {
        //echo "__________________________________________________".$date_gas."   :::   ";
        $servername = "172.17.0.2";
        $username = "root";
        $password = "ngangongao05";
        $dbname = "update_gas";


        $conn = mysqli_connect($servername,$username,$password,$dbname);
        $sql = "SELECT * FROM gas where gas_date = '$date_gas' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {

                $gas_time_1 = $row["gas_time"];
                $time2 = FLOOR((strtotime($gas_time_1)-strtotime("00:00:00"))/60);
                $time2_hour = FLOOR($time2/60);
                $array_full_data[$time2_hour][] = $row[$shear];
            }   
        }

        for($i=0;$i<24;$i++)
        {
            $value = 0;
            $dem=0;
            for($j=0; $j<100;$j++)
            {
                if( isset($array_full_data[$i][$j]) )
                {
                    $value = $value + $array_full_data[$i][$j];
                    $dem ++;
                }
            }
            if($dem != 0)
            {
                $array_value[] = FLOOR($value/$dem);
                // echo FLOOR($value/$dem);
            } else $array_value[]="";

        } 
        
            return $array_value;    
    }
    


    $dem =0;
    $dem_ar = 0;

    if(isset($_GET["gas"]) )
    {
        $shear = $_GET["gas"];
    } else {
        $shear = "average";
    }

    if(isset($_GET["min"]) )
    {
        $min = $_GET["min"];
    } else {
        $min = 90;
    }

    if(isset($_GET["max"]) )
    {
        $max = $_GET["max"];
        
    } else {
        $max = 130;
    }

    $gas_month = gas_month();



    if(isset($_GET["gas_month"]) )
    {
        $gas_month_select = $_GET["gas_month"];
    } else {
        $gas_month_select = $gas_month[count($gas_month)-1];
        //echo $gas_month_select;
    }




    
    $servername = "172.17.0.2";
    $username = "root";
    $password = "ngangongao05";
    $dbname = "update_gas";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    $sql1 = "SELECT DISTINCT gas_date  FROM  gas";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows > 0) 
    {  
        while($row1 = $result1->fetch_assoc()) 
        {  
            //chart average
            $full_data[$dem_ar] = array_gas($row1["gas_date"], $gas_month_select);
            ++$dem_ar;    
            //chart full data
            $full_data_2[] = array_gas_full($row1["gas_date"], $shear);
                for($i=0;$i<24;$i++) 
                {
                   // echo $full_data[$dem][$i]."    _________    ";
                    $time =  $i.":"."00";
                    $full_data_gas[] = array("x"=>$time, "y"=>$row1["gas_date"], "heat"=>$full_data_2[$dem][$i]) ;
                }

                ++$dem;
        }
    } 
    
    for($i=0;$i<24;$i++)
        {
            for($h=0; $h<4; $h++){
            
                if($h != 0)
                    $gas_time[] = $i.":".($h*15); 
                else $gas_time[] = $i.":"."00";                   
        }
    }

    

    for($i = 0; $i< 3; $i++)
    {
        for($j = 0; $j< 96; $j++) 
        {
            $sum = 0;
            $dem_sum = 0;
            for($h = 0; $h< $dem_ar; $h++)
            {
                if(isset($full_data[$h][$i][$j]) && $full_data[$h][$i][$j] != 0) 
                {
                    $sum += $full_data[$h][$i][$j];
                    ++$dem_sum; 
                }
            }
            if($dem_sum!=0){
                $data_full_gas[$i][] = FLOOR($sum/$dem_sum);
            }else {
                $data_full_gas[$i][]=null;
            }
        }
    }
/*
    $conn = mysqli_connect($servername,$username,$password,$dbname);

        $sql2 = "SELECT DISTINCT gas_date  FROM  gas";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) 
        {  
            while($row2 = $result2->fetch_assoc()) 
            {  
                $full_data_2[] = array_gas_full($row2["gas_date"], $shear);
                for($i=0;$i<24;$i++) 
                {
                   // echo $full_data[$dem][$i]."    _________    ";
                    $time =  $i.":"."00";
                    $full_data_gas[] = array("x"=>$time, "y"=>$row2["gas_date"], "heat"=>$full_data_2[$dem][$i]) ;
                }

                ++$dem;
            }
        }  

*/  
            

?>


<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Gas _Ether</title>
        <meta charset="utf-8" />
        <meta name="description" content="Gas Price" />
        <meta name="keywords" content="Wordpress, theme wordpress, html, css, html css free, SEO, dịch vụ SEO, Thiết kế website chuẩn SEO">
        <meta name="author" content="Tác giả" />
        <meta http-equiv="Content-Language" content="Vi"> <!-- Khai bao ngôn ngữ -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">     <!-- Đặt chế độ xem  -->
        <link rel="stylesheet" href="./index1.css"> <!-- Thẻ nhúng file CSS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script> 
        <script src="https://cdn.anychart.com/releases/8.7.1/js/anychart-core.min.js"></script>
        <script src="https://cdn.anychart.com/releases/8.7.1/js/anychart-heatmap.min.js"></script>
        <link rel="shortcut icon" type="image/png" href="https://iothello.tk/img/gas1.png"/>
        <style>
            #container {
                width: 90%;
                margin: auto;
                padding: 0;
      }
        </style>
    </head>

<body>

    <div class="header">
        <div class="logo" id="logo_login" >
            <img id="imglogo" src="https://iothello.tk/img/gas1.png" alt="" width="40px" height="40px">
            <h1 id="logo"> <a href="index.php"> Gas Prices </a></h1>    
        </div>
        <div class="contact">
            <ul>
                <li><a href="https://t.me/meepne"><img id="tele" src="https://iothello.tk/img/tele.png" alt=""></a></li>
                <li><a href="https://discord.gg/hUyQuYvJ"><img id="discord" src="https://iothello.tk/img/discord2.png" alt=""></a></li>
            </ul>
        </div>

    </div>


    <div class = "chart">
       <div class="title_his" id="month"><h2 style="color:#2b2b7e">Monthly average gas price</h2></div>
       <h3 style="padding: 20px;">
            <form name="gas_month" action="#month" method="GET">
                <label>Month:</label>
                <select  name="gas_month">
                <?php 
                        for($i=0;$i<count($gas_month);$i++){  ?>
                                <option value="<?php echo  $gas_month[$i];?>"  <?php if($gas_month[$i]==$gas_month_select)  echo "selected"; ?>><?php echo  $gas_month[$i];?></option>
                            <?php
                            } 
                    ?>
                </select>

                <input type="submit" value="UPDATE">
            </form>
        </h3>
        <div class="line_chart" ><canvas id="line_chart" ></canvas></div>
    </div>
    <hr>
    <div class="title_his"><h2 style="color:#2b2b7e">History Gas Price</h2></div>
    
    <div class="form_chart" style="padding:10px 40px;" id="history">
        <form name="gas" action="#history" method="GET">
            <label>Gas:</label>
            <select  name="gas">
                <option value="low" <?php if($shear=="low")  echo "selected"; ?> >Low</option>
                <option value="average" <?php if($shear=="average")  echo "selected"; ?> >Average</option>
                <option value="high" <?php if($shear=="high")  echo "selected"; ?> >High</option>
            </select>
            <label>Price:</label>
            <input type="text" style="width:30px" value = "<?php echo $min ?>" name="min"> - <input type="text" style="width:30px" value="<?php echo $max ?>" name="max">

            <input type="submit" value="UPDATE">
        </form>
    </div>
    <div id="container"></div>
    
</body>
</html>

<script>

    var CHART = document.getElementById("line_chart").getContext('2d');
    var line_chart = new Chart(CHART,{
        type: 'line',
        data:{
            labels: <?php  echo json_encode($gas_time, JSON_NUMERIC_CHECK);   ?>,

            datasets: [{
                label: "low",
                data: <?php echo json_encode($data_full_gas[0], JSON_NUMERIC_CHECK);   ?>,
               
                fill: false,
                backgroundColor: '#00c9a7',
                borderColor: '#00c9a7',
                borderWidth: 0
            },
                {
                label: "average",
                data: <?php echo json_encode($data_full_gas[1], JSON_NUMERIC_CHECK);   ?>,
               
                fill: false,
                backgroundColor: '#3498db',
                borderColor: '#3498db',
                borderWidth: 0
            },
            {
                label: "high",
                data: <?php echo json_encode($data_full_gas[2], JSON_NUMERIC_CHECK);   ?>,
               
                fill: false,
                backgroundColor: 'rgb(165, 42, 42)',
                borderColor: 'rgb(165, 42, 42)',
                borderWidth: 0
            }
            
            //           
        ]
        },
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

    var data = <?PHP echo json_encode( $full_data_gas, JSON_NUMERIC_CHECK);    ?>
    //ar(typeof data);
    //alert(data.length/24*50);
    document.getElementById("container").style.height=data.length*24/24 + "px";
    anychart.onDocumentReady(function () {

    // create the data 

    chart = anychart.heatMap(data);

    // set the chart title
    chart.title("");
    // create and configure the color scale
    var customColorScale = anychart.scales.ordinalColor();
    var min_gas = <?PHP echo json_encode( $min, JSON_NUMERIC_CHECK);    ?>;
    var max_gas = <?PHP echo json_encode( $max, JSON_NUMERIC_CHECK);    ?>;

    customColorScale.ranges([
        { less: min_gas, name: "" },
        { from: min_gas, to: max_gas,  name: "", color: 'rgb(89, 103, 233)' },
        { greater: max_gas,  name: "" }
    ]);

    customColorScale.colors(["rgb(158, 228, 158)", "rgb(89, 103, 233)", "rgb(240, 124, 124)"]);
    chart.legend(true);
    chart.colorScale(customColorScale);
    var tooltip = chart.tooltip(false);
    chart.container("container");
    chart.draw();
    });

</script>
