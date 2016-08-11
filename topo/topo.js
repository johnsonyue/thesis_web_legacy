var height = 1200,
    width = 1200;

var topo_svg = d3.select(".topo svg")
    .attr("height",height)
    .attr("width",width);

var graphviz_svg = d3.select(".graphviz svg")
    .attr("height",height)
    .attr("width",width);

var xmlHttpRequest;
var xmlHttpRequest2;
var xmlHttpRequest3;

var query_btn = d3.select("#query_btn")
    .on("click",get_all_func);

function get_all_func(){
    get_topo_func();
    get_graphviz_func();
}

function get_topo_func(){
    var url = "get_json.php";
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
            .style("stroke", "#ccc")
            .style("stroke-width", 1);

        var color_func = d3.scale.category10();
        var radius = 4;

        topo_svg.selectAll("circle")
            .remove();
        var nodes = topo_svg.selectAll("circle")
            .data(dataset.nodes)
            .enter()
            .append("circle")
            .attr("fill", function (d, i) {
                return color_func(i);
            })
            .attr("r", radius)
            .call(force_layout.drag);

        force_layout.on("tick", function () {
            edges.attr("x1", function (d) {
                return d.source.x
            })
                .attr("y1", function (d) {
                    return d.source.y
                })
                .attr("x2", function (d) {
                    return d.target.x
                })
                .attr("y2", function (d) {
                    return d.target.y
                });

            nodes.attr("cx", function (d) {
                return d.x
            })
                .attr("cy", function (d) {
                    return d.y
                });
        })
    }
}

function get_graphviz_func(){
    var url = "get_json.php";
    var post_str = "type=graphviz";

    xmlHttpRequest2 = new XMLHttpRequest();
    xmlHttpRequest2.open("POST", url, true);
    xmlHttpRequest2.onreadystatechange = graphviz_ready;
    xmlHttpRequest2.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlHttpRequest2.send(post_str);
}

function graphviz_ready(){
    if(xmlHttpRequest2.readyState == 4 && xmlHttpRequest.status == 200) {
        var text = xmlHttpRequest2.responseText;
        var dataset = JSON.parse(text);

        var radius = 1;

        var top=dataset.nodes[0].pos[0], down=dataset.nodes[0].pos[0],
            left=dataset.nodes[0].pos[1], right=dataset.nodes[0].pos[1];

        dx = width/2-(left+right)/2;
        dy = height/2-(top+down)/2;

        for (var i=0; i < dataset.nodes.length; i++){
            if(dataset.nodes[i].pos[1] > top){
                top = dataset.nodes[i].pos[1];
            }
            if(dataset.nodes[i].pos[1] < down){
                down = dataset.nodes[i].pos[1];
            }
            if(dataset.nodes[i].pos[0] > right){
                right = dataset.nodes[i].pos[0];
            }
            if(dataset.nodes[i].pos[0] < left){
                left = dataset.nodes[i].pos[0];
            }
        }

        graphviz_svg.selectAll("circle")
            .remove();
        var nodes = graphviz_svg.selectAll("circle")
            .data(dataset.nodes)
            .enter()
            .append("circle")
            .attr("r", radius)
            .attr("cx",function(d){
                return d.pos[0];
            })
            .attr("cy", function(d){
                return d.pos[1];
            })
            .attr("transform", "translate(" + (width/2-(left+right)/2) + "," + (height/2-(top+down)/2) + ")");

        graphviz_svg.selectAll("line")
            .remove();
        var edges = graphviz_svg.selectAll("line")
            .data(dataset.edges)
            .enter()
            .append("line")
            .attr("x1",function(d){
                return dataset.nodes[d.source].pos[0];
            })
            .attr("y1",function(d){
                return dataset.nodes[d.source].pos[1];
            })
            .attr("x2",function(d){
                return dataset.nodes[d.target].pos[0];
            })
            .attr("y2",function(d){
                return dataset.nodes[d.target].pos[1];
            })
            .attr("transform", "translate(" + (width/2-(left+right)/2) + "," + (height/2-(top+down)/2) + ")");

        graphviz_svg
            .on("mousedown",mousedown)
            .on("mouseup",mouseup);
    }
}

// modified from http://bl.ocks.org/1392560
var m0,m1;
var dx,dy;
function mousedown() {
    m0 = [d3.event.pageX, d3.event.pageY];
}

function mouseup() {
    if (m0) {
        m1 = [d3.event.pageX, d3.event.pageY];
        refresh();
        m0 = null;
    }
}

function refresh(){
    var x = m1[0]-m0[0];
    var y = m1[1]-m0[1];

    dx = dx+x;
    dy = dy+y;

    graphviz_svg.selectAll("circle")
        .attr("transform", "translate(" + dx + "," + dy + ")");
    graphviz_svg.selectAll("line")
        .attr("transform", "translate(" + dx + "," + dy + ")");
}