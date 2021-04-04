
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
            title: {
                display: true,
                text: 'Time zone: UTC',
                fontColor: 'rgba(43, 43, 158, 0.733)',
            },
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
        title:{
		text: "test",
	    },
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
            title: {
                display: true,
                text: 'Time zone: UTC',
                fontColor: 'rgba(43, 43, 158, 0.733)',
            },
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