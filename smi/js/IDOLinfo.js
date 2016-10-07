var attitudeJSON = getIDOLData();
var AttitudeChart;

$(function () {
    
    AttitudeChart();
    
});

function getIDOLData()
{
    var jsonData;
    $.ajax({
        async: !1,
        dataType: 'json',
        url: 'php/IUSanalysis.php',
        success: function (jsondata) {
            jsonData = jsondata;
        }
    });
    return jsonData;
}

//function getJsonArray(jsonData, name)
//{
//    var array = new Array();
//    var count = 0;
//    for (var i = 0; i < jsonData.length; i++)
//    {
//        if (jsonData[i][name] != "")
//        {
//            array[count] = jsonData[i][name];
//            count++;
//        }
//    }
//    return array;
//}

function AttitudeChart()
{
    //Chart.defaults.global.responsive = true;

    var data = {
        labels: getJsonArray(attitudeJSON, "smiName"),
        datasets: [
            {
                label: "Позитив",
                fillColor: "rgba(0,150,136,0.3)",
                strokeColor: "rgba(0, 150, 136,0.5)",
                highlightFill: "rgba(0,150,136,0.5)",
                highlightStroke: "rgba(0, 150, 136,0.9)",
                data: getJsonArray(attitudeJSON, "positive")
            },
            {
                label: "Смешанное",
                fillColor: "rgba(234,236,1,0.3)",
                strokeColor: "rgba(234,236,1,0.5)",
                highlightFill: "rgba(234,236,1,0.5)",
                highlightStroke: "rgba(234,236,1,0.9)",
                data: getJsonArray(attitudeJSON, "neutral")
            },
            {
                label: "Негатив",
                fillColor: "rgba(236,1,1,0.3)",
                strokeColor: "rgba(236,1,1,0.5)",
                highlightFill: "rgba(236,1,1,0.5)",
                highlightStroke: "rgba(236,1,1,0.9)",
                data: getJsonArray(attitudeJSON, "negative")
            }
        ]
    };

    var ctx = $("#attitudeChart").get(0).getContext("2d");
    AttitudeChart = new Chart(ctx).Bar(data);

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