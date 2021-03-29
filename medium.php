<?php

    $hour = 0;
    $today = date("Y-m-d");

    if(isset($_GET["date_gas"]))
    {
        $date_gas = $_GET["date_gas"];
    } else {
        $date_gas = $today;
    }

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "update_gas1";

        $conn = mysqli_connect($servername,$username,$password,$dbname);
        $sql = "SELECT * FROM gas  ";
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
    
 
        for($i=0;$i<24;$i++)
            {
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
                            //echo $j."  ";
                        }   
                    }}
                   
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
                        $gas_value[] = 0;
                        $gas_value_low[] = 0;
                        $gas_value_high[] = 0;
                    }
                
                    
            }
            }


?>


<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Gas _Ether</title>
        <meta charset="utf-8" />
        <meta name="description" content="Gas _Ether" />
        <meta name="keywords" content="Wordpress, theme wordpress, html, css, html css free, SEO, dịch vụ SEO, Thiết kế website chuẩn SEO">
        <meta name="author" content="Tác giả" />
        <meta http-equiv="Content-Language" content="Vi"> <!-- Khai bao ngôn ngữ -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">     <!-- Đặt chế độ xem  -->
        <link rel="stylesheet" href="./style.css"> <!-- Thẻ nhúng file CSS -->
        <script src="./js.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script> 
    </head>

<body>
    
<h2>Average month 3</h2>
    <div style="width:90%"><canvas id="line_chart" ></canvas></div>

    
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

   


</script>