<?php
    $greetings = array("Whatup biatch", "Sup nigga", "Hello motherfucker");
    $index = 0;
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(trim($_GET["index"] == "")){
            echo "nigga yo forgot to set index.";
        }
        else{
            $index = $_GET["index"];
            if($index < 0 || $index > 2){
                $index = 0;
            }
            echo $greetings[$index];
        }
    }
?>