<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../bootstrap-3.3.6-dist/css/dashboard.css" rel="stylesheet">
    <link href="map.css" rel="stylesheet">
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
                <li><a href="../topo/topo.php">topology</a></li>
                <li><a href="../stats/stats.php">statistics</a></li>
                <li class="active"><a href="#">map</a></li>
                <li><a href="#">ip-specific</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="../border/border.php">border</a></li>
                <li><a href="../backbone/backbone.php">backbone</a></li>
                <li><a href="">router</a></li>
            </ul>
        </div>
        <div class="col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Map</h1>
            <h2 class="sub-header">globe view</h2>

            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button class="btn" id="get_globe_btn">Get Globe</button>
                        <input type="text">
                    </div>
                    <div class="panel-body" id="globe-panel"><div class="globe">
                            <svg></svg>
                        </div></div>
                    <div class="panel-footer" id="globe-footer">
                        <p>Hover to see more.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button class="btn" id="get_map_btn">Get Map</button>
                        <input type="text">
                    </div>
                    <div class="panel-body" id="globe-panel"><div class="map">
                            <svg>
                                <rect id="frame" x="0" y="0" style="fill:blue; stroke:black; stroke-width:1; fill-opacity:0.1; stroke-opacity:0.9"></rect>
                            </svg>
                        </div></div>
                    <div class="panel-footer" id="map-footer">
                        <p>Hover to see more.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="map.js"></script>

</body>
</html>
