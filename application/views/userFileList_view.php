<script>

    $('#files').addClass('active');
//    var filelistHeaders = new Array({"id": 0, "name": "id", "title": "№"},
//    {"id": 1, "name": "name", "title": "Имя"},
//    {"id": 2, "name": "date_upload", "title": "Дата/Время"},
//    {"id": 3, "name": "status", "title": "Статус"});
//    $("#filelist").myTreeView({
//        url: '/php/dbcore.php?action=loadfilelist',
//        headers: filelistHeaders,
//        dblclick: function () {
//            id = $('#filelist').myTreeView('getSelected').id;
//            window.location = "http://"+host+"/user/show/"+id;
//        }
//    });  
    $(document).ready( function() {
        $('#table').bootstrapTable({
            url: '/php/dbcore.php?action=loadfilelist',
            columns: [{
                field: 'id',
                title: '#',
                sortable:true
            }, {
                field: 'title',
                title: 'Заголовок',
                sortable:true
            },{
                field: 'date_upload',
                title: 'Время загрузки',
                sortable:true
                //filterControl:'select'
            },{
                field: 'status',
                title: 'Статус',
                sortable:true
            },{
                field: 'public_url',
                title: 'Общий доступ'
//                sortable:true
            },{
                field: 'url',
                title: 'Ссылка'
            }],
            search: true,
            strictSearch: true,
            detailView : true,
            detailFormatter: function (index, row){
                var str = "<small><p><b>Тип : </b>"+row['type']+"</p></small>";
                str += "<small><p><b>Длительность: </b>"+toHHMMSS(row['length_record'])+"</p></small>";
                str += "<small><p><b>Ключевые слова: </b></br>"+row['tags']+"</p></small>";
//                str += $('<div></div>').append('<button class="btn btn-primary">Кнопка</button>').html();
                return str;
            }
        }).on('dbl-click-row.bs.table',function (el,row){
            window.location = "http://"+window.location.hostname+"/user/show/"+row.id;
        });        
    });
</script>
<table id="table"></table>