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


        .land {
            fill: #999;
            stroke-opacity: 1;
        }

        .graticule {
            fill: none;
            stroke: black;
            stroke-width:.5;
            opacity:.2;
        }

        .labels {
            font: 8px sans-serif;
            fill: black;
            opacity: .5;

            display:none;
        }

        .noclicks { pointer-events:none; }

        .point {  opacity:.6; }

        .arcs {
            opacity:.1;
            stroke: gray;
            stroke-width: 3;
        }
        .flyers {
            stroke-width:1;
            opacity: .6;
            stroke: darkred;
        }
        .arc, .flyer {
            stroke-linejoin: round;
            fill:none;
        }
        .arc { }
        .flyer { }
        .flyer:hover { }
    </style>
</head>

<body>
<script src="bootstrap-3.3.6-dist/js/jquery.min.js"></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="bootstrap-3.3.6-dist/js/d3.min.js"></script>
<script src="bootstrap-3.3.6-dist/js/queue.v1.min.js"></script>
<script src="bootstrap-3.3.6-dist/js/topojson.v0.min.js"></script>

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
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button class="btn" id="topo_btn">Get Topology</button>
                        <input type="text">
                    </div>
                    <div class="panel-body"><div class="topo">
                            <svg></svg>
                        </div></div>
                    <div class="panel-footer" id="topo-footer">
                        <p>Hover to see more.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
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

<script type="application/javascript">
    var height = 500,
        width = 500;

    var topo_svg = d3.select(".topo svg")
        .attr("height",height)
        .attr("width",width);

    var get_topo_btn = d3.select("#topo_btn")
        .on("click", get_topo_func);

    var globe_svg = d3.select(".globe svg")
        .attr("height", height)
        .attr("width", width);

    var get_globe_btn = d3.select("#get_globe_btn")
        .on("click", get_globe_func);

    var map_width = width*2;
    var map_height = height*1.5;
    var map_svg = d3.select(".map svg")
        .attr("width", map_width)
        .attr("height", map_height);

    var get_map_btn = d3.select("#get_map_btn")
        .on("click", get_map_func);

    var xmlHttpRequest;

    function get_topo_func(){
        var url = "get_topo.php";
        var post_str = "type=topo";
        xmlHttpRequest = new XMLHttpRequest();
        xmlHttpRequest.open("POST", url, true);
        xmlHttpRequest.onreadystatechange = topo_ready;
        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xmlHttpRequest.send(post_str);
    }

    function topo_ready(){
        if(xmlHttpRequest.readyState == 4 && xmlHttpRequest.status == 200) {
            var text = xmlHttpRequest.responseText;
            var dataset = JSON.parse(text);

            var force_layout = d3.layout.force()
                .nodes(dataset.nodes)
                .links(dataset.edges)
                .size([width, height])
                .linkDistance([50])
                .charge([-100])
                .start();

            topo_svg.selectAll("line")
                .remove();
            var edges = topo_svg.selectAll("line")
                .data(dataset.edges)
                .enter()
                .append("line")
                .style("stroke","#ccc")
                .style("stroke-width",1);

            var color_func = d3.scale.category10();
            var radius = 4;

            topo_svg.selectAll("circle")
                .remove();
            var nodes = topo_svg.selectAll("circle")
                .data(dataset.nodes)
                .enter()
                .append("circle")
                .attr("fill",function(d, i){
                    return color_func(i);
                })
                .attr("r",radius)
                .on("mouseover",function(){
                    var d = d3.select(this).datum();
                    var html = d.lat+","+ d.lon;
                    d3.select("#topo-footer p").html(html);
                })
                .call(force_layout.drag);

            force_layout.on("tick",function(){
                edges.attr("x1",function(d){return d.source.x})
                    .attr("y1",function(d){return d.source.y})
                    .attr("x2",function(d){return d.target.x})
                    .attr("y2",function(d){return d.target.y});

                nodes.attr("cx",function(d){return d.x})
                    .attr("cy",function(d){return d.y});
            })
        }
    }

    //get globe.
    function get_globe_func(){
        var url = "get_topo.php";
        var post_str = "type=map";
        xmlHttpRequest = new XMLHttpRequest();
        xmlHttpRequest.open("POST", url, true);
        xmlHttpRequest.onreadystatechange = places_ready;
        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xmlHttpRequest.send(post_str);
    }

    var places;
    var world;
    function places_ready() {
        if(xmlHttpRequest.readyState == 4 && xmlHttpRequest.status == 200) {
            var text = xmlHttpRequest.responseText;
            places = JSON.parse(text);

            xmlHttpRequest = d3.json("./world-50m.json", world_ready);
        }
    }


    var container, svg, proj, sky, path, swoosh;
    function world_ready(error, json){
        if (error) return console.warn(error);
        world = json;
        container = d3.select(".globe");

        d3.select("#globe-panel")
            .on("mousemove", mousemove)
            .on("mouseup", mouseup)
            .on("mousedown", mousedown);

        svg = container.append("svg")
            .attr("width", width)
            .attr("height", height);

        proj = d3.geo.orthographic()
            .translate([width / 2, height / 2])
            .clipAngle(90)
            .scale(220);

        sky = d3.geo.orthographic()
            .translate([width / 2, height / 2])
            .clipAngle(90)
            .scale(300);

        container.select("svg")
            .remove();


        path = d3.geo.path().projection(proj).pointRadius(2);

        swoosh = d3.svg.line()
            .x(function(d) { return d[0] })
            .y(function(d) { return d[1] })
            .interpolate("cardinal")
            .tension(.0);


        var ocean_fill = svg.append("defs").append("radialGradient")
            .attr("id", "ocean_fill")
            .attr("cx", "75%")
            .attr("cy", "25%");
        ocean_fill.append("stop").attr("offset", "5%").attr("stop-color", "#fff");
        ocean_fill.append("stop").attr("offset", "100%").attr("stop-color", "#ababab");

        var globe_highlight = svg.append("defs").append("radialGradient")
            .attr("id", "globe_highlight")
            .attr("cx", "75%")
            .attr("cy", "25%");
        globe_highlight.append("stop")
            .attr("offset", "5%").attr("stop-color", "#ffd")
            .attr("stop-opacity","0.6");
        globe_highlight.append("stop")
            .attr("offset", "100%").attr("stop-color", "#ba9")
            .attr("stop-opacity","0.2");

        var globe_shading = svg.append("defs").append("radialGradient")
            .attr("id", "globe_shading")
            .attr("cx", "55%")
            .attr("cy", "45%");
        globe_shading.append("stop")
            .attr("offset","30%").attr("stop-color", "#fff")
            .attr("stop-opacity","0")
        globe_shading.append("stop")
            .attr("offset","100%").attr("stop-color", "#505962")
            .attr("stop-opacity","0.3")

        svg.append("circle")
            .attr("cx", width / 2).attr("cy", height / 2)
            .attr("r", proj.scale())
            .attr("class", "noclicks")
            .style("fill", "url(#ocean_fill)");

        svg.append("path")
            .datum(topojson.object(world, world.objects.land))
            .attr("class", "land noclicks")
            .attr("d", path);

        svg.append("circle")
            .attr("cx", width / 2).attr("cy", height / 2)
            .attr("r", proj.scale())
            .attr("class","noclicks")
            .style("fill", "url(#globe_highlight)");

        svg.append("circle")
            .attr("cx", width / 2).attr("cy", height / 2)
            .attr("r", proj.scale())
            .attr("class","noclicks")
            .style("fill", "url(#globe_shading)");

        var nodes = [],
            links = [];
        //convert places to designated format.
        var node_list = places.nodes;
        node_list.forEach(function(e, i, a){
            var feature = { "type": "Feature", "geometry": { "type": "Point", "coordinates": [e.lon,e.lat] }};
            nodes.push(feature);
        });

        places.edges.forEach(function(e, i, a){
            var src = [node_list[e.source].lon, node_list[e.source].lat];
            var tgt = [node_list[e.target].lon, node_list[e.target].lat];
            var feature = { "type": "Feature", "geometry": { "type": "LineString", "coordinates": [src, tgt] }};
            links.push(feature);
        });

        svg.append("g").attr("class","points")
            .selectAll("path").data(nodes)
            .enter().append("path")
            .attr("class", "point")
            .attr("d", path)
            .on("mouseover",function(){
                var d = d3.select(this).datum();
                var html = d.geometry.coordinates[0]+","+d.geometry.coordinates[1];
                d3.select("#globe-footer p")
                    .html(html);
            });

        svg.append("g").attr("class","arcs")
            .selectAll("path").data(links)
            .enter().append("path")
            .attr("class","arc")
            .attr("d",path);

        svg.append("g").attr("class","flyers")
            .selectAll("path").data(links)
            .enter().append("path")
            .attr("class","flyer")
            .attr("d", function(d) { return swoosh(flying_arc(d)) });

        refresh();
    }

    function flying_arc(d) {
        var source = d.geometry.coordinates[0],
            target = d.geometry.coordinates[1];

        var mid = location_along_arc(source, target, .5);
        return [ proj(source), sky(mid), proj(target) ];
    }

    function location_along_arc(start, end, loc) {
        var interpolator = d3.geo.interpolate(start,end);
        return interpolator(loc);
    }

    function refresh() {
        svg.selectAll(".land").attr("d", path);
        svg.selectAll(".point").attr("d", path);
        svg.selectAll(".arc").attr("d", path)
            .attr("opacity", function(d) {
                return fade_at_edge(d)
            });

        svg.selectAll(".flyer")
            .attr("d", function(d) { return swoosh(flying_arc(d)) })
            .attr("opacity", function(d) {
                return fade_at_edge(d)
            });
    }

    function fade_at_edge(d) {
        var centerPos = proj.invert([width/2,height/2]),
            arc = d3.geo.greatArc(),
            start, end;
        // function is called on 2 different data structures..
        if (d.source) {
            start = d.source,
                end = d.target;
        }
        else {
            start = d.geometry.coordinates[0];
            end = d.geometry.coordinates[1];
        }

        var start_dist = 1.57 - arc.distance({source: start, target: centerPos}),
            end_dist = 1.57 - arc.distance({source: end, target: centerPos});

        var fade = d3.scale.linear().domain([-.1,0]).range([0,.1])
        var dist = start_dist < end_dist ? start_dist : end_dist;

        return fade(dist);
    }

    // modified from http://bl.ocks.org/1392560
    var m0, o0;
    function mousedown() {
        m0 = [d3.event.pageX, d3.event.pageY];
        o0 = proj.rotate();
        d3.event.preventDefault();
    }
    function mousemove() {
        if (m0) {
            var m1 = [d3.event.pageX, d3.event.pageY]
                , o1 = [o0[0] + (m1[0] - m0[0]) / 6, o0[1] + (m0[1] - m1[1]) / 6];
            o1[1] = o1[1] > 90  ? 90  :
                o1[1] < -90 ? -90 :
                    o1[1];
            proj.rotate(o1);
            sky.rotate(o1);
            refresh();
        }
    }
    function mouseup() {
        if (m0) {
            mousemove();
            m0 = null;
        }
    }

    //get globe.
    function get_map_func(){
        var url = "get_topo.php";
        var post_str = "type=map";
        xmlHttpRequest = new XMLHttpRequest();
        xmlHttpRequest.open("POST", url, true);
        xmlHttpRequest.onreadystatechange = map_places_ready;
        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xmlHttpRequest.send(post_str);
    }

    var map_places;
    var map_world;
    function map_places_ready() {
        if(xmlHttpRequest.readyState == 4 && xmlHttpRequest.status == 200) {
            var text = xmlHttpRequest.responseText;
            map_places = JSON.parse(text);

            xmlHttpRequest = d3.json("./world-50m.json", map_world_ready);
        }
    }

    function map_world_ready(error, json) {
        if (error) return console.warn(error);
        map_world = json;

        var projection = d3.geo.mercator()
            .scale(153)
            .translate([map_width / 2, map_height / 2])
            .precision(.1);

        var map_path = d3.geo.path()
            .projection(projection);

        var arc = d3.geo.greatArc()
            .source(function(d) { return d.source; })
            .target(function(d) { return d.target; });

        var nodes = [],
            links = [],
            links_by_origin = {},
            degree = {};

        //convert places to designated format.
        var node_list = map_places.nodes;
        node_list.forEach(function(e, i, a){
            var feature = { "type": "Feature", "properties": {"index": i}, "geometry": { "type": "Point", "coordinates": [e.lon,e.lat] }};
            nodes.push(feature);
        });

        map_svg.select("#frame")
            .attr("width", map_width)
            .attr("height", map_height);

        map_places.edges.forEach(function(e, i, a){
            var src = [node_list[e.source].lon, node_list[e.source].lat];
            var tgt = [node_list[e.target].lon, node_list[e.target].lat];
            var feature = { "type": "Feature", "geometry": { "type": "LineString", "coordinates": [src, tgt] }};
            links.push(feature);

            var org = e.source,
                dst = e.target;

            var l = links_by_origin[org] || (links_by_origin[org] =[]);
            l.push({source: org, target: dst});
            degree[org] = (degree[org] || 0) + 1;
            degree[dst] = (degree[dst] || 0) + 1;
        });

        map_svg.append("path")
            .datum(topojson.object(map_world, map_world.objects.land))
            .attr("class", "land noclicks")
            .attr("d", map_path);


        map_svg.append("g").attr("class","arcs").selectAll("path").data(links)
            .enter().append("path")
            .attr("class","arc")
            .attr("d",map_path);

        var g = map_svg.append("g").attr("class","circles")
            .selectAll("path").data(nodes)
            .enter().append("path")
            .attr("class", "circle")
            .attr("d", map_path)
            .on("mouseover",function(d){
                var html = d.geometry.coordinates[0]+","+d.geometry.coordinates[1];
                d3.select("#map-footer p")
                    .html(html);
            });
    }
</script>

</body>
</html>
