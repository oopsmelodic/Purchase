window.operateEvents = {
    'click .control': function (e, value, row, index) {
        //alert(row['id']);
        $.ajax({
            url:'/php/core.php?method=signIom',
            type: 'POST',
            dataType:'json',
            data:{id: row['id'],type:$(this).html()}
        }).success(function (data){
            $('#testtable').bootstrapTable('refresh');
        });
    }
};

$(document).ready(function () {

    $('#summernote').summernote();

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
        url: '/php/core.php?method=getAllIoms',
        columns: [{
            field: 'id',
            title: '# IOM',
            sortable:true
        }, {
            field: 'name',
            title: 'Name:',
            sortable:true
        },{
            field: 'latest_action',
            title: 'Latest Action:',
            sortable:true
            //filterControl:'select'
        },{
            field: 'status',
            title: 'Status:',
            sortable:true
        },{
            title:'Controls:',
            align: 'center',
            events: operateEvents,
            formatter: function(id,data){
                console.log(data.sign_status);
                var controls='';
                if (data.sign_status==1){
                    controls = '<div><button class="btn btn-success control">Confirm</button><button class="btn btn-danger control">Cancel</button></div>'
                }
                return controls;
            }
        }],
        search: true,
        strictSearch: true,
        detailView : true,
        showRefresh:true,
        //groupBy:true,
        //groupByField:['status'],
        detailFormatter: function (index, row){
            var div = $('<div class="col-lg-12"></div>');
            div.append('<div class="col-lg-6">' +
                        '<h5><span class="label label-primary">Cost Item: </span>&nbsp; '+row["budget_fullname"]+'</h5>' +
                        '<h5><span class="label label-primary">Cost Size: </span>&nbsp; '+row["actualcost"]+'</h5>' +
                        '<span class="label label-primary">Substantation: </span><br><textarea id="summer_'+index+'" readonly="readonly">'+row["substantation"]+'</textarea>' +
                    '</div>');
            div.append('<div class=col-lg-6>' +
                        '<span class="label label-primary">Signers: </span>' +
                        '<table id="signers_'+index+'"></table>' +
                    '</div>');

            return div.html();
        }
    }).on('load-success.bs.table',function (data){
        //console.log(data);
    }).on('expand-row.bs.table',function (event,index,row){
        $('#summer_'+index).summernote({
            shortcuts: false
        });
        $('#summer_'+index).code(row['substantation']);
        $('#signers_'+index).bootstrapTable({
            url: '/php/core.php?method=getIomSigners',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            queryParams: function (p){
                return {
                    "iom_id":row['id']
                }
            },
            columns: [{
                field: 'id',
                title: '#',
                formatter: function(id,data,index){
                    return index+1;
                }
            }, {
                field: 'fullname',
                title: 'Name:',
                //sortable:true
            },{
                field: 'status',
                title: 'Status:',
                //sortable:true
                //filterControl:'select'
            }],
        });
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
        var sign_chain = [];

        //Make Chain
        $('#chain_list select').each(function (index,item){
            sign_chain.push($(item).selectpicker('val'));
        });
        sign_chain = JSON.stringify(sign_chain);
        $.ajax({
            url:'/php/core.php?method=addIomReq',
            type:'POST',
            dataType:'json',
            data:{
                employee_id: $('#user_id').attr('user_id') || 0,
                department_id: $('#department_id').attr('department_id') || 0,
                budget_id: $('#budget_select').selectpicker('val') || [],
                purchase_text: $('#purchase_text').val() || 'Empty',
                substantiation_text:  $("#summernote").code(),
                sign_chain: sign_chain
            }
        }).success(function (data){
            console.log(data);
        });
    });
});
function personOK(button) {

    if ($(button).hasClass("btn-success")) {
        if ($(button).parents('.list-group-item').find('.selectpicker').selectpicker('val') != null) {
            $(button).parents('.list-group-item').addClass('active');
            $(button).parents('.list-group-item').find('.selectpicker').prop('disabled', true).selectpicker('refresh');
            $(button).parents('.list-group-item').find('.personOK').find('.glyphicon').addClass('glyphicon-remove').removeClass('glyphicon-plus');
            $(button).addClass('btn-warning').removeClass('btn-success');
        }
    }
    else if ($(button).hasClass("btn-warning")) {
        $(button).parents('.list-group-item').removeClass('active');
        $(button).parents('.list-group-item').find('.selectpicker').prop('disabled', false).selectpicker('refresh');
        $(button).parents('.list-group-item').find('.personOK').find('.glyphicon').addClass('glyphicon-plus').removeClass('glyphicon-remove');
        $(button).addClass('btn-success').removeClass('btn-warning');
//        $('#createpurch').removeClass('disabled');
    }

}