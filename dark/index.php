
<script>



</script>


<head>
    <meta charset="utf-8" >
    <link id="css"rel="stylesheet" href="style.css">
    

</head>
<script src="js.js"></script>
<body class=" <?php  if($_COOKIE["theme"]=="dark")  echo "dark";    ?>  ">
    
    <button onclick="save_dark()">dark</button>
    <button onclick="save_ligh()">ligh</button>
    <button onclick="print()">print</button>

    <h1>hello ô</h1>
    <h1>test nào</h1>
    <h1>a su su</h1>
    <div class="test1">đây là test 1</div>
    <div class="test2">Đây là test 2</div>
</div>

<?php    

    if(isset( $_COOKIE["theme"])) 
    {
        echo  "$$$$$   : ".$_COOKIE["theme"];
    } 
    else echo "nonono";


?>
</body>




  