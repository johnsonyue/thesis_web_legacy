<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../bootstrap-3.3.6-dist/css/dashboard.css" rel="stylesheet">
    <link href="../bootstrap-3.3.6-dist/css/flag-icon-css/css/flag-icon.css" rel="stylesheet">
    <link href="backbone.css" rel="stylesheet">
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
                <li><a href="../topo/topo.php">topology</a></li>
                <li><a href="../stats/stats.php">statistics</a></li>
                <li><a href="../map/map.php">map</a></li>
                <li><a href="#">ip-specific</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="../border/border.php">border</a></li>
                <li class="active"><a href="../backbone/backbone.php">backbone</a></li>
                <li><a href="">router</a></li>
            </ul>
        </div>
        <div class="col-md-10 col-md-offset-2 main">
            <div class="col-md-10"><h1 class="page-header">Border</h1><label>complete filter, press query to view result.</label></div>
            <div class="col-md-10">
                <div class="form-inline form-group">
                    <select class="form-control">
                        <option>CAIDA</option>
                        <option>iPlane</option>
                        <option>looking glass</option>
                        <option>HITNISL</option>
                    </select>

                    <input type="text" class="form-control" placeholder="time">
                    <button type="submit" class="form-control" id="query_btn">query</button>
                </div>
            </div>

            <div class="col-md-10">
                <h2 class="sub-header">table</h2>
                <label>fill in ip to filter results, click on header items to sort</label>
            </div>
            <div class="col-md-10">
                <div class="form-inline form-group">
                    <input type="text" class="form-control" placeholder="ip address">
                    <input type="text" class="form-control" placeholder="country">
                    <button type="submit" class="form-control" id="query_btn">filter</button>

                    <button type="submit" class="form-control pull-right" id="go_btn">go</button>
                    <input type="text" class="form-control pull-right" placeholder="page">
                </div>
            </div>

            <div class="col-md-10 topo">
                <table class="table table-bordered table-hover col-md-10" id="border_table">
                    <thead>
                    <th>#</th>
                    <th>icon</th>
                    <th><a style=cursor:pointer>ip<span class="glyphicon glyphicon-menu-down"></span></a></th>
                    <th>cc</th>
                    <th><a style=cursor:pointer>as<span class="glyphicon glyphicon-menu-down"></span></a></th>
                    <th>ascc</th>
                    <th>czdb</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>0</td>
                        <td><span class="flag-icon flag-icon-cn"></span></td>
                        <td>114.114.114.114</td>
                        <td>CN</td>
                        <td>4132</td>
                        <td>CN</td>
                        <td>黑龙江省哈尔滨市哈尔滨工业大学</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <nav class="col-md-10">
                <ul class="pagination" id="pages">
                    <li id="prev">
                        <a aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="active"><a>1</a></li>
                    <li id="next">
                        <a aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script src="backbone.js"></script>
</body>
</html>
