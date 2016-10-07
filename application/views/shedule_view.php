<!--<link href="/bower_components/bootstrap-calendar-master/css/calendar.css"  rel="stylesheet">  
<script src="/bower_components/bootstrap-calendar-master/components/underscore/underscore-min.js"></script>
<script src="/bower_components/bootstrap-calendar-master/js/language/ru-RU.js"></script>
<script src="/bower_components/bootstrap-calendar-master/js/calendar.js"></script>-->
<link href="/bower_components/fullcalendar-2.3.2/fullcalendar.css"  rel="stylesheet"/>  
<script src="/bower_components/fullcalendar-2.3.2/lib/moment.min.js"></script>
<script src="/bower_components/fullcalendar-2.3.2/fullcalendar.js"></script>
<script src="/bower_components/fullcalendar-2.3.2/lang-all.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>
<div class="card card-1"></div>
<div id='calendar'></div>

<script>

    //SNOOPYYYYYYYYYY
    
//                $('body').append('<audio id="snoop" src="/dev/run nigga_01.mp3" loop></audio>');
//                myVid=$('#snoop').get(0);
//                myVid.volume=0;
//                myVid.play();
//    setInterval(function (){
//                myVid=$('#snoop').get(0);
//                myVid.volume=0.015;        
//                things = $('.fc-day-grid .fc-bg td');
//                things.removeClass('snoop');
//                rand = $(things[Math.floor(Math.random()*things.length)]);
//                $('body').scrollTo(rand);
//                
//                console.log($(things[Math.floor(Math.random()*things.length)]));
//                rand.addClass('snoop').addClass('animated').addClass('rollin').delay(2000);
//            },3000);                
		$('#calendar').fullCalendar({
                        lang: 'ru',
//                        theme:false,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			//defaultDate: '2015-02-12',
			editable: true,
                        selectable: true,
			selectHelper: true,
                        callback: function(){
//                                alert(123);
                        },                        
			select: function(start, end) {
                                  var event = {
                                      title:'',
                                      end:end,
                                      start:start,
                                      repeat:0,
                                      repeat_day:0,
                                      allday:0
                                  };
                                  eventClick(event,"Создать событие","newEvent");
			},
			eventLimit: true, 
			events: '/php/get_events.php',
                        eventClick: function(calEvent, jsEvent, view) {
//                            calEvent.allday = 0;
                            eventClick(calEvent,"Редактирование события","updateEvent");
//                            $(this).css('border-color', 'red');

                        },                  
                        eventDragStart: function(event, jsEvent, ui, view) {
                            console.log(ui);
                        },
                        eventDrop: function(event, delta, revertFunc,ev) {
                            if (ev.ctrlKey){
                                event.start=event.start.format();
                                event.end=event.end.format();
                                $.ajax({
                                    url: '/php/dbcore.php?action=newEvent',
                                    type: 'post',
                                    data: {event:JSON.stringify(event)}
                                }).success(function (data){
                                    console.log(data);                                        
                                    $('#calendar').fullCalendar( 'refetchEvents' );
                                    
                                });    
                                revertFunc();
                            }
//                            alert(event.title + " was dropped on " + event.start.format());
                            if (event.repeat!='1'){
                                $.ajax({
                                    url: '/php/dbcore.php?action=updateEvent',
                                    type: 'post',
                                    data: {event:JSON.stringify(event)}
                                }).success(function (data){
                                    console.log(data);
                                });
                            }else{
                                revertFunc();
                            }

                        },
                        eventResize: function(event, delta, revertFunc) {

                            $.ajax({
                                url: '/php/dbcore.php?action=updateEvent',
                                type: 'post',
                                data: {event:JSON.stringify(event)}
                            }).success(function (data){
                                console.log(data);
                            });

                        },
                        eventRender: function(event, element) {
//                            console.log(event);
                        }                        
		});

                function eventClick(event,title,type){       
//                    console.log(event.end);
                    bootbox.dialog({
                            title:  '<i class="glyphicon glyphicon-calendar"></i> '+ title,
                            message: '<div class="row">  ' +
                                        '<div class="col-md-12"> ' +
                                        '<form class="form-horizontal"> ' +
                                            '<div class="form-group"> ' +
                                                '<label class="col-md-3 control-label" for="name">Событие:</label> ' +
                                                '<div class="controls col-md-7"> ' +
                                                    '<input type="text" min="3" class="form-control" name="event_title" id="event_title" placeholder="Заголовок" value="'+(event!=null ?  ($.inArray('title',event) ? event.title : "") : "")+'">'+   
//                                                    '<p class="help-block">Ошибка</p>'+
                                                    '<div class="checkbox">'+
                                                        '<label>'+
                                                            '<input id="all_day" type="checkbox" '+ (event!=null ?  (event.allday ? "checked" : "") : "") +'><span class="checkbox-material"><span class="check"></span></span> Весь день'+
                                                        '</label>'+
                                                    '</div>'+                                                                  
                                                '</div> ' +
                                            '</div>' +
                                            '<div class="form-group time"> ' +
                                                '<label class="col-md-3 control-label" for="name">Начало:</label> ' +
                                                '<div class="col-md-7"> ' +
                                                    '<input type="text" class="form-control" id="startdate" placeholder="Начало">'+                                                              
                                                '</div> ' +
                                            '</div>' +
                                            '<div class="form-group time"> ' +
                                                '<label class="col-md-3 control-label" for="name">Конец:</label> ' +
                                                '<div class="col-md-7"> ' +
                                                    '<input type="text" class="form-control" id="enddate" placeholder="Конец">'+                                                                 
                                                '</div> ' +
                                            '</div>' +
                                            '<div class="form-group"> ' +
                                                '<label class="col-md-3 control-label" for="name">Задача:</label> ' +
                                                '<div class="col-md-7"> ' +
                                                    '<select class="input-large combobox">'+
                                                      '<option value="ftpupload">FTP Загрузка</option>'+
                                                      '<option value="stream2text">Речь в текст</option>'+
                                                      '<option value="searchwords">Поиск слов</option>'+
                                                    '</select>'+                                                          
                                                '</div> ' +
                                            '</div>' +
                                            '<div class="form-group select"> ' +
                                                '<label class="col-md-3 control-label" for="name"></label> ' +
                                                '<div class="col-md-7"> ' +
                                                    '<table data-height="155" id="ftptable"></table>'+ 
                                                    '<a href="/user/ftp/">Перейти к настройке FTP</a>'+
                                                '</div> ' +
                                            '</div>' +
                                            '<div class="form-group"> ' +
                                                '<label class="col-md-3 control-label" for="name">Расписание:</label> ' +
                                                '<div class="col-md-7"> ' + 
                                                    '<div class="checkbox">'+
                                                        '<label>'+
                                                            '<input id="repeat_event" type="checkbox" '+ (event!=null ?  (event.repeat!=0 ? "checked" : "") : "") +'><span class="checkbox-material"><span class="check"></span></span> Повторяющееся'+
                                                        '</label>'+
                                                    '</div>'+      
                                                '</div> ' +
                                            '</div>' +
                                            '<div class="form-group week"> ' +
                                                '<label class="col-md-3 control-label" for="name">По дням:</label> ' +
                                                '<div class="col-md-7"> ' +
                                                    '<div class="checkbox">'+
                                                        '<label>'+
                                                            '<span>ПН</span></br>'+
                                                            '<input type="checkbox" ><span class="checkbox-material"><span class="check"></span></span>'+
                                                        '</label>'+
                                                        '<label>'+
                                                            '<span>ВТ</span></br>'+
                                                            '<input type="checkbox" ><span class="checkbox-material"><span class="check"></span></span>'+
                                                        '</label>'+
                                                        '<label>'+
                                                            '<span>СР</span></br>'+
                                                            '<input type="checkbox" ><span class="checkbox-material"><span class="check"></span></span>'+
                                                        '</label>'+
                                                        '<label>'+
                                                            '<span>ЧТ</span></br>'+
                                                            '<input type="checkbox" ><span class="checkbox-material"><span class="check"></span></span>'+
                                                        '</label>'+
                                                        '<label>'+
                                                            '<span>ПТ</span></br>'+
                                                            '<input type="checkbox" ><span class="checkbox-material"><span class="check"></span></span>'+
                                                        '</label>'+
                                                        '<label>'+
                                                            '<span>СБ</span></br>'+
                                                            '<input type="checkbox" ><span class="checkbox-material"><span class="check"></span></span>'+
                                                        '</label>'+
                                                        '<label>'+
                                                            '<span>ВС</span></br>'+
                                                            '<input type="checkbox" ><span class="checkbox-material"><span class="check"></span></span>'+
                                                        '</label>'+
                                                    '</div>'+                                                                     
                                                '</div> ' +
                                            '</div>' +
                                      '</form> </div>  </div>',
                            buttons: {
                                danger: {
                                    label: "Удалить"
,                                       className: "btn-danger",
                                        callback: function () {
                                            $.ajax({
                                                url: '/php/dbcore.php?action=delEvent',
                                                type: 'post',
                                                data: {id:event.id}
                                            }).success(function (data){
                                                $('#calendar').fullCalendar( 'refetchEvents' );
                                            });
                                        }
                                },                                            
                                success: {
                                    label: "Сохранить"
,                                       className: "btn-success",
                                        callback: function () {
                                            event.start = ($('#startdate').data("DateTimePicker").getDate()).format();                                            
                                            if (event.allday!=0){
                                                event.end=null;
                                            }else{
                                                event.end = ($('#enddate').data("DateTimePicker").getDate()).format();
                                            }                  
                                            event.allday = $('#all_day').prop('checked')? 1:0;
                                            event.title = $('#event_title').val();
                                            event.repeat = $('#repeat_event').prop('checked')? 1:0;
                                            event.repeatday = '';
                                            $('.week input').each(function (index){
                                                if ($(this).prop('checked')){
                                                    event.repeatday+=index+1+',';
                                                }
                                            });
                                            event.repeatday = event.repeatday.substring(0, event.repeatday.length - 1);
                                            $.ajax({
                                                url: '/php/dbcore.php?action='+type,
                                                type: 'post',
                                                data: {event:JSON.stringify(event)}
                                            }).success(function (data){
//                                                console.log(data);                                                                          
                                                $('#calendar').fullCalendar( 'refetchEvents' );
                                                if (type=='newEvent'){
                                                    $.snackbar({timeout: 8500,htmlAllowed: true,content: '<i class="glyphicon glyphicon-ok"></i>&nbsp;Успешно добавлено событие <a href="javascript:goToEvent(\''+event.start+'\');" on click="">'+event.title+'</a>'});
                                                }else{
                                                    $.snackbar({timeout: 8500,htmlAllowed: true,content: '<i class="glyphicon glyphicon-ok"></i>&nbsp;Успешно обновленно событие <a href="javascript:goToEvent(\''+event.start+'\');" on click="">'+event.title+'</a>'});
                                                }
                                            });
                                        }
                                }
                            }
                        }).on("shown.bs.modal", function(e) {         
                            $('#ftptable').bootstrapTable({
                                url: '/php/dbcore.php?action=getFtp',
                                columns: [{checkbox:true},{
                                    field: 'id',
                                    title: '#',
                                    sortable:true
                                }, {
                                    field: 'host',
                                    title: 'Сервер',
                                    sortable:true
                                }],
//                                search: true,
                    //            checkbox:true,
//                                strictSearch: true,
                                clickToSelect: true,
//                                singleSelect: true
//                                detailView : true
                            });                        
                            $("input").not("[type=submit]").jqBootstrapValidation();
                            var pick_time = function () {             
                                if ($('#startdate').data('DateTimePicker')!=null){
                                    $('#startdate').data('DateTimePicker').destroy();
                                    $('#enddate').data('DateTimePicker').destroy();
                                }                                            
                                $('#startdate').mask('99:99').datetimepicker({defaultDate: start,language:'ru',pickDate: false,pickTime: true});
                                $('#enddate').mask('99:99').datetimepicker({defaultDate: end,language:'ru',pickDate: false,pickTime: true});                                            
                            };
                            var pick_all = function () {
                                if ($('#startdate').data('DateTimePicker')!=null){
                                    $('#startdate').data('DateTimePicker').destroy();
                                    $('#enddate').data('DateTimePicker').destroy();
                                }
                                $('#startdate').mask('99.99.9999 99:99').datetimepicker({defaultDate: start,language:'ru',pickTime: true});                                            
                                $('#enddate').mask('99.99.9999 99:99').datetimepicker({defaultDate: end,language:'ru',pickTime: true});                                          
                            };                            
                            var start = event.start;
                            var end = event.end;
                            
                            if (event!=null){
                                if (event.repeat!=0){
                                    $('.week').show();
                                    if (event.repeat_day!=0){
                                        var week = event.repeat_day;
                                        week = week.split(',');
                                        $('.week input').each(function (index){
                                            console.log($.inArray(index+1+'',week));
                                            if ($.inArray(index+1+'',week)>=0){
                                                $(this).prop('checked',true);
                                            }
                                        });                                        
                                    }
                                }
                                if(event.allDay){
                                    $('.week input').prop('disabled','disabled'); 
                                    $('#all_day').prop('checked',true);
                                }
                            }else{
                                end.add(-1,'S');
                            }
                            pick_all();
                            $('#all_day').change(function (){
                                if ($(this).prop("checked")){
                                    $('.time input').prop('disabled','disabled');                                    
                                }else{
                                    $('.time input').prop('disabled','');
                                    pick_all();
                                }
                            });
                            $('#repeat_event').change(function (){
                                if ($(this).prop("checked")){
                                    $('.week').show();
//                                    pick_time();
                                }else{
                                    $('.week').hide();
//                                    pick_all();
                                }
                            });
                        });                    
                }
            function goToEvent(date){
                $('#calendar').fullCalendar( 'changeView', 'agendaDay');
                $('#calendar').fullCalendar( 'gotoDate', date);
            }
</script>



<!--<div class="header col-lg-12">

        <div class="pull-right form-inline">
                <div class="btn-group">
                        <button class="btn btn-primary" data-calendar-nav="prev"><< Назад</button>
                        <button class="btn btn-default" data-calendar-nav="today">Сегодня</button>
                        <button class="btn btn-primary" data-calendar-nav="next">Вперед >></button>
                </div>
                <div class="btn-group">
                        <button class="btn btn-warning" data-calendar-view="year">Год</button>
                        <button class="btn btn-warning active" data-calendar-view="month">Месяц</button>
                        <button class="btn btn-warning" data-calendar-view="week">Неделя</button>
                        <button class="btn btn-warning" data-calendar-view="day">День</button>
                </div>
        </div>

        <h3></h3>
</div>
<div class="col-lg-12">
    <div id="calendar"></div>
    <script type="text/javascript">
	var options = {
		events_source: '/php/get_events.php',
		view: 'month',
                language: 'ru-RU',
		tmpl_path: '/bower_components/bootstrap-calendar-master/tmpls/',
		tmpl_cache: false,
		//day: '2013-03-12',
		onAfterEventsLoad: function(events) {
			if(!events) {
				return;
			}
			var list = $('#eventlist');
			list.html('');

			$.each(events, function(key, val) {
				$(document.createElement('li'))
					.html('<a href="' + val.url + '">' + val.title + '</a>')
					.appendTo(list);
			});
		},
		onAfterViewLoad: function(view) {
			$('.header h3').text(this.getTitle());
			$('.btn-group button').removeClass('active');
			$('button[data-calendar-view="' + view + '"]').addClass('active');
		},
		classes: {
			months: {
				general: 'label'
			}
		}
	};        
        var calendar = $("#calendar").calendar(options);         
	$('.btn-group button[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
		});
	});        
	$('.btn-group button[data-calendar-view]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.view($this.data('calendar-view'));
		});
	});        
    </script>
</div>-->