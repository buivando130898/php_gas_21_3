<?php

    function out_datta()
    {
        $servername = "172.17.0.2";
        $username = "root";
        $password = "ngangongao05";
        $dbname = "update_gas";
        $conn = mysqli_connect($servername,$username,$password,$dbname);
    
        $sql = "SELECT * FROM gas";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
                echo "('".$row["gas_date"]."','".$row["gas_time"]."',".$row["low"].",".$row["average"].",".$row["high"]."),";
                echo "<br>";
            }
        }
    }

        
    if(isset($_GET["token"]) && $_GET["token"]=="ngango75631479" ) 
    {
        out_datta();
    } 

?>


