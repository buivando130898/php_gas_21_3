<?php
require 'restful_api.php';

class api extends restful_api {

	function __construct(){
		parent::__construct();
	}

	function gas_min(){
		if ($this->method == 'GET'){
		
			$data = array();
			$Day_number = 5;
			$today = date("Y-m-d");
        	$date_today = date_create($today);
		
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "update_gas1";
			$conn = mysqli_connect($servername,$username,$password,$dbname);
		
			for($i=0;$i<24;$i++) {
				$sum = 0;
				$count = 0;
				for($j=1;$j<=5;$j++) {
		
					date_modify($date_today, "-$j days");
					$date = date_format($date_today, "Y-m-d");
					$sql = "SELECT average FROM gas where  HOUR(gas_time) = $i AND gas_date = '$date' ";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) 
						{
							$sum = $sum + $row["average"];
							$count++;
						}
					}
					date_modify($date_today, "+$j days");
				}
				if($count!=0)
					$average[$i] = FLOOR($sum/$count);
			}
			$min = $average[0];
			$hour = 0;
		
			for($i=1;$i<24;$i++){
		
				if($average[$i]<$min)
				{
					$min = $average[$i];
					$hour = $i;
				}
			}
			$data[] = $min;
			$data[] = $hour;
			$this->response(200, $data);
		}
	}
}



$user_api = new api();
?>
