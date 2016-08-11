
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap-3.3.6-dist/css/dashboard.css" rel="stylesheet">
    <style type="text/css">
        .axis path,
        .axis line{
            fill: none;
            stroke: black;
            shape-rendering: crispEdges;
        }
        .axis text{
            font-family: san-serif;
            font-size: 11px;
        }

    </style>
</head>

<body>
<script src="bootstrap-3.3.6-dist/js/jquery.min.js"></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="bootstrap-3.3.6-dist/js/d3.min.js"></script>

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
            <form class="navbar-form navbar-left" method="post">
                <select class="form-control">
                    <option>1</option>
                    <option>2</option>
                </select>
                <select class="form-control">
                    <option>1</option>
                    <option>2</option>
                </select>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn"><button type="submit" class="form-control">Search</button></span>
                </div>
            </form>
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
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Analytics</a></li>
                <li><a href="#">Export</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="">Nav item</a></li>
                <li><a href="">Nav item again</a></li>
                <li><a href="">One more nav</a></li>
                <li><a href="">Another nav item</a></li>
                <li><a href="">More navigation</a></li>
            </ul>
        </div>
        <div class="col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Dashboard</h1>
            <h2 class="sub-header">Section title</h2>
            <div class="scatter"></div>
            <div class="barchart"></div>
            <div class="ordinal"></div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1,001</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td>dolor</td>
                        <td>sit</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    var container = d3.selectAll(".scatter");
    var width = 500;
    var height = 200;
    var padding  = 30;
    var font_size = 12;

    var sp_data = [
        [5, 20], [480, 90], [250, 50], [100, 33], [330, 95],
        [410, 12], [475, 44], [25, 67], [85, 21], [220, 88]
    ];
    var sx = d3.scale.linear()
        .domain([0,  d3.max(sp_data, function(d) {return d[0];}) ])
        .range([padding, width-padding]);
    var sy = d3.scale.linear()
        .domain([0, d3.max(sp_data, function(d) {return d[1];}) ])
        .range([height-padding, padding]);

    var svg = container.append("svg")
        .attr("width",width)
        .attr("height",height);

    svg.selectAll("circle")
        .data(sp_data)
        .enter()
        .append("circle")
        .attr("cx",function(d,i){
            return sx(d[0]);
        })
        .attr("cy",function(d,i){
            return sy(d[1]);
        })
        .attr("r",4);
    svg.selectAll("text")
        .data(sp_data)
        .enter()
        .append("text")
        .text(function(d,i){
            return i+" : ("+d[0]+", "+d[1]+")";
        })
        .attr("x",function(d,i){
            return sx(d[0]);
        })
        .attr("y",function(d,i){
            return sy(d[1]);
        })
        .attr("fill","red")
        .attr("font-size",font_size);


    var xAxis = d3.svg.axis()
        .scale(sx)
        .orient("bottom");

    var yAxis = d3.svg.axis()
        .scale(sy)
        .orient("left")
        .ticks(5);

    svg.append("g")
        .attr("class","axis")
        .attr("transform","translate(0,"+(height-padding)+")")
        .call(xAxis);

    svg.append("g")
        .attr("class","axis")
        .attr("transform","translate("+padding+","+"0)")
        .call(yAxis);

    var dataset = [ 5, 10, 13, 19, 21, 25, 22, 18, 15, 13, 11, 12, 15, 20, 18, 17, 16, 18, 23, 25 ];

    var bar_sy = d3.scale.linear()
        .domain(d3.extent(dataset))
        .range([ padding, height-padding ]);
/*
    var bar_width = (width - padding*2)/dataset.length;

    var bar_container = d3.select(".barchart");
    bar_svg = bar_container.append("svg")
        .attr("width",width)
        .attr("height",height);

    bar_svg.selectAll("rect")
        .data(dataset)
        .enter()
        .append("rect")
        .attr("width", bar_width*0.95)
        .attr("height",function(d, i){
            return bar_sy(d);
        })
        .attr("x",function(d, i){
            return padding+bar_width*i;
        })
        .attr("y",function(d, i){
            return height-padding-bar_sy(d);
        })
        .attr("fill",function(d, i){
            return "rgb(0, 0, " + (d*10) + ")";
        });

    bar_svg.selectAll("text")
        .data(dataset)
        .enter()
        .append("text")
        .attr("font-size",font_size)
        .attr("x",function(d, i){
            return padding+bar_width*i+font_size/4;
        })
        .attr("y",function(d, i){
            return height-padding-bar_sy(d)+font_size;
        })
        .text(function(d, i){
            return d;
        })
        .attr("fill","white");
*/
    
    ord_container = d3.select(".ordinal");

    ord_svg = ord_container.append("svg")
        .attr("width",width)
        .attr("height",height);

    var ord_sx = d3.scale.ordinal()
        .domain(d3.range(dataset.length))
        .rangeBands([padding, width-padding], 0.05);

    ord_svg.selectAll("rect")
        .data(dataset)
        .enter()
        .append("rect")
        .attr("width", ord_sx.rangeBand())
        .attr("height",function(d, i){
            return bar_sy(d);
        })
        .attr("x",function(d, i){
            return ord_sx(i);
        })
        .attr("y",function(d, i){
            return height-padding-bar_sy(d);
        })
        .attr("fill",function(d, i){
            return "rgb(0, 0, " + (d*10) + ")";
        });



</script>

</body>
</html>
