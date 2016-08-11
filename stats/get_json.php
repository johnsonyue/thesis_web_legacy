<?php
    if (!empty($_POST["type"])){
        $type = $_POST["type"];
        if($type == "degree"){
            echo exec('cat /home/git/thesis/src/data/caida/ip/20070916/syd-au/caida.ip.20070916.syd-au.degree');
        }
        elseif($type == "path"){
            echo exec('cat /home/git/thesis/src/data/caida/ip/20070916/syd-au/caida.ip.20070916.syd-au.pt');
        }
    }
?>