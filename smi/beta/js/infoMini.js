var json=getData();

function getData()
{
	var jsonData;
	$.ajax({
		async: !1,
		dataType: 'json',
		url: 'php/getstat.php',
		success: function(jsondata){
			jsonData=jsondata;
		}
	});
	return jsonData;
}

function createInfo(find,jsonlook)
{
	for(var i=0;i<json.length;i++)
	{
		if(json[i][jsonlook]==find) 
		{
			var infoHtml="<h4 align='center' class='brd'>Сводка: <strong>"+json[i]["gosReestrName"]+"</strong></h4>";
			if(json[i]["citationRate"]!="") infoHtml+="<div class='col-md-6'>";
			infoHtml+="<p><strong>Основатель: </strong>"+json[i]["founder"]+"</p>"+
			"<p><strong>Категория: </strong>"+json[i]["category"]+"</p>"+
			"<p><strong>ИНН: </strong>"+json[i]["inn"]+"</p>"+
			"<p><strong>Адресс: </strong><a href='http://"+json[i]["liveLink"]+"' target='_blank'>"+json[i]["liveLink"]+"</a></p></div>";
			if(json[i]["citationRate"]!="")
				infoHtml+="<div class='col-md-6'><p><strong>Рейтинг цитируемости: </strong>"+(json[i]["citationRate"]).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ")+"</p>"+
				"<p><strong>Просмотров в месяц: </strong>"+(json[i]["views"]).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ")+"</p>"+
				"<p><strong>Процент посетителей из России: </strong>"+json[i]["visitersRussiaPercentage"]+"</p></div>";
			$('#info').html(infoHtml);
			break;
		}
	}
}