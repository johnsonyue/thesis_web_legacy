<html>
<head>
    <script type="application/javascript">
        function loadXMLDoc(){
            var index;
            index = document.getElementById("index").value;

            var xmlhttp;
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                    document.getElementById("hint").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","./task.php?index="+index,true);
            xmlhttp.send();
        }
    </script>
</head>

<body>
<div id="hint"><h3>Click to change content.</h3></div>
index: <input type="text" id="index"/>
<button type="button" onclick="loadXMLDoc()">Change Content</button>
</body>
</html>