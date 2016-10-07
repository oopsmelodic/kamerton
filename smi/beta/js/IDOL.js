Date.prototype.getUnixTimestamp = function () {
    return Math.round(this.getTime() / 1000);
}
var myNewChart;
var search = "*";
var filter = "SOURCESITE";
var limit = 0;
var showDocs = false;
var datesLimit = 0;
var polarChart;
var dateStart = (new Date(2014, 1, 1)).getUnixTimestamp();
var dateEnd = (new Date()).getUnixTimestamp();
var attitudeJSON = getIDOLData('*', filter, "", "");
var doccuntJSON; //= getIDOLData('IDOLdoc', '*', filter).sort(comp);
var docsJSON;
var dates = false;
var attitudeChart;
var doccountChart;
var filters = [["Источник", "SOURCESITE"],
    ["Каналы", "BROADCASTER"],
    ["Страны", "COUNTRY"],
    ["Адреса в сети", "HOSTADDR"],
    ["E-mail", "EMAIL"],
    ["Политики", "POLITICS"],
    ["Организации", "REGIONS"],
    ["Люди.Форбс", "PEOPLE_FORBES"],
    ["Банки", "BANKS_RU"],
    ["ГЛОНАСС", "GLONASS_GLONASS"],
    ["ГЛОНАСС.Персоны", "GLONASS_PEOPLE"],
    ["ГЛОНАСС.Партнерство", "GLONASS_PARTNERS"],
    //["Авторы", "AUTHOR"],
    ["Еврохим.Руководство", "EVROHIM_PERSON"],
    ["Еврохим.Организации", "EVROHIM_COMPANY"]];

$.extend($.expr[":"], {
    "icontains": function (elem, i, match, array) {
        return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }});

$(function () {
    Chart.defaults.global.responsive = true;
    $('#page-selection').bootpag({
        total: 1,
        page: 1,
        maxVisible: 10,
        leaps: true,
        firstLastUse: true,
        first: '←',
        last: '→',
        wrapClass: 'pagination',
        activeClass: 'active',
        disabledClass: 'disabled',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first'
    }).on("page", function (event, num) {
        showdocs(1+10*(num-1));
        window.scrollTo(0,0);
    });
        
    showdocs(1);

    $('#statclick').on('shown.bs.tab', function (e) {
        rebuildCharts();
    });

    $("#textFilter").keyup(function (event) {
        if (event.keyCode == 13) {
            $("#search").click();
        }
    });

//    $('#docclick').on('click', function (event) {
//        //setTimeout("window.dispatchEvent(new Event('resize')); ", 150);
//    });

    $('#search').on('click', function (event) {
    //document.body.style.overflow = 'hidden';
    //$(".glass-close").css("display","block");
        $('#page-selection').bootpag({page: 1});
        if (showDocs)
            checkdocs();
        if ($('#startdate').val() == "")
        {
            dateStart = (new Date(2008, 1, 1)).getUnixTimestamp() + (60 * 60 * 24);
        }
        else
            dateStart = new Date($('#startdate').data("DateTimePicker").getDate()).getUnixTimestamp() + (60 * 60 * 24);
        if ($('#enddate').val() == "")
        {
            dateEnd = (new Date()).getUnixTimestamp() + (60 * 60 * 24);
        }
        else
            dateEnd = new Date($('#enddate').data("DateTimePicker").getDate()).getUnixTimestamp() + (60 * 60 * 24);
        event.preventDefault();
        dates = false;
        datesLimit = 0;
        var filterFind = $('.list-group-item.active').find('.list-group-item-heading').text().trim();
        filter = "";
        for (var i = 0; i < filters.length; i++) {
            if (filters[i][0] == filterFind)
            {
                filter += filters[i][1];
            }
        }
        limit = 0;
        search = $('#textFilter').val();
        if (search == "")
            search = "*";
        if (filter == "")
            filter = "BROADCASTER";
        getIDOLData(search, filter, dateStart, dateEnd);
        if ($('#statclick').parent().hasClass('active')) {
            rebuildCharts();
        }
        showdocs(1);
        document.body.style.overflow = '';
    $(".glass-close").css("display","none");
        window.scrollTo(0,0);
        //$(".glass-close").css("display","none");
    });

    var list = "";
    for (var i = 0; i < filters.length; i++) {

        list += '<a href="#" class="list-group-item"><h5 class="list-group-item-heading"> '
                + filters[i][0] + ' </h5></a>';
    }
    $('#lol').empty();
    $('#lol').append(list);
    $('.list-group-item').first().addClass('active');
    $('.list-group-item').click(function (e) {
        e.preventDefault();
        $that = $(this);

        //if($that.hasClass('active')) $that.removeClass('active').css("background-color", "");
        // else $that.addClass('active');
        $that.parent().find('.list-group-item').removeClass('active').css("background-color", "");
        $that.addClass('active');

        //var find=$that.find('.list-group-item-heading').text();
    });
    $('#llim').click(function (e) {
        e.preventDefault();
        if ((limit - 10) >= 0)
        {
            limit -= 10;
            rebuildCharts();
        }
    });
    $('#rlim').click(function (e) {
        e.preventDefault();
        {
            if (limit + 10 < attitudeJSON.length)
            {
                limit += 10;
                rebuildCharts();
            }
        }
    });
    $('#startdate').mask('99.99.9999').datetimepicker({language: 'ru', pickTime: false});
    $('#enddate').mask('99.99.9999').datetimepicker({language: 'ru', pickTime: false});

//    
//    $('#name').on('input', function ()
//    {
//        var text = $(this).val();
//        createList(json);
//        if (text.length >= 2 && text !== '')
//        {
//            var name = $('#name').val();
//            var element = $('.list-group-lol li:contains("' + name + '")');
//            element.removeClass('active').css('color', '#009688');
//            for (var i = 0; i < element.length; i++) {
//                $('.list-group-lol').prepend(element[i]);
//            }
//            $('.list-group-lol').scrollTop(0);
//        } else {
//            $('.list-group-lol li').css('color', '#fff');
//        }
//    });
});

function rebuildCharts()
{
    if (!dates)
    {
        $("#doctext").html("<h4 align='center'>Количество документов</h4>");
        if (typeof doccountChart !== "undefined") {
            doccountChart.destroy();
        }
        DoccountChart(false);
    }
    else
    {
        if (typeof doccountChart !== "undefined") {
            doccountChart.destroy();
        }
        DoccountChart(true);
    }
    if (typeof attitudeChart !== "undefined") {
        attitudeChart.destroy();
    }
    AttitudeChart();
}

function getIDOLData(text, filter, stdate, enddate)
{
    $.ajax({
        type: 'POST',
        data: {
            search: text,
            filter: filter,
            start: stdate,
            end: enddate
        },
        async: true,
        dataType: 'json',
        url: 'php/IDOLattitude.php',
        success: function (jsondata) {
            attitudeJSON = jsondata;
            if ($('#statclick').parent().hasClass('active')) {
            rebuildCharts();
            }
        }
    });
}

function getIDOLDates(doc,page, text, filter, label, stdate, enddate)
{
    var jsonData;
    $.ajax({
        type: 'POST',
        data: {
            page: page,
            search: text,
            filter: filter,
            label: label,
            start: stdate,
            end: enddate
        },
        async: !1,
        dataType: 'json',
        url: 'php/' + doc + '.php',
        success: function (jsondata) {
            jsonData = jsondata;
        }
    });
    return jsonData;
}

function getJsonArray(jsonData, name, showlimit, maxlimit)
{
    var array = new Array();
    var count = 0;
    for (var i = showlimit; i < jsonData.length; i++)
    {
        if (jsonData[i][name] != "" && count <= maxlimit)
        {
            array[count] = jsonData[i][name];
            count++;
        }
    }
    return array;
}

function getJsonArrays(jsonData, name, data)
{
    var array = new Array();
    var count = 0;
    for (var i = limit; i < jsonData.length; i++)
    {
        if (jsonData[i][name] != "" && jsonData[i][data] != "" && count < 10)
        {
            array[count] = new Array();
            array[count][0] = jsonData[i][name];
            array[count][1] = jsonData[i][data];
            count++;
        }
    }
    return array;
}

function reset(name, nametype)
{
    if (name == "") {
        name = $('.list-group-lol li').first().text().trim();
    }
    setActiveBar(myNewChart, name, nametype);
    setActivePie(polarChart, name, nametype);
    createList(json);
    var items = $('.list-group-lol').find('li');

    for (var i = 0; i < json.length; i++)
    {
        if (json[i][nametype] == name)
        {
            for (var j = 0; j < items.length; j++)
                if (items[j].textContent.trim() == json[i]["gosReestrName"])
                {
                    $(items[j]).addClass('active');
                    break;
                }
            break;
        }
    }
    createInfo(name, nametype);
}

function setActiveBar(barObject, name, nametype)
{
    for (var i = 0; i < json.length; i++)
    {
        if (json[i][nametype] == name)
        {
            for (var j = 0; j < barObject.datasets[0].bars.length; j++)
            {
                if (barObject.datasets[0].bars[j].label == json[i]["YandexsiteName"])
                {
                    barObject.datasets[0].bars[j].fillColor = "rgba(0, 150, 136,0.9)";
                    barObject.datasets[0].bars[j].strokeColor = "rgba(0, 150, 136,0.9)";
                }
                else
                {
                    barObject.datasets[0].bars[j].fillColor = "rgba(0, 150, 136,0.3)";
                    barObject.datasets[0].bars[j].strokeColor = "rgba(0, 150, 136,0.5)";
                }
            }
            barObject.update();
            break;
        }
    }
}

function setActivePie(pieObject, name, nametype)
{
    for (var i = 0; i < json.length; i++)
    {
        if (json[i][nametype] == name)
        {
            for (var j = 0; j < pieObject.segments.length; j++)
            {
                pieObject.segments[j].fillColor = "rgba(0, 150, 136,0.3)";
                pieObject.segments[j].strokeColor = "rgba(0, 150, 136,0.5)";
                if (pieObject.segments[j].label == json[i]["gosReestrName"])
                {
                    pieObject.segments[j].fillColor = "rgba(0, 150, 136,0.9)";
                    pieObject.segments[j].strokeColor = "rgba(0, 150, 136,0.9)";
                }
            }
            pieObject.update();
            break;
        }
    }
}

function pieChart()
{
    var data2 = [
        {
            value: 100,
            color: "#F7464A",
            highlight: "#FF5A5E",
            label: "Red"
        }
    ];
    data2.splice(0, 1);
    var pieData = getJsonArrays(json, "gosReestrName", "visitersRussiaPercentage");

    for (var i = 0; i < pieData.length; i++)
    {
        data2.push({
            value: parseInt(pieData[i][1].replace("%", "")),
            color: "rgba(0,150,136,0.3)",
            strokeColor: "rgba(0, 150, 136,0.5)",
            highlight: "rgba(0,150,136,0.5)",
            label: pieData[i][0]
        });
    }

    var ctx = $("#myChartPolar").get(0).getContext("2d");
    polarChart = new Chart(ctx).PolarArea(data2, {segmentStrokeColor: "rgba(0, 150, 136,0.5)"});

    $("#myChartPolar").click(
            function (evt) {
                var activePies = polarChart.getSegmentsAtEvent(evt);
                if (activePies.length > 0)
                {
                    var name = activePies[0].label;
                    reset(name, "gosReestrName");
                }
            }
    );
}

function barChart()
{
    Chart.defaults.global.responsive = true;

    var data = {
        labels: getJsonArray(json, "YandexsiteName"),
        datasets: [
            {
                label: "Рейтинг цитируемости",
                fillColor: "rgba(0,150,136,0.3)",
                strokeColor: "rgba(0, 150, 136,0.5)",
                highlightFill: "rgba(0,150,136,0.5)",
                highlightStroke: "rgba(0, 150, 136,0.9)",
                data: getJsonArray(json, "citationRate")
            }
        ]
    };

    var ctx = $("#myChart").get(0).getContext("2d");
    myNewChart = new Chart(ctx).Bar(data);

    $("#myChart").click(
            function (evt) {
                var activeBars = myNewChart.getBarsAtEvent(evt);
                if (activeBars.length > 0)
                {
                    var name = activeBars[0].label;
                    activeBars[0].fillColor = "rgba(0, 150, 136,0.9)";
                    //alert(activeBars[0].fillColor);
                    reset(name, "YandexsiteName");
                }
            }
    );
}

function AttitudeChart()
{
    var data = {
        labels: getJsonArray(attitudeJSON, "filterLabel", limit, 9),
        datasets: [
            {
                label: "Позитив",
                fillColor: "rgba(0,150,136,0.3)",
                strokeColor: "rgba(0, 150, 136,0.5)",
                highlightFill: "rgba(0,150,136,0.5)",
                highlightStroke: "rgba(0, 150, 136,0.9)",
                data: getJsonArray(attitudeJSON, "positive", limit, 9)
            },
            {
                label: "Смешанное",
                fillColor: "rgba(234,236,1,0.3)",
                strokeColor: "rgba(234,236,1,0.5)",
                highlightFill: "rgba(234,236,1,0.5)",
                highlightStroke: "rgba(234,236,1,0.9)",
                data: getJsonArray(attitudeJSON, "neutral", limit, 9)
            },
            {
                label: "Негатив",
                fillColor: "rgba(236,1,1,0.3)",
                strokeColor: "rgba(236,1,1,0.5)",
                highlightFill: "rgba(236,1,1,0.5)",
                highlightStroke: "rgba(236,1,1,0.9)",
                data: getJsonArray(attitudeJSON, "negative", limit, 9)
            }
        ]
    };

    var ctx = $("#attitudeChart").get(0).getContext("2d");
    attitudeChart = new Chart(ctx).Bar(data);

//    $("#attitudeChart").click(
//            function (evt) {
//                var activeBars = myNewChart.getBarsAtEvent(evt);
//                if (activeBars.length > 0)
//                {
//                    var name = activeBars[0].label;
//                    activeBars[0].fillColor = "rgba(0, 150, 136,0.9)";
//                    //alert(activeBars[0].fillColor);
//                    reset(name, "YandexsiteName");
//                }
//            }
//    );
}
function DoccountChart(label)
{

    var data = {
        labels: !label ? getJsonArray(attitudeJSON, "filterLabel", limit, 9) : getJsonArray(doccuntJSON, "filterLabel", datesLimit, 30),
        datasets: [
            {
                label: "Количество документов",
                fillColor: "rgba(0,150,136,0.3)",
                strokeColor: "rgba(0, 150, 136,0.5)",
                highlightFill: "rgba(0,150,136,0.5)",
                highlightStroke: "rgba(0, 150, 136,0.9)",
                data: !label ? getJsonArray(attitudeJSON, "docsum", limit, 9) : getJsonArray(doccuntJSON, "doccount", datesLimit, 30)
            }
        ]
    };
    var ctx = $("#docChart").get(0).getContext("2d");
    doccountChart = new Chart(ctx).Bar(data);

    $("#docChart").click(
            function (evt) {
                var activeBars = doccountChart.getBarsAtEvent(evt);
                if (activeBars.length > 0)
                {
                    var name = activeBars[0].label;
                    doccuntJSON = getIDOLDates("IDOLdoc","", search, filter, name, dateStart, dateEnd).sort(comp);
                    remakeDates();
                    doccountChart.destroy();
                    DoccountChart(true);
                    dates = true;
                    $("#doctext").html("<button type='button' class='btn btn-success btn-sm' id='ldate' style='display: inline-block; margin-left: 20px;'><span class='glyphicon glyphicon-chevron-left'></span></button>"
                            + "<button type='button' class='btn btn-success btn-sm' id='rdate' style='display: inline-block;'><span class='glyphicon glyphicon-chevron-right'></span></button>"
                            + "<button type='button' class='btn btn-danger btn-sm' id='closedocs' style='display: inline-block;'> <span class='glyphicon glyphicon glyphicon-remove'></span></button>"
                            + "<h4  align='center' style='display: inline-block; width: 77%; text-align: center';>Колличество документов по дням: " + name + "</h4>"
                            );
                    $("#closedocs").click(function () {
                        doccountChart.destroy();
                        DoccountChart(false);
                        dates = false;
                        datesLimit = 0;
                        $("#doctext").html("<h4 align='center'>Количество документов</h4>");
                    });
                    $('#ldate').click(function (e) {
                        e.preventDefault();
                        if ((datesLimit - 30) >= 0)
                        {
                            datesLimit -= 30;
                            doccountChart.destroy();
                            DoccountChart(true);
                        }
                    });
                    $('#rdate').click(function (e) {
                        e.preventDefault();
                        {
                            if (datesLimit + 30 < doccuntJSON.length)
                            {
                                datesLimit += 30;
                                doccountChart.destroy();
                                DoccountChart(true);
                            }
                        }
                    });
                }
            }
    );

}
function remakeDates()
{
    for (var i = 0; i < doccuntJSON.length; i++)
    {
        doccuntJSON[i]["filterLabel"] = doccuntJSON[i]["filterLabel"].split('/')[2] + "." + doccuntJSON[i]["filterLabel"].split('/')[1] + "." + doccuntJSON[i]["filterLabel"].split('/')[0];
    }
}
function comp(a, b) {
    return new Date(a.filterLabel).getTime() - new Date(b.filterLabel).getTime();
}

function showdocs(page)
{
    docsJSON = getIDOLDates("IDOLshowdocs",page, search, "", "", "", dateEnd);
    if(docsJSON["autnresponse"]["responsedata"]["autn:numhits"]["$"]==0) return;
    $('#page-selection').bootpag({total: Math.ceil(docsJSON["autnresponse"]["responsedata"]["autn:totalhits"]["$"] / 10)});
    var html = "";
    for (var i = 0; i < docsJSON["autnresponse"]["responsedata"]["autn:hit"].length; i++)
    {
        var pos = "";
        var neg = "";
        if(docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:content"]["DOCUMENT"]["POSITIVE_VIBE"]!= undefined) {
            pos="<strong>Позитив: </strong>  ";
            for (var j = 0; j < docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:content"]["DOCUMENT"]["POSITIVE_VIBE"].length; j++) 
            {
                pos += docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:content"]["DOCUMENT"]["POSITIVE_VIBE"][j]["$"] + ", ";
            }
            pos = pos.slice(0, -2);
        }
        if(docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:content"]["DOCUMENT"]["NEGATIVE_VIBE"]!= undefined){
            neg = "<strong>Негатив: </strong>  ";
            for (var j = 0; j < docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:content"]["DOCUMENT"]["NEGATIVE_VIBE"].length; j++) 
            {
                neg += docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:content"]["DOCUMENT"]["NEGATIVE_VIBE"][j]["$"] + ", ";
            }
            neg = neg.slice(0, -2);
        }
        html += "<div class='col-md-12 col-sm-12 col-lg-12 shadow-block'><div class='brd' style='margin-bottom:10px;'><span class='glyphicon glyphicon glyphicon-film' style='display: inline-block; margin-left:15px; font-size:13pt;'></span><h4 align='center' style='display: inline-block; margin-left:20px;'>" + docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:title"]["$"] + "</h4><span class='label label-primary' style='position:absolute; right:10px; top:10px;'>"+docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:weight"]["$"]+"</span></div>"
                + "<div class='col-md-8 col-sm-8 col-lg-8'><div style='padding-left:15px;'><strong>Ссылка: </strong><a href='" + docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:content"]["DOCUMENT"]["DREREFERENCE"]["$"] + "' target=_blank>" + docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:content"]["DOCUMENT"]["DREREFERENCE"]["$"] + "</a><br>"
                + "<strong>Дата: </strong>" + docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:datestring"]["$"] + "<br><br>"
                + "<strong>Содержание: </strong>" + docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:summary"]["$"].replace(new RegExp("{iMhlo}", 'g'), "<strong style='color:red;'>").replace(new RegExp("{iMhlc}", 'g'), " </strong> ")
                + "<br><button type='button' class='btn btn-xs btn-success showposi'>Показать тональность</button>"
                + "<div class='allposyes' style='display:none;'>" + pos + "</div>"
                + "<div class='allposyes' style='display:none;'>" + neg + "</div>"
                + "</div></div><div class='col-md-4 col-sm-4 col-lg-4' style='text-align: center; heigth:20%'>";
                
                if(docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:content"]["DOCUMENT"]["POST_IMG"]!= undefined)if(docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:content"]["DOCUMENT"]["POST_IMG"]["$"]!= undefined) html += "<img src='" + docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:content"]["DOCUMENT"]["POST_IMG"]["$"] + "' alt='" + docsJSON["autnresponse"]["responsedata"]["autn:hit"][i]["autn:title"]["$"] + "' width='100%' style='padding:10px; max-height:250px;'></img>";
                else html+="<span class='glyphicon glyphicon-file' style='font-size:50pt; padding:25px; border: 1px solid #009688; margin-top:15px'></span>";
                html += "</div></div>";

    }
    //html += "<div class='col-md-12 col-sm-12 col-lg-12' style='margin-bottom: 10px;'></div>";
    $("#docdiv").html(html);

    $('.showposi').on('click', function (event) {
        $that = $(this);
        if ($that.parent().find('.allposyes').is(":hidden")) {
            $that.html("Скрыть тональность").removeClass("btn-success").addClass("btn-danger");
            $that.parent().find('.allposyes').slideDown("slow");
        } else {
            $that.html("Показать тональность").removeClass("btn-danger").addClass("btn-success");
            $that.parent().find('.allposyes').slideUp("slow");
        }
    });
}

function docnav()
{
    var pages = Math.ceil(docsJSON["autnresponse"]["responsedata"]["autn:totalhits"]["$"] / 10);
    var html = "<ul class='pagination' style='margin:10px 0 0 0;'><li><a href='#'>Prev</a></li>";
    for(var i=1;(i<=pages && i<=10);i++)
    {
        html+="<li><a href='#'>"+i+"</a></li>";
    }
    html+="<li><a href='#'>Next</a></li></ul>";
    $('.docnav').html(html);
}
