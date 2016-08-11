var height = 600,
    width = 800;

var path_height=1200,
    path_width=1200;

var degree_svg = d3.select(".degree svg")
    .attr("height",height)
    .attr("width",width);

var rtt_svg = d3.select(".rtt svg")
    .attr("height",height)
    .attr("width",width);

var path_svg = d3.select(".path svg")
    .attr("height",path_height)
    .attr("width",path_width);

var xmlHttpRequest;
var xmlHttpRequest2;
var xmlHttpRequest3;

var query_btn = d3.select("#query_btn")
    .on("click",get_all_func);

function get_all_func(){
    get_degree_func();
    get_path_func();
}

function get_degree_func(){
    var url = "get_json.php";
    var post_str = "type=degree";

    xmlHttpRequest = new XMLHttpRequest();
    xmlHttpRequest.open("POST", url, true);
    xmlHttpRequest.onreadystatechange = degree_ready;
    xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlHttpRequest.send(post_str);
}

var degree_dist, max_degree, total, degree_sum;
var r0= 2, r1=3;
var padding = 30;
var sx, sy, xAxis, yAxis;
var line_func;

function degree_ready(){
    if(xmlHttpRequest.readyState == 4 && xmlHttpRequest.status == 200) {
        var text = xmlHttpRequest.responseText;
        var dataset = JSON.parse(text);

        degree_dist = new Array(1000);
        degree_sum = new Array(1000);
        max_degree = 0;
        for (var i=0; i<1000; i++){
            degree_dist[i] = 0;
        }
        for (i=0; i<dataset.nodes.length; i++){
            if(dataset.nodes[i].degree > max_degree){
                max_degree = dataset.nodes[i].degree;
            }
            degree_dist[dataset.nodes[i].degree]++;
        }
        total = dataset.nodes.length;
        var sum = 0;
        for(i=0; i<=max_degree;i++){
            sum += degree_dist[i];
            degree_sum[i] = sum;
        }

        clear_degree();
        create_log();

        d3.selectAll("input").on("change", change);
        d3.select("input[value=\"log\"]").property("checked", true);
    }
}

function change(){
    if(this.value == "log" && this.checked == true){
        draw_log();
    }
    else if(this.value == "dist" && this.checked == true){
        draw_dist();
    }
    else if(this.value == "cdf" && this.checked == true){
        draw_cdf();
    }
}

function clear_degree(){
    degree_svg.selectAll("path")
        .remove();
    degree_svg.selectAll("g")
        .remove();
    degree_svg.selectAll("circle")
        .remove();
}

function create_log(){
    sx = d3.scale.log()
        .base(Math.E)
        .range([padding*2,width-padding])
        .domain([1,max_degree]);

    sy = d3.scale.log()
        .base(Math.E)
        .range([padding,height-padding])
        .domain([d3.max(degree_dist),1]);

    xAxis = d3.svg.axis()
        .scale(sx)
        .orient("bottom")
        .ticks(20);

    yAxis = d3.svg.axis()
        .scale(sy)
        .orient("left")
        .ticks(20);

    line_func = d3.svg.line()
        .x(function(d,i){
            return sx(i+1);
        })
        .y(function(d){
            return sy(d+1);
        })
        .interpolate("monotone");

    degree_svg
        .append("path")
        .attr("class","line")
        .attr("d",line_func(degree_dist.slice(0,max_degree)));

    degree_svg.append("g")
        .attr("class","x axis")
        .attr("transform","translate(0,"+(height-padding)+")")
        .call(xAxis);

    degree_svg.append("g")
        .attr("class","y axis")
        .attr("transform","translate("+padding*2+","+"0)")
        .call(yAxis);

    degree_svg.selectAll("circle")
        .data(degree_dist.slice(0,max_degree))
        .enter()
        .append("circle")
        .attr("r",r0)
        .attr("cx",function(d,i){
            return sx(i+1);
        })
        .attr("cy",function(d){
            return sy(d+1);
        });
}

function draw_log(){
    sx = d3.scale.log()
        .base(Math.E)
        .range([padding*2,width-padding])
        .domain([1,max_degree]);

    sy = d3.scale.log()
        .base(Math.E)
        .range([padding,height-padding])
        .domain([d3.max(degree_dist),1]);

    xAxis = d3.svg.axis()
        .scale(sx)
        .orient("bottom")
        .ticks(20);

    yAxis = d3.svg.axis()
        .scale(sy)
        .orient("left")
        .ticks(20);

    line_func = d3.svg.line()
        .x(function(d,i){
            return sx(i+1);
        })
        .y(function(d){
            return sy(d+1);
        })
        .interpolate("monotone");

    degree_svg
        .select(".line")
        .transition()
        .duration(1000)
        .attr("d",line_func(degree_dist.slice(0,max_degree)));

    degree_svg.select(".x.axis")
        .transition()
        .duration(1000)
        .call(xAxis);

    degree_svg.select(".y.axis")
        .transition()
        .duration(1000)
        .call(yAxis);

    degree_svg.selectAll("circle")
        .data(degree_dist.slice(0,max_degree))
        .transition()
        .duration(1000)
        .attr("r",r0)
        .attr("cx",function(d,i){
            return sx(i+1);
        })
        .attr("cy",function(d){
            return sy(d+1);
        });
}

function draw_dist(){
    sx = d3.scale.linear()
        .range([padding*2,width-padding])
        .domain([0,max_degree]);

    sy = d3.scale.linear()
        .range([padding,height-padding])
        .domain([d3.max(degree_dist),0]);

    xAxis = d3.svg.axis()
        .scale(sx)
        .orient("bottom")
        .ticks(20);

    yAxis = d3.svg.axis()
        .scale(sy)
        .orient("left")
        .ticks(20);

    degree_svg.select(".x.axis")
        .transition()
        .duration(1000)
        .call(xAxis);

    degree_svg.select(".y.axis")
        .transition()
        .duration(1000)
        .call(yAxis);

    line_func = d3.svg.line()
        .x(function(d,i){
            return sx(i);
        })
        .y(function(d){
            return sy(d);
        })
        .interpolate("monotone");

    degree_svg
        .select(".line")
        .transition()
        .duration(1000)
        .attr("d",line_func(degree_dist.slice(0,max_degree)));

    degree_svg.selectAll("circle")
        .data(degree_dist.slice(0,max_degree))
        .transition()
        .duration(1000)
        .attr("r",r0)
        .attr("cx",function(d,i){
            return sx(i)
        })
        .attr("cy",function(d){
            return sy(d);
        });
}

function draw_cdf(){
    var temp_sy = d3.scale.linear()
        .range([0,1])
        .domain([0, total]);

    sx = d3.scale.linear()
        .range([padding*2,width-padding])
        .domain([0,max_degree]);

    sy = d3.scale.linear()
        .range([padding,height-padding])
        .domain([1,0]);

    xAxis = d3.svg.axis()
        .scale(sx)
        .orient("bottom")
        .ticks(20);

    yAxis = d3.svg.axis()
        .scale(sy)
        .orient("left")
        .ticks(20);

    degree_svg.select(".x.axis")
        .transition()
        .duration(1000)
        .call(xAxis);

    degree_svg.select(".y.axis")
        .transition()
        .duration(1000)
        .call(yAxis);

    line_func = d3.svg.line()
        .x(function(d,i){
            return sx(i);
        })
        .y(function(d){
            return sy(temp_sy(d));
        })
        .interpolate("monotone");

    degree_svg
        .select(".line")
        .transition()
        .duration(1000)
        .attr("d",line_func(degree_sum.slice(0,max_degree)));

    degree_svg.selectAll("circle")
        .data(degree_sum.slice(0,max_degree))
        .transition()
        .duration(1000)
        .attr("r",r0)
        .attr("cx",function(d,i){
            return sx(i)
        })
        .attr("cy",function(d){
            return sy(temp_sy(d));
        });
}

function get_path_func(){
    var url = "get_json.php";
    var post_str = "type=path";

    xmlHttpRequest3 = new XMLHttpRequest();
    xmlHttpRequest3.open("POST", url, true);
    xmlHttpRequest3.onreadystatechange = path_ready;
    xmlHttpRequest3.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlHttpRequest3.send(post_str);
}

var path_sx = d3.scale.linear()
    .domain([0, path_width])
    .range([0, path_width]);

var path_sy = d3.scale.linear()
    .domain([0, path_height])
    .range([0, path_height]);

function path_ready(){
    if(xmlHttpRequest3.readyState == 4 && xmlHttpRequest3.status == 200) {
        var text = xmlHttpRequest3.responseText;
        var dataset = JSON.parse(text);

        var color = d3.scale.category20c();

        var partition = d3.layout.partition()
            .sort(null)
            .size([path_width, path_height])
            .value(function (d) {
                //return d.num;
                return 1;
            });

        var nodes = partition.nodes(dataset);

        path_svg.selectAll("rect")
            .remove();
        path_svg.selectAll("rect")
            .data(nodes)
            .enter()
            .append("rect")
            .attr("x",function(d){
                return d.x;
            })
            .attr("y",function(d){
                return d.y;
            })
            .attr("width",function(d){
                return d.dx;
            })
            .attr("height",function(d){
                return d.dy;
            })
            .style("stroke","#fff")
            .style("fill",function(d){
                return color((d.children ? d : d.parent).name);
            })
            .on("click",clicked);
    }
}

function clicked(d){
    path_sx.domain([d.x, d.x+d.dx]);
    path_sy.domain([d.y, path_height]).range([d.y ? d.dy*0.3 : 0 , path_height]);

    path_svg.selectAll("rect")
        .attr("x",function(d){
            return path_sx(d.x);
        })
        .attr("y",function(d){
            return path_sy(d.y);
        })
        .attr("width",function(d){
            return path_sx(d.x+d.dx)-path_sx(d.x);
        })
        .attr("height",function(d){
            return path_sy(d.y+d.dy)-path_sy(d.y);
        });
}