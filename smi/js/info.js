var json = getData();
var myNewChart;
var polarChart;
var maxCitation = getMax("citationRate");

$.extend($.expr[":"], {
    "icontains": function (elem, i, match, array) {
        return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }});

$(function () {
    createList(json);
    barChart();
    pieChart();
    $('#find').on('click', function (event)
    {
        $('#name').val('');
        createList(json);
    });

    $('#name').on('input', function ()
    {
        var text = $(this).val();
        createList(json);
        if (text.length >= 2 && text !== '')
        {
            var name = $('#name').val();
            var element = $('.list-group-lol li:contains("' + name + '")');
            element.removeClass('active').css('color', '#009688');
            for (var i = 0; i < element.length; i++) {
                $('.list-group-lol').prepend(element[i]);
            }
            $('.list-group-lol').scrollTop(0);
        } else {
            $('.list-group-lol li').css('color', '#fff');
        }
    });
});

function getData()
{
    var jsonData;
    $.ajax({
        async: !1,
        dataType: 'json',
        url: 'php/getstat.php',
        success: function (jsondata) {
            jsonData = jsondata;
        }
    });
    return jsonData;
}

function getJsonArray(jsonData, name)
{
    var array = new Array();
    var count = 0;
    for (var i = 0; i < jsonData.length; i++)
    {
        if (jsonData[i][name] != "")
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
    for (var i = 0; i < jsonData.length; i++)
    {
        if (jsonData[i][name] != "" && jsonData[i][data] != "")
        {
            array[count] = new Array();
            array[count][0] = jsonData[i][name];
            array[count][1] = jsonData[i][data];
            count++;
        }
    }
    return array;
}

function createList(json)
{
    //var names=getJsonArray(json,"gosReestrName");
    var list = "";

    for (var i = 0; i < json.length; i++) {
        if (json[i]["gosReestrName"] != "")
            list += "<li><a href='#' class='list-group-lol-item'>" + ((json[i]["liveinternetName"] != "") || (json[i]["YandexsiteName"] != "") ? "<i class='fa fa-bar-chart'></i>" : "") + "<span> "
                    + json[i]["gosReestrName"] + " </span></a></li>";
    }
    $('.list-group-lol').empty();
    $('.list-group-lol').append(list);

    $('.list-group-lol li').off('click').on('click', function (e) {
        e.preventDefault();
        $that = $(this);
        $that.parents('ul').find('li').removeClass('active');
        $that.addClass('active');
        var find = $that.text().trim();
        setActiveBar(myNewChart, find, "gosReestrName");
        setActivePie(polarChart, find, "gosReestrName");
        createInfo(find, "gosReestrName");
    });
}

function createInfo(find, jsonlook)
{
    for (var i = 0; i < json.length; i++)
    {
        if (json[i][jsonlook] == find)
        {
            var infoHtml = "<h4 align='center' class='brd'>Сводка: <strong>" + json[i]["gosReestrName"] + "</strong></h4>";
            if (json[i]["citationRate"] != "")
                infoHtml += "<div class='col-md-6'>";
            infoHtml += "<p><strong>Основатель: </strong>" + json[i]["founder"] + "</p>" +
                    "<p><strong>Категория: </strong>" + json[i]["category"] + "</p>" +
                    "<p><strong>ИНН: </strong>" + json[i]["inn"] + "</p>" +
                    "<p><strong>Адресс: </strong><a href='http://" + json[i]["liveLink"] + "' target='_blank'>" + json[i]["liveLink"] + "</a></p></div>";
            if (json[i]["citationRate"] != "")
                infoHtml += "<div class='col-md-6'><p><strong>Рейтинг цитируемости: </strong>" + (json[i]["citationRate"]).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ") + "</p>" +
                        "<p><div class='progress' style='margin-right:10px;'><div class='progress-bar' role='progressbar' aria-valuenow='" + fnLog(parseInt(json[i]["citationRate"]), maxCitation) * 100 + "' aria-valuemin='0' aria-valuemax='" + 100 + "' style='width: " + fnLog(parseInt(json[i]["citationRate"]), maxCitation) * 100 + "%;'>" + (json[i]["citationRate"]).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ") + " / " + maxCitation.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ") + "</div></div></p>" +
                        "<p><strong>Просмотров в месяц: </strong>" + (json[i]["views"]).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ") + "</p>" +
                        "<p><strong>Процент посетителей из России: </strong>" + json[i]["visitersRussiaPercentage"] + "</p></div>";
            $('#info').html(infoHtml);
            break;
        }
    }
}

function fnLog(m, n)
{
    var fTmp = ((Math.log(m)) / (Math.log(n)));
    return (fTmp);
}

function getMax(collumn)
{
    var max = 0;
    for (var i = 0; i < json.length; i++)
        if (max < parseInt(json[i][collumn]))
            max = parseInt(json[i]["citationRate"]);
    return max;
}

function reset(name, nametype)
{
    if (name == "") { name = $('.list-group-lol li').first().text().trim(); }
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