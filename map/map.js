var height = 1000,
    width = 1000;

var globe_svg = d3.select(".globe svg")
    .attr("height", height)
    .attr("width", width);

var get_globe_btn = d3.select("#get_globe_btn")
    .on("click", get_globe_func);

var map_width = 1400;
var map_height = 1200;
var map_svg = d3.select(".map svg")
    .attr("width", map_width)
    .attr("height", map_height);

var get_map_btn = d3.select("#get_map_btn")
    .on("click", get_map_func);

var xmlHttpRequest;

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
        .scale(400);

    sky = d3.geo.orthographic()
        .translate([width / 2, height / 2])
        .clipAngle(90)
        .scale(500);

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
        .scale(200)
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


    map_svg.append("g").attr("class","map_arcs").selectAll("path").data(links)
        .enter().append("path")
        .attr("class","arc")
        .attr("d",map_path)
        .style("stroke","gray");

    var g = map_svg.append("g").attr("class","circles")
        .selectAll("path").data(nodes)
        .enter().append("circle")
        .attr("cx", function(d){
            return projection(d.geometry.coordinates)[0];
        })
        .attr("cy",function(d){
            return projection(d.geometry.coordinates)[1];
        })
        .attr("r", 1)
        .on("mouseover",function(d){
            var html = d.geometry.coordinates[0]+","+d.geometry.coordinates[1];
            d3.select("#map-footer p")
                .html(html);
            highlight(d);
        });

    function highlight(point){
        map_svg.selectAll(".map_arcs path")
            .filter(function(d){
                return (d.geometry.coordinates[0][0] == point.geometry.coordinates[0] && d.geometry.coordinates[0][1] == point.geometry.coordinates[1]) || (d.geometry.coordinates[1][0] == point.geometry.coordinates[0] && d.geometry.coordinates[1][1] == point.geometry.coordinates[1]);
                })
            .style("stroke", "red")
            .style("stroke-width",5)
            .style("opacity", 50);
    }
}