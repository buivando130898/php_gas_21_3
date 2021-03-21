<?php
 // connect mysql
    $servername = "localhost";
    $username = "iothello_datalock";
    $password = "ngangoNGAO05";
    $dbname = "iothello_datalock";
    $conn = mysqli_connect($servername,$username,$password,$dbname);

    

    $sql = "SELECT * FROM login WHERE acc = '$user' and pass = '$password' ";
    $query = mysqli_query($conn,$sql);
    $num_rows = mysqli_num_rows($query);


    $bienx = ['t2','t3','t4','t5','t6','t7','t8', 't10'];
    $bieny = [3, 10, 400, 5, 22, 13, 20, 22];

?>


<script>

    var bienx =  ['t2','t3','t4','t5','t6','t7','t8', 't10'];
    var bieny = [3, 10, 40, 5, 22, 13, 20, 22, 66, 66,44,47,88,37];
    var CHART = document.getElementById("line_chart").getContext('2d');
    var line_chart = new Chart(CHART,{
        type: 'line',
        data:{
            labels: <?php echo json_encode($bienx, JSON_NUMERIC_CHECK);   ?>,
            datasets: [{
                lablel: "name_data",
                data: <?php echo json_encode($bieny, JSON_NUMERIC_CHECK);   ?>

            }]
        }
    });



</script>



<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Gas _Ether</title>
        <meta charset="utf-8" />
        <meta name="description" content="Gas _Ether" />
        <meta name="keywords" content="Wordpress, theme wordpress, html, css, html css free, SEO, dịch vụ SEO, Thiết kế website chuẩn SEO">
        <meta name="author" content="Tác giả" />
        <meta http-equiv="Content-Language" content="Vi"> <!-- Khai bao ngôn ngữ -->
        <meta http-equiv="refresh" content="30"> <!-- Làm mới tài liệu trong 30s -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">     <!-- Đặt chế độ xem  -->
        <link rel="stylesheet" href="./style.css"> <!-- Thẻ nhúng file CSS -->
        <script src="./js.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>    
 
    
    </head>



<body>

    <div>
        <canvas id="line_chart"></canvas>
    </div>


    
</body>


</html>
