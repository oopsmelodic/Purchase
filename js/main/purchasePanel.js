var roles = ["General director", "Financial director", "Financial controller", "Financial", "Department leader", "Initiator"];
$(document).ready(function () {
    $('.selectpicker').selectpicker();
    //getUsersJSON();
    $('#purchase_form').validate({
        description : {
            test : {
                required : '<div class="error">Required</div>',
                pattern : '<div class="error">Pattern</div>',
                conditional : '<div class="error">Conditional</div>',
                valid : '<div class="success">Valid</div>'
            }
        },
        onSubmit:false,
        onKeyup:true,
        onChange:false
    });
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

    //selects
    $('#budget_select').selectpicker().on('changed.bs.select',function (item,val){
        var selectedOptions= $(this).context.selectedOptions;
        var cur_select = $(this).selectpicker('val');
        if (cur_select!=null) {
            $.each($('#budget_inputs div'), function () {
                var this_id = $(this).attr('id').split("_")[1];
                console.log(cur_select.indexOf(this_id));
                if (cur_select.indexOf(this_id) == -1) {
                    $(this).remove();
                }
            });
            if (cur_select != null) {
                cur_select.forEach(function (item, i, arr) {
                    var data_content = $(selectedOptions[i]).attr('data-content');
                    var input = $('#budget_inputs').find('#bi_' + item).get(0);
                    if ($(input).size() == 0) {
                        $('#budget_inputs').append('<div id="bi_' + item + '"><span class="col-lg-6">' + data_content + '</span>' +
                            '<input class="form-control" type="number" min="0" placeholder="Cost size..." data-required/></div>');
                    } else {
                        //$(input).remove();
                    }
                });
            }
        }else{
            $('#budget_inputs').html('');
        }
    });
    $('#createpurch').click(function (){

        $.ajax({
            url:'/php/sendData.php',
            type:'POST',
            dataType:'',
            data:{
                employee_id: $('#user_id').attr('user_id') || 0,
                department_id: $('#department_id').attr('department_id') || 0,
                budget_id: $('#budget_select').selectpicker('val') || [],
                purchase_text: $('#purchase_text').val() || 'Empty'
                //substantiation_text
            }
        }).success(function (data){
            console.log(data);
        });
    });

});
function personOK(button){

    if ($(button).hasClass("btn-success"))
    {
        if ($(button).parents('.list-group-item').find('.selectpicker').selectpicker('val')!=null) {
            $(button).parents('.list-group-item').addClass('active');
            $(button).parents('.list-group-item').find('.selectpicker').prop('disabled', true).selectpicker('refresh');
            $(button).parents('.list-group-item').find('.personOK').find('.glyphicon').addClass('glyphicon-remove').removeClass('glyphicon-plus');
            $(button).addClass('btn-warning').removeClass('btn-success');
        }
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