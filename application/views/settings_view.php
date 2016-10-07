<?php  extract($data['user']) ?>
<link href="/css/jqueryFileTree.css"  rel="stylesheet">  
<script src="/js/jqueryFileTree.js"></script>
<script>    
    $(document).ready( function() {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
        //alert(213);
        $('#append_ftp').click(function (){
            if (!$('.new_ftp').hasClass('in')){
                $(this).addClass('disabled');
                $('.new_ftp').addClass('in');
                $('.new_ftp').find('.btn-success').click(function (){
//                    $('.new_ftp').removeClass('in');
                    $('.chose_data').addClass('in');
                    $('#container_id').html('').fileTree({
                        host: $('#ftp_host').val(),
                        login: $('#ftp_login').val(),
                        password: $('#ftp_password').val(),
                        root_dir: $('#ftp_root').val(),
                        script: '/php/ftp_show.php',
                        expandSpeed: 1000,
                        collapseSpeed: 1000,
                        multiSelect:true,
                        multiFolder: false
                    }, function(file) {
                        alert(file);
                    });            
                });                
            }
        });
    });    
</script>
<div class="col-lg-12">
    <form class="form-horizontal col-lg-10" method="post" action="/user/settingsUpdate">
        <fieldset>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Основные настройки пользователя</h3>
                </div>
                <div class="panel-body">                   
                    <div class="form-group">
                        <div class="col-lg-10">
                            <label for="textArea" class="col-lg-2 control-label"></label>
                            <div class="togglebutton">
                                <label>
                                    <input name="search_word" id="search_word" type="checkbox" <?php if($search_word){echo "checked";} ?> ><span class="toggle"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textArea" class="col-lg-2 control-label">Список</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" name="words" id="words"><?php echo $words ?></textarea>
                            <script>
                                $("#words").bind("keyup", function(e) {     
                                    console.log(e);
                                    var cursorPosition = $('textarea').prop("selectionStart");
                                    var text = $(this).val();
                                    text = text.replace(/,$/g, "").replace(/\s/g, ",");                            
                                    $(this).val(text);
                                });
                            </script>
                            <span class="help-block">Для разделения слов использовать "пробел".</span>
                        </div>
                    </div>   
                    <div class="form-group">
                        <label for="textArea" class="col-lg-2 control-label"></label>
                        <div class="col-lg-10">                                                        
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"><span class="checkbox-material"><span class="check"></span></span> Использовать FTP
                                </label>
                            </div>    
                        </div>
                    </div>                     
                </div>                
            </div>

<!--            <div class="form-group">
                <label for="login" class="col-lg-2 control-label">Хост</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="ftp_host" id="ftp_host" placeholder="Хост" value="<?php echo $login ?>">
                </div>
            </div>            
            <div class="form-group">
                <label for="login" class="col-lg-2 control-label">Имя</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="ftp_login" id="ftp_login" placeholder="Имя" value="<?php echo $login ?>">
                </div>
            </div>            
            <div class="form-group">
                <label for="login" class="col-lg-2 control-label">Пароль</label>
                <div class="col-lg-10">
                    <input type="password" class="form-control" name="ftp_pwd" id="ftp_pwd" placeholder="Пароль" value="<?php echo $login ?>">
                </div>
            </div>            
            <div class="form-group">
                <label for="login" class="col-lg-2 control-label">FTP:</label>
                <div  id="container_id"  class="col-lg-10">
                </div>
            </div>            -->
            <div id="form_end" class="col-lg-10 col-lg-offset-2">                
                <button type="submit" class="btn btn-success">Сохранить<div class="ripple-wrapper"></div></button>
                <a href="/user" class="btn btn-default">Назад</a>
            </div>
        </fieldset>
    </form>
</div>