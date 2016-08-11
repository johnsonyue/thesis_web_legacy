<html>
<head>

</head>

<body>
<script src="../bootstrap-3.3.6-dist/js/d3.min.js"></script>
<script>
    var margin = {top: 20, right: 20, bottom: 30, left: 50};
    var width = document.body.clientWidth - margin.left - margin.right;
    var height = 500 - margin.top - margin.bottom;

    var container = d3.select("body")
        .append('svg')
        .attr('width', width+margin.left+margin.right)
        .attr('height',height+margin.top+margin.bottom);

    var svg = container.append("g")
        .attr('class', 'content')
        .attr('transform', 'translate('+margin.left+','+margin.top+')');
    var data = Array.apply(0,Array(31)).map(function(item,i){
        i++;
        return {x: i, y:parseInt(Math.random()*100)};
    });
    var x = d3.scale.linear()
        .domain(d3.extent(data, function(d){return d.x;}));
    var y = d3.scale.linear()
        .domain([0,d3.max(data, function(d){return d.y;})]);

    var xAxis = d3.svg.axis()
        .scale(x)
        .orient('bottom')
        .ticks(30);
    var yAxis = d3.svg.axis()
        .scale(y)
        .orient('left')
        .ticks(10);

    svg.append('g')
        .attr('class','x axis')
        .attr('transform', 'translate( 0,'+height+')')
        .call(xAxis);

    svg.append('g')
        .attr('class','y axis')
        .call(yAxis);
</script>
</body>
</html>