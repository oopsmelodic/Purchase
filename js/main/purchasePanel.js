var roles = ["General director", "Financial director", "Financial controller", "Financial", "Department leader", "Initiator"];
$(document).ready(function () {
    $('.selectpicker').selectpicker();
    //getUsersJSON();
    $('#summernote').summernote({height: 300});
    $('.personOK').click(function (event) {
        event.preventDefault();
        if (event.target.nodeName == "BUTTON")
            personOK(event.target);
        else
            personOK($(event.target).parent());
    });


    //test table

    $('#testtable').bootstrapTable({
        url: '/php/getUsers.php',
        columns: [{
            field: 'id',
            title: '#',
            sortable:true
        }, {
            field: 'fullname',
            title: 'Заголовок',
            sortable:true
        },{
            field: 'role',
            title: 'Время загрузки',
            sortable:true
            //filterControl:'select'
        },{
            field: 'department',
            title: 'Статус',
            sortable:true
        }],
        search: true,
        strictSearch: true,
        detailView : false,
        groupBy:true,
        groupByField:['department']
    }).on('dbl-click-row.bs.table',function (el,row){

    });
});
function personOK(button)
{

    if ($(button).hasClass("btn-success"))
    {
        $(button).parents('.list-group-item').addClass('active');
        $(button).parents('.list-group-item').find('.selectpicker').prop('disabled', true).selectpicker('refresh');
        $(button).parents('.list-group-item').find('.personOK').find('.glyphicon').addClass('glyphicon-remove').removeClass('glyphicon-plus');
        $(button).addClass('btn-warning').removeClass('btn-success');

    }
    else if ($(button).hasClass("btn-warning"))
    {
        $(button).parents('.list-group-item').removeClass('active');
        $(button).parents('.list-group-item').find('.selectpicker').prop('disabled', false).selectpicker('refresh');
        $(button).parents('.list-group-item').find('.personOK').find('.glyphicon').addClass('glyphicon-plus').removeClass('glyphicon-remove');
        $(button).addClass('btn-success').removeClass('btn-warning');

//        $('#createpurch').removeClass('disabled');
    }
}