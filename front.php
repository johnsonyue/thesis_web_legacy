<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap-3.3.6-dist/css/dashboard.css" rel="stylesheet">
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
                    <option>CAIDA</option>
                    <option>iPlane</option>
                    <option>TRLG</option>
                    <option>HITNISL</option>
                </select>
                <select class="form-control">
                    <option>topology</option>
                    <option>statistics</option>
                    <option>map</option>
                    <option>border</option>

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
                <li class="active"><a href="/d3/front.php">overview</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="topo/topo.php">topology</a></li>
                <li><a href="stats/stats.php">statistics</a></li>
                <li><a href="map/map.php">map</a></li>
                <li><a href="#">ip-specific</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="border/border.php">border</a></li>
                <li><a href="backbone/backbone.php">backbone</a></li>
                <li><a href="">router</a></li>
            </ul>
        </div>
        <div class="col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Overview</h1>
            <div class="jumbotron">
                <div class="container">
                    <h2>The Internet Topology Visualization Project</h2>
                    <p>This project aims to provide the Internet researching community and researchers alike with a user-friendly platform to effectively query, view and analyse the topology of the Internet</p>
                    <p>Using raw data from UCSD CAIDA, University of Washington iPlane, traceroute looking glass, and measurement originating from our Lab, we retrive, analyze, store and visualize those data to make them accurate and easy to view.</p>

                </div>
            </div>
            <h2 class="col-md-10 sub-header">1. Data Sources</h2>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>CAIDA ITDK</h4>
                    </div>
                    <div class="panel-body">
                        <p style="font-size:16px;">
                            CAIDA deploys and maintains a globally distributed measurement platform called Archipelago (Ark). It grows the infrastructure by distributing
                            hardware measurement nodes (2nd gen. Raspberry Pi) with as much geographical and topological diversity as it can to improve the view of the global
                            Internet.
                        </p>
                        <p style="font-size:16px;">
                            The dataset we use contains information useful for studying the topology of the Internet. Data is collected by a globally distributed set of Ark
                            monitors. The monitors use team-probing to distribute the work of probing the destinations among the available monitors.
                            <br><br><br>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>UW iPlane</h4>
                    </div>
                    <div class="panel-body">
                        <p style="font-size:16px;">
                            Measurement method: iPlane discovers all sets of aliases among the interfaces observed in traceroutes.  Alias candidates are identified using two
                            known techniques---interfaces that return the same source address when probed with UDP packets are on the same router, interfaces on either end of
                            a link in the core are usually in the same /30 prefix.  True aliases are then identified as ones that return similar IP-IDs and identical return
                            TTLs when probed at the same time.
                        </p>
                        <p style="font-size:16px;">
                            All traceroutes gathered by iPlane are also mirrored at the RIPE Data Repository. (You need to create a RIPE Labs account and accept their AUP for data access.)
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Traceroute LG</h4>
                    </div>
                    <div class="panel-body">
                        <p style="font-size:16px;">
                            Traceroute Looking Glass servers are computers on the Internet running one of a variety of publicly available Looking Glass software
                            implementations. A Looking Glass server (or LG server) is accessed remotely for the purpose of viewing routing info. Essentially, the server acts
                            as a limited, read-only portal to routers of whatever organization is running the Looking Glass server. Typically, publicly accessible looking
                            glass servers are run by ISPs or NOCs.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>HITNISL</h4>
                    </div>
                    <div class="panel-body">
                        <p style="font-size:16px;">
                            We perform traceroute measurements using scamper on some of the servers in our Lab.For alias resolution, we rely on several CAIDA tools: iffinder,
                            kapar, MIDAR.
                            <br><br><br><br>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <h2 class="sub-header">2. Data Process</h2>
            </div>


            <div class="col-md-10">
                <h2 class="sub-header">3. Modules</h2>
            </div>

            <div class="col-md-10">
                <h2 class="sub-header">4. Footnote</h2>
                <div class="col-md-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>RIR delegate file</h4>
                        </div>
                        <div class="panel-body">
                            <p style="font-size:20px;">
                                The file consists of:<br>
                                --comments: (starts with #)<br>
                                --file header lines: (includes version line & summary line)<br>
                                ----version line: (version|registry|serial|records|startdate|enddate|UTCoffset)<br>
                                ----summary line: (registry|*|type|*|count|summary)<br>
                                --records: (registry|cc|type|start|value|date|status[|extensions...])<br>
                                <br>
                                RIR delegate file list:<br>
                                "http://ftp.ripe.net/pub/stats/ripencc/delegated-ripencc-latest",<br>
                                "http://ftp.apnic.net/pub/stats/apnic/delegated-apnic-latest",<br>
                                "http://ftp.afrinic.net/pub/stats/afrinic/delegated-afrinic-latest",<br>
                                "http://ftp.lacnic.net/pub/stats/lacnic/delegated-lacnic-latest",<br>
                                "http://ftp.arin.net/pub/stats/arin/delegated-arin-extended-latest"<br>
                                <br>
                                For more detail, plz visit:<br>
                                "ftp://ftp.apnic.net/pub/apnic/stats/apnic/README.TXT"<br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>CAIDA pfx2as dataset</h4>
                        </div>
                        <div class="panel-body">
                            <p style="font-size:20px;">
                                dataset contains IPv4/IPv6 Prefix-to-Autonomous System (AS) mappings derived from RouteViews data.<br>
                                Files are created on a daily basis, starting from 2005-05-09 for IPv4 and 2007-01-01 for IPv6.<br>
                                The file format is line-oriented, with one prefix-AS mapping per line. The tab-separated fields are:<br>
                                IP prefix \t prefix length \t AS number<br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>纯真ip数据库数据格式</h4>
                        </div>
                        <div class="panel-body">
                            <p style="font-size:20px;">
                                +----------+<br>
                                |  文件头  |  (8字节)<br>
                                +----------+<br>
                                |  记录区  | （不定长）<br>
                                +----------+<br>
                                |  索引区  | （大小由文件头决定）<br>
                                +----------+<br>
                                a.)文件头：4字节开始索引偏移值+4字节结尾索引偏移值<br>
                                b.)记录区： 每条IP记录格式 ==> IP地址[国家信息][地区信息]<br>
                                --对于国家记录，可以有三种表示方式：<br>
                                ----字符串形式(IP记录第5字节不等于0x01和0x02的情况)，<br>
                                ----重定向模式1(第5字节为0x01),则接下来3字节为国家信息存储地的偏移值<br>
                                ----重定向模式(第5字节为0x02),<br>
                                --对于地区记录，可以有两种表示方式： 字符串形式和重定向<br>
                                --我们称IP记录的第5字节，以及所有重定向后的信息的第1字节，为 flag，有如下判定规则：<br>
                                ----1. 0x01 时，＂国家记录/地区信息＂都为 offset 指向的新地址<br>
                                ----2. 0x02 时，仅＂国家记录＂为 offset 指向的新地址，＂地区信息＂在4字节后<br>
                                ----3. 0x01, 0x02的情况下，重定向后的信息（新或旧）的首字节如果为 ：<br>
                                ------0，表示无记录（也读不到字符串的）<br>
                                ------0x02，其后3字节整数值为新的 offset 地址<br>
                                c.)索引区： 每条索引记录格式 ==> 4字节起始IP地址 + 3字节指向IP记录的偏移值<br>
                                ----索引区的IP和它指向的记录区一条记录中的IP构成一个IP范围。查询信息是这个范围内IP的信息<br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
    </div>

</div>

</body>
</html>
