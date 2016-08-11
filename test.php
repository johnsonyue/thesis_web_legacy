<html>
<head>
</head>
<body>
<script src="bootstrap-3.3.6-dist/js/d3.min.js"></script>
<script type="application/javascript">
    var container = d3.select("body");

    var width = 500;
    var height = 500;
    var padding = 30;
    var force_svg = container.append("svg")
        .attr("width",width)
        .attr("height",height);

    var dataset = {
        nodes: [
            { name: "Adam" },
            { name: "Bob" },
            { name: "Carrie" },
            { name: "Donovan" },
            { name: "Edward" },
            { name: "Felicity" },
            { name: "George" },
            { name: "Hannah" },
            { name: "Iris" },
            { name: "Jerry" }
        ],
        edges: [
            { source: 0, target: 1 },
            { source: 0, target: 2 },
            { source: 0, target: 3 },
            { source: 0, target: 4 },
            { source: 1, target: 5 },
            { source: 2, target: 5 },
            { source: 2, target: 5 },
            { source: 3, target: 4 },
            { source: 5, target: 8 },
            { source: 5, target: 9 },
            { source: 6, target: 7 },
            { source: 7, target: 8 },
            { source: 8, target: 9 }
        ]
    };

    var force_layout = d3.layout.force()
        .nodes(dataset.nodes)
        .links(dataset.edges)
        .size([width, height])
        .linkDistance([50])
        .charge([-100])
        .start();

    var edges = force_svg.selectAll("line")
        .data(dataset.edges)
        .enter()
        .append("line")
        .style("stroke","#ccc")
        .style("stroke-width",1);

    var color_func = d3.scale.category10();
    var radius = 10;
    var nodes = force_svg.selectAll("circle")
        .data(dataset.nodes)
        .enter()
        .append("circle")
        .attr("fill",function(d, i){
            return color_func(i);
        })
        .attr("r",radius)
        .call(force_layout.drag);

    force_layout.on("tick",function(){
        edges.attr("x1",function(d){return d.source.x})
            .attr("y1",function(d){return d.source.y})
            .attr("x2",function(d){return d.target.x})
            .attr("y2",function(d){return d.target.y});

        nodes.attr("cx",function(d){return d.x})
            .attr("cy",function(d){return d.y});
    })

    var map_svg = container.append("svg")
        .attr("width",width)
        .attr("height",height);

    var mercator = d3.geo.projection(function(lamda, phi) {
            return [
                lamda,
                Math.log(Math.tan(Math.PI/4 + phi/2))
            ];
        })
        .center([107, 31])
        .scale(300)
        .translate([width/2, height/2]);

    var path_func = d3.geo.path()
        .projection(mercator);

    d3.json("china.geojson",function(json){
        map_svg.selectAll("path")
            .data(json.features)
            .enter()
            .append("path")
            .attr("fill",function(d,i){
                return color_func(i);
            })
            .attr("d",path_func);
    });

</script>
</body>
</html>