<link href="/css/jqueryFileTree.css"  rel="stylesheet">  
<script src="/js/jqueryFileTree.js"></script>
<link href="/bower_components/DataTables-1.10.7/media/css/jquery.dataTables.min.css"  rel="stylesheet">  
<script src="/bower_components/DataTables-1.10.7/media/js/jquery.dataTables.min.js"></script>
<script>    
    $(document).ready( function() {
        $('#table').bootstrapTable({
            url: '/php/dbcore.php?action=getFtp',
            columns: [{checkbox:true},{
                field: 'id',
                title: '#',
                sortable:true
            }, {
                field: 'host',
                title: 'Сервер',
                sortable:true
            },{
                field: 'login', 
                title: 'Логин',
                sortable:true
                //filterControl:'select'
            },{
                field: 'password',
                title: 'Пароль',
                sortable:true
            }],
            search: true,
//            checkbox:true,
            strictSearch: true,
            clickToSelect: true,
            singleSelect: true,
            detailView : true,   
            
            toolbar: '<div><button id="append_ftp" type="button" class="btn btn-primary btn-sm glyphicon glyphicon-plus"></button><button id="edit_btn" class="btn btn-info btn-sm glyphicon glyphicon-edit"></button><button class="btn btn-danger btn-sm glyphicon glyphicon-trash"></button></div>'
        }).on('expand-row.bs.table',function (event,index,row,$el){
            $el.html('<div id="container_'+index+'"></div>');
            $('#container_'+index).fileTree({
                host: row.host,
                login: row.login,
                password: row.password,
                id:row.id,
                root_dir: '',
                script: '/php/ftp_show.php',
                expandSpeed: 1000,
                collapseSpeed: 1000,
                multiSelect:true,
                onlyFolders: true,
                multiFolder: false
            }, function(file) {
//                alert(file);
            }, function (){
                var checked = new Array();
                $el = $( '#container_'+index+" input");
                if( $el.length === 0 )
                {
                    alert('No elements selected.');
                }
                else {
                    $el.each(function (){
                        checked.push({'path':$(this).parent().find('a').prop('rel'),'ch':$(this).prop('checked')});
                    });
                } 
                $.ajax({
                    url:'/php/dbcore?action=updateFtpData',
                    type:'post',
                    data:{ftp_id:row.id,checked:JSON.stringify(checked)}
                }).success(function (data){
                    console.log(data);
                });
            });            
        }).on('click-row.bs.table',function (event,row,$el){
//            $('#table .icon-minus').click();
//            console.log($($el).find('i'));
//            $($el).find('.icon-plus').click();
        }).on('load-success.bs.table',function (event,row,$el){
             $('#append_ftp').off('click').on('click', function (){
                bootbox.dialog({
                        title: '<i class="glyphicon glyphicon-transfer"></i> Новый FTP',
                        message: '<div class="row">  ' +
                                    '<div class="col-md-12"> ' +
                                    '<form class="form-horizontal"> ' +
                                        '<div class="form-group"> ' +
                                            '<label class="col-md-2 control-label" for="name">FTP</label> ' +
                                            '<div class="col-md-7"> ' +
                                                '<input type="text" class="form-control" name="ftp_host" id="ftp_host" placeholder="Хост" value="">'+
                                                '<input type="text" class="form-control" name="ftp_login" id="ftp_login" placeholder="Пользователь" value="">'+
                                                '<input type="text" class="form-control" name="ftp_password" id="ftp_password" placeholder="Пароль" value="">'+
                                            '</div> ' +

                                        '</div>' +
                                  '</form> </div>  </div>',
                        buttons: {
                            success: {
                                label: "Сохранить",
                                className: "btn-success",
                                callback: function () {
                                    var host = $('#ftp_host').val();
                                    var login = $('#ftp_login').val();
                                    var password = $('#ftp_password').val();
                                    $.ajax({
                                       url: '/php/dbcore.php?action=newFtp',
                                       type: 'post',
                                       data: {ftp_host:host,ftp_login:login,ftp_password:password}
                                    }).success(function (){
                                        $('#table').bootstrapTable('refresh',{silent:true});
                                    });
                                }
                            }
                        }
                    }).on("shown.bs.modal", function(e) {

                    });                 
             });
             $('#edit_btn').off('click').on('click', function (){
                var selections = $('#table').bootstrapTable('getSelections');                
                if (selections!=null){
                    var select = selections[0];
//                    console.log(select);
                    bootbox.dialog({
                            title: '<i class="glyphicon glyphicon-transfer"></i> Изменить запись # '+select.id,
                            message: '<div class="row">  ' +
                                        '<div class="col-md-12"> ' +
                                        '<form class="form-horizontal"> ' +
                                            '<div class="form-group"> ' +
                                                '<label class="col-md-2 control-label" for="name">FTP</label> ' +
                                                '<div class="col-md-7"> ' +
                                                    '<input type="text" class="form-control" name="ftp_host" id="ftp_host" placeholder="Хост" value="'+select.host+'">'+
                                                    '<input type="text" class="form-control" name="ftp_login" id="ftp_login" placeholder="Пользователь" value="'+select.login+'">'+
                                                    '<input type="text" class="form-control" name="ftp_password" id="ftp_password" placeholder="Пароль" value="'+select.password+'">'+
                                                '</div> ' +
                                                
                                            '</div>' +
                                      '</form> </div>  </div>',
                            buttons: {
                                success: {
                                    label: "Сохранить",
                                    className: "btn-success",
                                    callback: function () {
                                        var host = $('#ftp_host').val();
                                        var login = $('#ftp_login').val();
                                        var password = $('#ftp_password').val();
                                        $.ajax({
                                           url: '/php/dbcore.php?action=newFtp',
                                           type: 'post',
                                           data: {ftp_host:host,ftp_login:login,ftp_password:password,ftp_id:select.id}
                                        }).success(function (){
                                            $('#table').bootstrapTable('refresh',{silent:true});
                                        });
                                    }
                                }
                            }
                        }).on("shown.bs.modal", function(e) {

                        });
                }
             });
        });            
//                                        $('#test').on('click', function(){
//                                        $el = $( "#container_id input:checked");
//                                        if( $el.length === 0 )
//                                        {
//                                                alert('No elements selected.');
//                                        }
//                                        else {
//                                                var checked = $el
//                                                        .map(function() {
//                                                                return $(this).parent().find('a:first').attr('rel');
//                                                        })
//                                                        .get()
//                                                        .join(', ');
//                                                alert(checked);
//                                        }
//                                }); 
        //$("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
        //alert(213);
//        $('#append_ftp').click(function (){
//            if (!$('.new_ftp').hasClass('in')){
//                $(this).addClass('disabled');
//                $('.new_ftp').addClass('in');
//                $('.new_ftp').find('.btn-success').click(function (){
////                    $('.new_ftp').removeClass('in');
//                    $('.chose_data').addClass('in');
//                    $('#container_id').html('').fileTree({
//                        host: $('#ftp_host').val(),
//                        login: $('#ftp_login').val(),
//                        password: $('#ftp_password').val(),
//                        root_dir: $('#ftp_root').val(),
//                        script: '/php/ftp_show.php',
//                        expandSpeed: 1000,
//                        collapseSpeed: 1000,
//                        multiSelect:true,
//                        multiFolder: false
//                    }, function(file) {
//                        alert(file);
//                    });            
//                });                
//            }
//        });
    });    
</script>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Настройки загрузки по FTP</h3>
    </div>
    <div class="panel-body">     
<!--        <div class="col-lg-2">
            <label>Новый FTP</label>
            <input type="text" class="form-control" name="ftp_host" id="ftp_host" placeholder="Хост" value="10.129.15.113">
            <input type="text" class="form-control" name="ftp_login" id="ftp_login" placeholder="Пользователь" value="customer">
            <input type="text" class="form-control" name="ftp_password" id="ftp_password" placeholder="Пароль" value="Qwerty123">
            <input type="text" class="form-control" name="ftp_root" id="ftp_root" placeholder="Корень" value="/">
            <button  type="button" class="btn btn-success ">Добавить</button>    
            <button type="button" class="btn btn-danger ">&nbsp;Отмена&nbsp;&nbsp;</button>    
            <label>Просмотр</label>
            <div  id="container_id"></div>            
        </div>-->
        <div class="col-lg-12">
            <table id="table"></table>
        </div>
        
<!--        <div class="form-group">
            <label for="button" class="col-lg-2 control-label">FTP</label>
            <div class="col-lg-10">
                У вас нет добавленных FTP <button id="append_ftp" type="button" class="btn btn-primary glyphicon glyphicon-plus"></button>
            </div>
        </div>     
        Панель FTP (END)                    
        <div class="new_ftp form-group collapse">
            <label for="button" class="col-lg-2 control-label">Новый FTP</label>
            <div class="col-lg-5">
                <input type="text" class="form-control" name="ftp_host" id="ftp_host" placeholder="Хост" value="10.129.15.113">
                <input type="text" class="form-control" name="ftp_login" id="ftp_login" placeholder="Пользователь" value="customer">
                <input type="text" class="form-control" name="ftp_password" id="ftp_password" placeholder="Пароль" value="Qwerty123">
                <input type="text" class="form-control" name="ftp_root" id="ftp_root" placeholder="Корень" value="/">
                <button  type="button" class="btn btn-success">Добавить</button>    
                <button type="button" class="btn btn-danger">&nbsp;Отмена&nbsp;&nbsp;</button>                       
            </div>
            <div class="col-lg-5"> 
                <div class="chose_data form-group collapse">
                    <div  id="container_id"  class="col-lg-5">
                    </div>
                </div>                            
            </div>
        </div>                      -->
    </div>                
</div>