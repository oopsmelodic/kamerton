$(function (){
    $('#datetimepicker1').mask('99.99.9999').datetimepicker({language:'ru',pickTime: false});
    
    $('#findbtn').click(function (e){
        if ($('#lname').val()!='' && $('#fname').val()!='' && $('#datetimepicker1').data("DateTimePicker").getDate()._i!=null){
            $('#main-content').html("");            
            date= $('#datetimepicker1').data("DateTimePicker").getDate()._i.split('.');
            console.log(date);
            $.ajax({
                url:'php/search.php',
                type:'GET',
                dataType:'json',
                data:{fname:$('#fname').val(),lname:$('#lname').val(),day:date[0],month:date[1],year:date[2]}
            }).success(function (data){           
               console.log(data);
               if (data['body']!=null){
                    $('#main-content').html(data['body']);
                    $('.circle').circliful();
                    $('.media-body').readmore({
                        moreLink: '<a href="#">Показать все поля</a>',
                        collapsedHeight:166
                    });
                    $('.summary-data').readmore({
                        moreLink: '<a href="#">Социальный граф</a>',
                        collapsedHeight:0
                    });
//                    var elementPosition = $('.social_graph').offset();
//                    $(window).off('scroll');
//                    $(window).scroll(function(){
//                            if($(window).scrollTop() > elementPosition.top){
//                                  $('.social_graph').css('position','fixed').css('top','0');
//                            } else {
//                                $('.social_graph').css('position','static');
//                            }    
//                    });                    
               }else{
                   swal('Ничего нет','Поиск по вашему запросу не дал результатов','warning');
               } 
            }).error(function (error){
                console.log(error);
                alert('ERROR!');
            });
        }else{
            swal('Ошибка ввода!','Заполните все поля для поиска.','error');
        }
        
    });    
});