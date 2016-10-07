 $(document).ready(function (){     
    $('.regform button[type="button"]').click(function (){
       var form =  $(this).parent('form');
       console.log(form);
      if (form.hasClass('signin')){
          $('.signin').removeClass('animated flipInX').addClass('animated fadeOutLeft').hide();
          $('.newuser').removeClass('animated fadeOutLeft').addClass('animated flipInX').show();
      }else{
          $('.newuser').removeClass('animated flipInX').addClass('animated fadeOutLeft').hide();
          $('.signin').removeClass('animated fadeOutLeft').addClass('animated flipInX').show();          
      }
    });
    $('.chaffle').chaffle({
      speed: 20,
      time: 60
    });    
    
    
    //Пример консоли
    var con = false;
    var cmd = '';
    $(document).keypress(function (e){
        if (e.which==96){
            if ($('#console').css('display') == 'none'){
                $('#console').show();
                
                $('#console').keypress(function (ev){
                    if (ev.which==13){
                        if ($(this).val()!=''){
                            alert($(this).val());
                        }
                    }else{
                        if (ev.which==96){
                            $(this).val('');
                        }
                    }
                });                
//                $('#console').focus();
            }else{
              $('#console').hide();  
              $('input').focus();
            }
        }
    });
 });
 
 