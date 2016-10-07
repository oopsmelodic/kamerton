var myNewChart;
var filter = "BROADCASTER";
var limit = 0;
var polarChart;
var attitudeJSON = getIDOLData('*', filter);
var doccuntJSON; //= getIDOLData('IDOLdoc', '*', filter).sort(comp);
var dates=false;
//remakeDates();
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
    AttitudeChart();
    DoccountChart(false);
    $('#search').on('click', function (event) {
        event.preventDefault();
        dates=false;
        var filterFind = $('.list-group-item.active').find('.list-group-item-heading').text().trim();
        for (var i = 0; i < filters.length; i++) {
            if (filters[i][0] == filterFind)
            {
                filter = filters[i][1];
            }
        }
        limit = 0;
        rebuildCharts($('#textFilter').val());
    });

    var list = "";
    for (var i = 0; i < filters.length; i++) {

        list += '<a href="#" class="list-group-item"><h5 class="list-group-item-heading"> '
                + filters[i][0] + ' </h5></a>';
    }
    $('#lol').empty();
    $('#lol').append(list);
    $('.list-group-item').click(function (e) {
        e.preventDefault();
        $that = $(this);
        $that.parent().find('.list-group-item').removeClass('active').css("background-color", "");
        //;
        $that.addClass('active');
        //var find=$that.find('.list-group-item-heading').text();
    });
    $('#llim').click(function (e) {
        e.preventDefault();
        if ((limit - 10) >= 0)
        {
            limit -= 10;
            rebuildCharts($('#textFilter').val());
        }
    });
    $('#rlim').click(function (e) {
        e.preventDefault();
        {
            if (limit + 10 < attitudeJSON.length)
            {
                limit += 10;
                rebuildCharts($('#textFilter').val());
            }
        }
    });

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

function rebuildCharts(search)
{
    attitudeJSON = getIDOLData(search, filter);
    //doccuntJSON = getIDOLData('IDOLdoc', search, filter).sort(comp);
    //remakeDates();
    attitudeChart.destroy();
    if(!dates)
    {
        $("#doctext").html("<h4 align='center'>Количество документов</h4>");
        alert("lol");
        doccountChart.destroy();
        DoccountChart(false);
    }
    AttitudeChart();
}

function getIDOLData(text, filter)
{
    var jsonData;
    $.ajax({
        type: 'POST',
        data: {
            search: text,
            filter: filter
        },
        async: !1,
        dataType: 'json',
        url: 'php/IDOLattitude.php',
        success: function (jsondata) {
            jsonData = jsondata;
        }
    });
    return jsonData;
}

function getIDOLDates(text, filter,label)
{
    var jsonData;
    $.ajax({
        type: 'POST',
        data: {
            search: text,
            filter: filter,
            label:label
        },
        async: !1,
        dataType: 'json',
        url: 'php/IDOLdoc.php',
        success: function (jsondata) {
            jsonData = jsondata;
        }
    });
    return jsonData;
}

function getJsonArray(jsonData, name, maxlimit)
{
    var array = new Array();
    var count = 0;
    for (var i = limit; i < jsonData.length; i++)
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
        if (jsonData[i][name] != "" && jsonData[i][data] != "" && count <= 10)
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
        labels: getJsonArray(attitudeJSON, "filterLabel", 10),
        datasets: [
            {
                label: "Позитив",
                fillColor: "rgba(0,150,136,0.3)",
                strokeColor: "rgba(0, 150, 136,0.5)",
                highlightFill: "rgba(0,150,136,0.5)",
                highlightStroke: "rgba(0, 150, 136,0.9)",
                data: getJsonArray(attitudeJSON, "positive", 10)
            },
            {
                label: "Смешанное",
                fillColor: "rgba(234,236,1,0.3)",
                strokeColor: "rgba(234,236,1,0.5)",
                highlightFill: "rgba(234,236,1,0.5)",
                highlightStroke: "rgba(234,236,1,0.9)",
                data: getJsonArray(attitudeJSON, "neutral", 10)
            },
            {
                label: "Негатив",
                fillColor: "rgba(236,1,1,0.3)",
                strokeColor: "rgba(236,1,1,0.5)",
                highlightFill: "rgba(236,1,1,0.5)",
                highlightStroke: "rgba(236,1,1,0.9)",
                data: getJsonArray(attitudeJSON, "negative", 10)
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
        labels: !label ? getJsonArray(attitudeJSON, "filterLabel", 10) : getJsonArray(doccuntJSON, "filterLabel", 30),
        datasets: [
            {
                label: "Количество документов",
                fillColor: "rgba(0,150,136,0.3)",
                strokeColor: "rgba(0, 150, 136,0.5)",
                highlightFill: "rgba(0,150,136,0.5)",
                highlightStroke: "rgba(0, 150, 136,0.9)",
                data: !label ? getJsonArray(attitudeJSON, "docsum", 10) : getJsonArray(doccuntJSON, "doccount", 30)
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
                    doccuntJSON = getIDOLDates('*', filter , name).sort(comp);
                    remakeDates();
                    doccountChart.destroy();
                    DoccountChart(true); 
                    dates=true;
                    $("#doctext").html("<h4  align='center' style='display: inline-block; width: 93%; text-align: center';>Колличество документов по дням: "+name+"</h4><button type='button' class='btn btn-danger btn-sm' id='closedocs' style='display: inline-block;'> <span class='glyphicon glyphicon glyphicon-remove'></span></button>");
                    $("#closedocs").click(function (evt) {
                        doccountChart.destroy();
                        dates=false;
                        DoccountChart(false); 
                        $("#doctext").html("<h4 align='center'>Количество документов</h4>");
                    });
                }
            }
    );
    
}
function remakeDates()
    {
        for (var i = 0; i < doccuntJSON.length; i++)
        {
            doccuntJSON[i]["filterLabel"] = doccuntJSON[i]["filterLabel"].split('/')[2] + "/" + doccuntJSON[i]["filterLabel"].split('/')[1] + "/" + doccuntJSON[i]["filterLabel"].split('/')[0];
        }
    }
function comp(a, b) {
    return new Date(a.filterLabel).getTime() - new Date(b.filterLabel).getTime();
}