<html>
<head>
    <style type="text/css">
        .bar{
            display: inline-block;
            width: 20px;
            height: 75px;
            margin-right: 2px;
            background-color: teal;
        }

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


<div class="scatter"></div>

<script src="../bootstrap-3.3.6-dist/js/d3.min.js"></script>
<script type="application/javascript">
    var dataset = [5, 10 ,15, 20, 25];
    var container = d3.select("body");

    var width = 500;
    var height = 200;
    var svg = container.append("svg")
        .attr("width",width)
        .attr("height",height);

    svg.selectAll("circle")
        .data(dataset)
        .enter()
        .append("circle")
        .attr("cx",function(d, i){
            return (i*50) + 25;
        })
        .attr("cy",height/2)
        .attr("r",function(d){
            return d;
        });

    var bar_svg = container.append("svg")
        .attr("width",width)
        .attr("height",height);

    bar_svg.selectAll("rect")
        .data(dataset)
        .enter()
        .append("rect")
        .attr("width",20)
        .attr("height",function(d, i){
            return d;
        })
        .attr("x",function(d, i){
            return 25*i;
        })
        .attr("y",function(d,i){
            return height - d;
        });

    var sp_data = [
        [5, 20], [480, 90], [250, 50], [100, 33], [330, 95],
        [410, 12], [475, 44], [25, 67], [85, 21], [220, 88]
    ];

    var div_container = d3.select(".scatter");
    var scatter_svg = div_container.append("svg")
        .attr("width",width)
        .attr("height",height);


    var font_size = 12;
    var padding = 30;
    var x_max = d3.max(sp_data, function(d) {return d[0];});
    var y_max = d3.max(sp_data, function(d){return d[1];});

    var sx = d3.scale.linear()
        .domain([0,  x_max ])
        .range([padding, width-padding]);
    var sy = d3.scale.linear()
        .domain([0, y_max ])
        .range([height-padding, padding]);

    scatter_svg.selectAll("circle")
        .data(sp_data)
        .enter()
        .append("circle")
        .attr("cx",function(d,i){
            return sx(d[0]);
        })
        .attr("cy",function(d,i){
            return sy(d[1]);
        })
        .attr("r",8);

    scatter_svg.selectAll("text")
        .data(sp_data)
        .enter()
        .append("text")
        .text(function(d,i){
            return i;
        })
        .attr("x",function(d,i){
            return sx(d[0]-font_size/4);
        })
        .attr("y",function(d,i){
            return sy(d[1]-font_size/4);
        })
        .attr("fill","white")
        .attr("font-size",font_size);

    var axis_svg = container.append("svg")
        .attr("width",width)
        .attr("height",height);

    xAxis = d3.svg.axis()
        .scale(sx)
        .orient("bottom");

    yAxis = d3.svg.axis()
        .scale(sy)
        .orient("left")
        .ticks(5);

    axis_svg.append("g")
        .attr("class","axis")
        .attr("transform","translate(0,"+(height-padding)+")")
        .call(xAxis);

    axis_svg.append("g")
        .attr("class","axis")
        .attr("transform","translate("+padding+","+"0)")
        .call(yAxis);

    axis_svg.selectAll("circle")
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

    axis_svg.selectAll("text")
        .data(sp_data)
        .enter()
        .append("text")
        .text(function(d,i){
            return i;
        })
        .attr("x",function(d,i){
            return sx(d[0]);
        })
        .attr("y",function(d,i){
            return sy(d[1]);
        })
        .attr("fill","red")
        .attr("font-size",font_size);

</script>

</body>
</html>