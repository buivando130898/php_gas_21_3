<?php

$gas_time = array();
$gas_value =  array();
$hour = 0;
$today = date("Y-m-d");
    if(isset($_GET["date_gas"]))
	{
		$date_gas = $_GET["date_gas"];
	} else {
    $today = date("Y-m-d");
            $date_gas = $today;
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "update_gas1";

    $conn = mysqli_connect($servername,$username,$password,$dbname);
    $sql = "SELECT * FROM gas WHERE gas_date = '$date_gas' and average < 300 ";
    //echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
		// output dữ liệu trên trang
		
		while($row = $result->fetch_assoc()) {
			$gas_time_0[]=$row["gas_time"];
			$gas_price[]=$row["average"];
            $gas_time_1 = $row["gas_time"];
            $time_js[] = FLOOR((strtotime($gas_time_1)-strtotime("00:00:00"))/60);



            $time2 = FLOOR((strtotime($gas_time_1)-strtotime("00:00:00"))/60);
            $time2_hour = FLOOR($time2/60);
            $gas_price_1=$row["average"];
            $time2 = $time2 % 60;

            //$array_time[$time2_hour][] =  $time2;
            //$array_value[$time2_hour][] = $row["average"];
            
            
            if($time2>=53 || $time2 <=7)
            {
                //echo "lolol";
               $array_time[$time2_hour][0][] = $time2;
               $array_value[$time2_hour][0][] = $row["average"];
                
            }
            else if($time2>=8 && $time2<=22) 
            {
                $array_time[$time2_hour][1][] = $time2;
                $array_value[$time2_hour][1][] = $row["average"];
            }
            else if($time2>=23 && $time2<=37)
            {
                echo $time2;
                echo "lolol";
                $array_time[$time2_hour][2][] =$time2;
                $array_value[$time2_hour][2][] = $row["average"];
            }
            else if($time2>=38 && $time2<=52)
            {
                echo $time2;
                echo "lolol";
                $array_time[$time2_hour][3][] = $time2;
                $array_value[$time2_hour][3][] = $row["average"];
            }
            
            /*
            if($time2%60 ==0)
            {
            echo $time2;
            echo "       ";
            
            }*/

		}   
	}
 
    
    for($i=0;$i<24;$i++)
        {
            for($h=0; $h<4; $h++){
                $dem = 0;
                $value = 0;
                
                for($j=0; $j<100; $j++)
                {

                    if(isset($array_time[$i][$h][$j])){
                        //echo $array_time[$i][$h][$j]."  :   ".$array_value[$i][$h][$j]."........." ;
                        //echo "       ";
                        $dem++;
                        $value = $value + $array_value[$i][$h][$j];
                    }
                    
                }

                $gas_time[] = $i.":".$h; 
                //echo "     ".$i.":".$h."......";

                if($dem != 0)
                {
                    $gas_value[] = FLOOR($value/$dem);
                    //echo FLOOR($value/$dem);
                }
                else {
                    
                    $gas_value[] = 0;
                    //echo "0";
                }
            
                 
        }
        }

echo "------------------------------------------";

    for($i=0;$i < count($gas_value);$i++)
    {
        //echo $gas_value[$i];
        //echo "       ";
            
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>    


    </head>

<body>
    <h2>
        <form name="date_gas" action="" method="GET">
            <label>DATE:</label>
            <select  name="date_gas">
            <?php 
                $sql = "SELECT DISTINCT gas_date  FROM  gas";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output dữ liệu trên trang
                    
                    while($row = $result->fetch_assoc()) {  ?>
                        <option value="<?php echo  $row["gas_date"];?>"  <?php if($row["gas_date"]==$today)  echo "selected"; ?>><?php echo  $row["gas_date"];?></option>
                    <?php
                    }
                }  
                
            ?>
            
            </select>
            <input type="submit" value="UPDATE">
        </form>
    </h2>


    <div style="width:90%"><canvas id="line_chart" ></canvas></div>
    <div style="width:90%"><canvas id="line_chart2" ></canvas></div>
    
</body>


</html>


<script>
    
    //const a = ['03:31:00','09:21:09','21:03:27']
    var CHART = document.getElementById("line_chart").getContext('2d');
    var line_chart = new Chart(CHART,{
        type: 'line',
        data:{
            labels: <?php echo json_encode($gas_time, JSON_NUMERIC_CHECK);   ?>,
            //xAxisID: a,
            datasets: [{
                label: "test",
                data: <?php echo json_encode($gas_value, JSON_NUMERIC_CHECK);   ?>,
               
                //fill: false,
                backgroundColor: 'rgb(99, 99, 211)',
                borderColor: 'rgb(81, 81, 211)',
                borderWidth: 0
            },
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
                                 suggestedMin: 0,
                                 suggestedMax: 140,
                                 stepSize: 20

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
                label: "test",
                data: <?php echo json_encode($gas_price, JSON_NUMERIC_CHECK);   ?>,
               
                //fill: false,
                backgroundColor: 'rgb(99, 99, 211)',
                borderColor: 'rgb(81, 81, 211)',
                borderWidth: 0
            },
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
                                 suggestedMin: 0,
                                 suggestedMax: 140,
                                 stepSize: 20

                                     }
                                }]

                    }   
                }




    });


</script>