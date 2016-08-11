<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../bootstrap-3.3.6-dist/css/dashboard.css" rel="stylesheet">
    <style type="text/css">
        line{
            stroke:rgb(256,0,0);
            stroke-width:0.1;
        }
    </style>
</head>

<body>
<script src="../bootstrap-3.3.6-dist/js/jquery.min.js"></script>
<script src="../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="../bootstrap-3.3.6-dist/js/d3.min.js"></script>
<script src="../bootstrap-3.3.6-dist/js/queue.v1.min.js"></script>
<script src="../bootstrap-3.3.6-dist/js/topojson.v0.min.js"></script>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">HIT NISL</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Login</a></li>
                <li><a href="#">Register</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="../front.php">overview</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">topology</a></li>
                <li><a href="../stats/stats.php">statistics</a></li>
                <li><a href="../map/map.php">map</a></li>
                <li><a href="#">ip-specific</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="">router</a></li>
            </ul>
        </div>
        <div class="col-md-10 col-md-offset-2 main">
            <div class="col-md-10"><h1 class="page-header">Topology</h1><label>complete filter, press query to view result.</label></div>
            <div class="col-md-10">
                <div class="form-inline form-group">
                    <select class="form-control">
                        <option>CAIDA</option>
                        <option>iPlane</option>
                        <option>looking glass</option>
                        <option>HITNISL</option>
                    </select>

                    <input type="text" class="form-control" placeholder="time">
                    <input type="text" class="form-control" placeholder="node">
                    <button type="submit" class="form-control" id="query_btn">query</button>
                </div>
            </div>

            <div class="col-md-10">
                <h2 class="sub-header">Forced layout (simplified)</h2>
                <label>click to move nodes</label>
            </div>
            <div class="col-md-10 topo">
                    <svg></svg>
            </div>
            <div class="col-md-10">
                <h2 class="sub-header">Graphviz layout</h2>
                <label>click to move graph, use wheel to zoom.</label>
            </div>
            <div class="col-md-10 graphviz">
                <svg></svg>
            </div>
            <h2 class="col-md-10 sub-header">K-core layout</h2>
            <div class="col-md-10 kcore">
                <svg></svg>
            </div>
        </div>
    </div>
</div>

<script src="topo.js"></script>
</body>
</html>
