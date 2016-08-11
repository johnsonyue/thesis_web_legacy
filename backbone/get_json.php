<?php
if (!empty($_POST["type"])){
    $type = $_POST["type"];
    if($type == "table"){
        echo exec('cat /home/git/thesis/src/data/caida/ip/20160528/syd-au/caida.ip.20160528.syd-au.bb');
    }
    elseif($type == "graphviz"){
        echo exec('cat /home/git/thesis/src/data/caida/ip/20160528/syd-au/caida.ip.20160528.syd-au.bb');
    }
}
?>