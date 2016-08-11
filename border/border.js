var height = 1200,
    width = 1200;

var page_size = 20;
var page_disp = 10;
var start_page = 0;
var active_page = 0;

var border_table = d3.select("#border_table");

var xmlHttpRequest;

var query_btn = d3.select("#query_btn")
    .on("click",get_all_func);

function get_all_func(){
    get_table_func();
}

function get_table_func(){
    var url = "get_json.php";
    var post_str = "type=table";

    xmlHttpRequest = new XMLHttpRequest();
    xmlHttpRequest.open("POST", url, true);
    xmlHttpRequest.onreadystatechange = table_ready;
    xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlHttpRequest.send(post_str);
}

var dataset, table_list,num_page;

function table_ready(){
    if(xmlHttpRequest.readyState == 4 && xmlHttpRequest.status == 200) {
        var text = xmlHttpRequest.responseText;
        dataset = JSON.parse(text);
        start_page = 0;
        active_page = 0;
        num_page = Math.ceil(dataset.nodes.length/page_size);

        refresh_nav();

        $("#prev").click(function(){
            start_page = 0;
            active_page = 0;
            refresh_nav();
        });
        $("#next").click(function(){
            start_page = num_page-page_disp;
            active_page = num_page-1;
            refresh_nav();
        });
    }
}

function on_page_click(e){
    var html = $(this).html();
    var value = -1;
    if (html == "..."){
        value = start_page+page_disp;
        start_page = value;
    }
    else if(html == ".."){
        value = start_page-page_disp;
        start_page = value;
    }
    else{
        value= parseInt(html)-1;
    }

    active_page = value;
    refresh_nav();
}

function refresh_nav(){
    table_list = dataset.nodes.slice(active_page*page_size, (active_page+1)*page_size);

    //remove remaining pages first.
    var pages = $("#pages");
    pages.find("li").not("#prev").not("#next").remove();

    //make new page nav.
    var prev = 0;
    if(start_page >= page_disp){
        pages.find("li").eq(0).after('<li class="item"><a>..</a></li>');
        prev = 1;
    }
    for (var i=start_page; i<num_page && i<start_page+page_disp; i++){
        if (i+1 > 0){
            if (i!=active_page){
                pages.find("li").eq(i-start_page+prev).after("<li class='item'><a>"+(i+1).toString()+"</a></li>");
            }
            else {
                pages.find("li").eq(i-start_page+prev).after("<li class='item active'><a>" + (i + 1).toString() + "</a></li>");
            }
        }
    }
    if(start_page+page_disp < num_page) {
        pages.find("li").eq(i-start_page+prev).after('<li class="item"><a>...</a></li>');
    }
    //add onclick listener.
    pages.find("li").not("#prev").not("#next").find("a").click(on_page_click);

    //clear table first.
    var tbl = $("#border_table");
    tbl.find("tbody tr").remove();

    //make new table.
    for (var j=0; j<table_list.length; j++) {
        var row = tbl.find("tbody").append("<tr></tr>");
        var cc;
        if (table_list[j].country == null || table_list[j].country == "*"){
            cc = "un";
        }
        else{
            cc = table_list[j].country.toLowerCase();
        }
        row.find("tr:eq("+ j.toString()+")").append('<td>'+ (active_page*page_size+j).toString()+'</td>');
        row.find("tr:eq("+ j.toString()+")").append('<td><span class="flag-icon flag-icon-' + cc + '"></span></td>');
        row.find("tr:eq("+ j.toString()+")").append('<td>' + table_list[j].addr + '</td>');
        row.find("tr:eq("+ j.toString()+")").append('<td>' + cc + '</td>');
        row.find("tr:eq("+ j.toString()+")").append('<td>' + table_list[j].asn + '</td>');
        row.find("tr:eq("+ j.toString()+")").append('<td>' + table_list[j].asn_cc + '</td>');
        row.find("tr:eq("+ j.toString()+")").append('<td>' + table_list[j].czdb_country + ','+ table_list[j].czdb_area +'</td>');
    }
}