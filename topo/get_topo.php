<?php
    if (!empty($_POST["type"])){
        $type = $_POST["type"];
        if($type == "topo"){
            echo exec('cat /home/git/thesis/src/data/caida/ip/20160528/san-us/caida.ip.20160528.san-us.graphviz');
        }
    }
?>
