<?php
if(isset($_GET["theme"]))
    {
        setcookie("theme", $_GET["theme"],time() + 6000000, );
        
    }

if(isset( $_COOKIE["theme"])) 
{
    echo  "$$$$$   : ".$_COOKIE["theme"];
} 
else echo "nonono";


?>