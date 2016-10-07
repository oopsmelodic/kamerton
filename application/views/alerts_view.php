<legend>Уведомления:</legend>
<div id="table">
    
</div>
<script>
var host = "<?php echo $_SERVER['HTTP_HOST']; ?>";
var alertHeaders = new Array({"id": 0, "name": "id", "title": "№"},
                    {"id": 1, "name": "fileid", "title": "№ Файла"},
                    {"id": 1, "name": "title", "title": "Заголовок Файла"},
                    {"id": 1, "name": "word", "title": "Слово"},
                    {"id": 1, "name": "timestart", "title": "Время начала в с."},
                    {"id": 2, "name": "when", "title": "Когда"});                
                $("#table").myTreeView({
                    url: '/php/dbcore.php?action=checkMsg',
                    headers: alertHeaders,
                    dblclick: function() {
                        id = $('#table').myTreeView('getSelected').fileid;
                        timestart = $('#table').myTreeView('getSelected').timestart;
                        window.location = "http://"+host+"/user/show/"+id+"/"+timestart;                        
                    }
                });                
</script>