var filetypes = {"txt": "text-o", "docx": "word-o", "doc": "word-o", "ptt": "powerpoint-o", "pttx": "powerpoint-o", "zip": "archive-o", "rar": "archive-o", "pdf": "pdf-o", "jpg": "image-o", "png": "image-o", "ttif": "image-o", "xls": "excel-o", "xlsx": "excel-o"};
$(document).ready(function () {
    var iom_id = $('#iom_id').attr('iom_id');
    $('#summernote').summernote({
        shortcuts: false,
        height: 150

    });
    $('#summernote').summernote('disable');

    $('#budgets').bootstrapTable({
        url: '/php/core.php?method=getIomBudgets',
        contentType: 'application/x-www-form-urlencoded',
        method: 'POST',
        queryParams: function (p) {
            return {
                "iom_id": iom_id
            }
        },
        columns: [{
            field: 'budget_name',
            title: 'Name:'
            //sortable:true
        }, {
            field: 'cur_cost',
            title: 'Cost:'
            //sortable:true
            //filterControl:'select'
        }]
    });

    $('#signers').bootstrapTable({
        url: '/php/core.php?method=getIomSigners',
        contentType: 'application/x-www-form-urlencoded',
        method: 'POST',
        queryParams: function (p) {
            return {
                "iom_id": iom_id
            }
        },
        columns: [{
            field: 'id',
            title: '#',
            formatter: function (id, data, index) {
                return index + 1;
            }
        }, {
            field: 'fullname',
            title: 'Name:'
            //sortable:true
        }, {
            field: 'status',
            title: 'Status:'
            //sortable:true
            //filterControl:'select'
        }]
    });

    $.ajax({
        url: '/php/core.php?method=getIomFiles',
        contentType: 'application/x-www-form-urlencoded',
        dataType: 'json',
        method: 'POST',
        data: { "iom_id" : iom_id }
    }).success(function (data) {
        var divHTML='';
        for(var i=0;i<data.length;i++)
        {

            var filepath = data[i]['filepath'].split('/').slice(-2).join('/');
            divHTML+='<div class="col-lg-3" style="padding=5px; margin-bottom:10px;" align="center">'+
                '<div><a class="btn btn-default" href="../' + filepath + '" download="' + data[i]['title'] +'.'+ data[i]['type']+'"><div><i class="fa fa-file-' + filetypes[data[i]['type']] + ' fa-2x"></i></div></a></div>'+
                '<div style="font-size:12px; word-wrap:break-word;">'+data[i]['title']+'</div>'+
                '</div>';
        }
        $('#files').html(divHTML);
        console.log(divHTML);
    });
});