<?php
    if (!empty($_POST["type"])){
        $type = $_POST["type"];
        if($type == "map"){
            echo exec('cat /home/git/thesis/src/data/caida/ip/20070916/syd-au/caida.ip.20070916.syd-au_map_data.json');
        }
    }
?>