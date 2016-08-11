<?php
    if (!empty($_POST["type"])){
        $type = $_POST["type"];
        if($type == "table"){
            echo exec('cat /home/git/thesis/src/data/caida/ip/20160528/san-us/caida.ip.20160528.san-us.border');
        }
        elseif($type == "graphviz"){
            echo exec('cat /home/git/thesis/src/data/caida/ip/20070916/syd-au/caida.ip.20070916.syd-au.border');
        }
    }
?>
