/**
 * Created by melodic on 26.02.2016.
 */
//
//;(function($) {
//    $.fn.fixMe = function() {
//        return this.each(function() {
//            var $this = $(this),
//                $t_fixed;
//            function init() {
//                $this.wrap('<div class="container-fixed" />');
//                $t_fixed = $this.clone();
//                $t_fixed.find("tbody").remove().end().addClass("fixed").insertBefore($this);
//                resizeFixed();
//            }
//            function resizeFixed() {
//                $t_fixed.find("th").each(function(index) {
//                    $(this).css("width",$this.find("th").eq(index).outerWidth()+"px");
//                });
//            }
//            function scrollFixed() {
//                var offset = $(this).scrollTop(),
//                    tableOffsetTop = $this.offset().top,
//                    tableOffsetBottom = tableOffsetTop + $this.height() - $this.find("thead").height();
//                if(offset < tableOffsetTop || offset > tableOffsetBottom)
//                    $t_fixed.hide();
//                else if(offset >= tableOffsetTop && offset <= tableOffsetBottom && $t_fixed.is(":hidden"))
//                    $t_fixed.show();
//            }
//            $(window).resize(resizeFixed);
//            $(window).scroll(scrollFixed);
//            init();
//        });
//    };
//})(jQuery);

function format_money(n) {
    var fixed = parseInt(n);
    return fixed.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")+' ₽';
}


var filetypes = {"txt": "text-o", "docx": "word-o", "doc": "word-o", "ptt": "powerpoint-o", "pttx": "powerpoint-o", "zip": "archive-o", "rar": "archive-o", "pdf": "pdf-o", "jpg": "image-o", "png": "image-o", "ttif": "image-o", "xls": "excel-o", "xlsx": "excel-o"};

window.operateEvents = {
    'click .control': function (e, value, row, index) {
        //alert(row['id']);
        var button = $(this).html();

        if (button!='Restart') {
            swal({
                title: "Are you sure?",
                text: button + " application '" + row['name'] + "'?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    var comment = '';
                    swal({
                        title: "Comment Application?",
                        text: "Write your comment here:",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "Write something",
                        showLoaderOnConfirm: true,
                        showLoaderOnCancel: true
                    }, function(inputValue){
                        //if (inputValue === false) return false;
                        comment = inputValue;
                        $.ajax({
                            url: '/php/core.php?method=signIom',
                            type: 'POST',
                            dataType: 'json',
                            async: true,
                            data: {id: row['id'], type: button , comment : comment}
                        }).success(function (data) {
                            if (data != null) {
                                if (data['type'] == 'success') {
                                    $('#testtable').bootstrapTable('refresh');
                                    if (button == 'Cancel') {
                                        swal("Canceled!", "Application '" + row['name'] + "' has been canceled.", "error");
                                    } else {
                                        swal("Confirmed!", "Application '" + row['name'] + "' has been confirmed.", "success");
                                    }
                                } else {
                                    swal("You can't sign the application form", data['error_msg'], "error");
                                }
                            } else {
                                swal("Request Error!", data['error_msg'], "error");
                            }
                        });
                    });

                } else {
                    //swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
        }else{
            resetForm();
            var iom_id = row['id'];
            //$('.selectpicker').selectpicker('destroy');
            $('.selectpicker').selectpicker('deselectAll');
            $('#purchase_budget_table').bootstrapTable('destroy');
            $('#purchase_budget_table').bootstrapTable({
                url: '/php/core.php?method=getBudgets',
                contentType: 'application/x-www-form-urlencoded',
                method: 'POST',
                clickToSelect:false,
                toolbar:'#toolbar_purchase_budget_table',
                queryParams: function (p){
                    return {
                        "iom_id":iom_id
                    }
                },
                columns: [{checkbox:true},{
                    field: 'id',
                    title: '#:'
                    //sortable:true
                },{
                    field: 'brand_name',
                    title: 'Brand:'
                    //sortable:true
                    //filterControl:'select'
                },{
                    field: 'name',
                    title: 'Name:',
                },{
                    field: 'budget_type',
                    title: 'Budget Type:',
                },{
                    field: 'cur_sum',
                    title: 'Current Sum:',
                    formatter: function(id,data){
                        return format_money(data['cur_sum'])
                    }
                    //sortable:true
                    //filterControl:'select'
                },{
                    field: 'planed_cost',
                    title: 'Planed Cost:',
                    formatter: function(id,data){
                        return format_money(data['planed_cost'])
                    }
                    //sortable:true
                    //filterControl:'select'
                },{
                    title:'Select Sum:',
                    align: 'center',
                    events: operateEvents,
                    formatter: function(id,data){
                        var controls='<input budget_id="'+data['id']+'" class="purchase_budget_inputs" disabled="disabled" name="budget_input_'+data['id']+'" id="budget_input_'+data['id']+'" value="0" type="number" min="0" max="'+data['cur_sum']+'">';
                        return controls;
                    }
                }],
            }).off('check.bs.table').on('check.bs.table', function (event,row,el){
                //console.log(row);
                $('#budget_input_'+row['id']).prop('disabled','');
            }).off('dbl-click-row.bs.table').on('dbl-click-row.bs.table', function (event,row,el){
                //console.log(row);
                //$('#purchase_budget_table').bootstrapTable('check',);
                console.log(row);
            }).off('uncheck.bs.table').on('uncheck.bs.table', function (event,row,el){
                $('#budget_input_'+row['id']).prop('disabled','disabled').val(0);
            }).off('load-success.bs.table').on('load-success.bs.table', function (event,row,el){
                $.ajax({
                    url: '/php/core.php?method=getIomBudgets',
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    data: {iom_id: iom_id}
                }).success(function (data) {
                    for (var i= 0,length= row.length;i<length;i++){
                        for (var j= 0,length2=data.length;j<length2;j++) {
                            if (row[i]['id']==data[j]['budget_id']) {
                                $('#purchase_budget_table').bootstrapTable('check', i);
                                $('#budget_input_'+data[j]['budget_id']).val(data[j]['cur_cost']);

                            }else{
                            }
                        }
                    }
                });
            });
            if ($('#myWizard').hasClass('left')){
                $('#legend_iom').attr('iom_id',iom_id).text('Edit Application #'+iom_id);
                $('#myWizard').removeClass('animated left').addClass('animated right');
                console.log(row);
                $('#purchase_text').val(row['name']);
                $('#user_id').text(row['fullname']+' from '+row['department_name']+' department.');
                $('#summernote').code('');
                $("#summernote").summernote("editor.pasteHTML", row['substantation']);
                $.ajax({
                    url: '/php/core.php?method=getIomSigners',
                    contentType: 'application/x-www-form-urlencoded',
                    dataType: 'json',
                    method: 'POST',
                    data: { "iom_id" : row['id'] }
                }).success(function (data){
                    //console.log(data);
                    var mass = Array();
                    for (var i= 0,length=data.length;i<length;i++){
                        mass.push(data[i]['employee_id']);
                    }
                    console.log(mass);
                    $('#chain_list select').each(function (index, item) {
                        $(item).val(mass[index]);
                    });
                    $('.selectpicker').selectpicker('refresh');
                    $.ajax({
                        url: '/php/core.php?method=getIomFiles',
                        contentType: 'application/x-www-form-urlencoded',
                        dataType: 'json',
                        method: 'POST',
                        data: { "iom_id" : row['id'] }
                    }).success(function (data) {
                        var divHTML='<legend>Old Iom Files: </legend>';
                        for(var i=0;i<data.length;i++){
                            var filepath = data[i]['filepath'].split('/').slice(-2).join('/');
                            divHTML+='<div class="col-lg-3" style="padding=5px; margin-bottom:10px;" align="center">'+
                                '<div><a class="btn btn-default" href="../' + filepath + '" download="' + data[i]['title'] +'.'+ data[i]['type']+'"><div><i class="fa fa-file-' + filetypes[data[i]['type']] + ' fa-2x"></i></div></a></div>'+
                                '<div style="font-size:12px; word-wrap:break-word;">'+data[i]['title']+'</div>'+
                                '</div>';
                        }
                        $('#reset_files').html(divHTML);
                        console.log(divHTML);
                    });
                    //$('.step').validator();
                });
            }else{
                //$('#myWizard').removeClass('animated left').addClass('animated right');
            }


        }
    }
};


$(document).ready(function () {

    //$('#summernote').summernote();

    $('.selectpicker').selectpicker({
        noneSelectedText: '',
        maxOptions:1
    });
    //getUsersJSON();
    //$('#chain_list').validator();
    $('#summernote').summernote({height: 150});
    //$('.personOK').click(function (event) {
    //    event.preventDefault();
    //    if (event.target.nodeName == "BUTTON")
    //        personOK(event.target);
    //    else
    //        personOK($(event.target).parent());
    //});


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
            field: 'time_stamp',
            title: 'Created on:',
            sortable:true
        },{
            field: 'status',
            title: 'IOM Status:',
            sortable:true
        },{
            field: 'latest_action',
            title: 'Last Event:',
            sortable:true
            //filterControl:'select'
        },{
            title:'Actions:',
            align: 'center',
            events: operateEvents,
            formatter: function(id,data){
                console.log(data.sign_status);
                var controls='';
                if (data.sign_status==1){
                    controls = '<button class="btn btn-success control btn-sm">Confirm</button><button class="btn btn-danger btn-sm control">Cancel</button>'
                }else{
                    controls += data.user_last_status+'<br><br>' || '';
                }
                if($('.img-user').attr('user_id')==data.employee_id) {
                    controls += '<button class="btn btn-warning control btn-sm">Restart</button>';
                }
                controls += '<a href="/show/'+data.id+'" target="_blank" class="btn btn-primary btn-sm">View</a>';
                return controls;
            }
        }],
        search: true,
        strictSearch: true,
        detailView : true,
        showRefresh:true,
        stickyHeader:false,
        toolbar: '#toolbar',
        //groupBy:true,
        //groupByField:['status'],
        detailFormatter: function (index, row){
            var div = $('<div class="col-lg-12"></div>');
            div.append('<div class="col-lg-6">' +
                        '<legend>Budgets: </legend>' +
                        '<table class="box-shadow table-bordered" id="budget_'+index+'"></table>' +
                        '<br><legend>Description: </legend><br><div class="box-shadow" style="background: #F5F5F5; padding: 15px;" id="summer_'+index+'" readonly="readonly">'+row["substantation"]+'</div>' +
                        '<br><legend>Comments: </legend>' +
                        '<div class="box-shadow comments-table" id="comments_'+index+'"></div>' +
                        '<br><legend>Attachments: </legend>' +
                        '<div id="files_'+index+'"></div>' +
                    '</div>');
            div.append('<div class=col-lg-6>' +
                        '<legend>Approved by: </legend>' +
                        '<table class="table-bordered" id="signers_'+index+'"></table>' +
                        '<br><legend>Events: </legend>' +
                        '<table class="table-bordered" id="events_'+index+'"></table>' +
                        '<br><legend>Invoice Sum: </legend>'+
                        '<table class="table-bordered" id="invoice_'+index+'"></table><br>' +
                        '<input id="invoiceSum_'+index+'" type="number" class="form-control" style="width: 200px;float: left;margin-right: 10px"><button id="applysum_'+index+'" class="btn btn-primary">Apply Invoice Cost</button>'+
                    '</div>');

            return div.html();
        }
    }).on('load-success.bs.table',function (data){
        //console.log(data);
    }).on('expand-row.bs.table',function (event,index,row){
        //$('#summer_'+index).summernote({
        //    shortcuts: false
        //});
        console.log(row);

        var iom_id = row['id']
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
                title: 'Status:'
                //sortable:true
                //filterControl:'select'
            }],
        });
        $('#invoice_'+index).bootstrapTable({
            url: '/php/core.php?method=getInvoiceSum',
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
                field: 'date_time',
                title: 'Invoice Time:',
                //sortable:true
            },{
                field: 'cost',
                title: 'Invoice Cost:'
                //sortable:true
                //filterControl:'select'
            }],
        });
        $('#budget_'+index).bootstrapTable({
            url: '/php/core.php?method=getIomBudgets',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            queryParams: function (p){
                return {
                    "iom_id":row['id']
                }
            },
            columns: [{
                field: 'name',
                title: 'Name:'
                //sortable:true
            },{
                        field: 'budget_type',
                        title: 'Budget Type:',
                    },{
                field: 'budget_date',
                title: 'Date:',
						formatter: function(id,data){

                            var d = new Date.parse(data['budget_date'])

                            return d.toString('MMMM, yy');
                        }						
                //sortable:true
                //filterControl:'select'
            },{
                field: 'planed_cost',
                title: 'Available Balance:',
                formatter: function(id,data){
                    return format_money(data['planed_cost'])
                }
                //sortable:true
                //filterControl:'select'
            },{
                field: 'cur_cost',
                title: 'IOM Cost:',
                formatter: function(id,data){
                            if (data['cur_cost']!=null) {
                                return format_money(data['cur_cost']);
                            }else{
                                return format_money(data['planed_cost']);
                            }
                }
                //sortable:true
                //filterControl:'select'
            },{
                title: 'Current Balance:',
                formatter: function(id,data,index){
                    var sum = data['planed_cost']-data['cur_cost'];
                    return format_money(sum);
                }
            }],
        });

        $('#comments_'+index).bootstrapTable({
            url: '/php/core.php?method=getComments',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            cardView:true,
            queryParams: function (p){
                return {
                    "iom_id":row['id']
                }
            },
            rowStyle: function(value,row,index){
                return {
                    classes: value['status'],
                };
            },
            columns: [{
                field: 'fullname',
                title: '',
                width:'100%',
                align:'left',
                formatter: function(id,data,index){
                    return '<span style="text-decoration:underline;"><i class="fa fa-commenting-o"></i>&nbsp;'+data['fullname']+'</span>';
                }
                //sortable:true
            },{
                field: 'text',
                title: '',
                width:'100%',
                align:'left'
                //sortable:true
                //filterControl:'select'
            },{
                field: 'time_stamp',
                title: '',
                width:'100%',
                align:'left'
                //sortable:true
                //filterControl:'select'
            }],
        });

        function operateFormatter(value, row, index) {
            if (row['cancel']==0 && row['event_name']!='Created') {
                return [
                    '<a class="remove" href="javascript:void(0)" title="Remove">',
                    '<i class="glyphicon glyphicon-remove"></i>',
                    '</a>'
                ].join('');
            }else{
                return '';
            }
        }
        window.operateEvents = {
            'click .remove': function (e, value, row) {
                swal({
                    title: "Are you sure?",
                    text: "Abort event ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    showLoaderOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            url: "php/core.php?method=cancelEvent",
                            type: "POST",
                            dataType:"json",
                            async: 0,
                            data: {"id": row["id"],"iom_id": iom_id,"employee_id":row['employee_id']}
                        }).success(function (data) {
                            if (data['type'] == "success"){
                                $('#events_'+index).bootstrapTable('refresh');
                                $('#signers_'+index).bootstrapTable('refresh');
                                swal("Canceled!", "Event has been Canceled.", "success");
                            }else{
                                swal("Request Error!",data['error_msg'],"error");
                            }
                        });
                    } else {
                        //swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
            }
        };

        $('#events_'+index).bootstrapTable({
            url: '/php/core.php?method=getIomEvents',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            queryParams: function (p){
                return {
                    "iom_id":row['id']
                }
            },
            rowStyle: function(value,row,index){
                switch (value['event_name']){
                    case "Approved":
                        return{
                            //classes: 'test',
                            css: {"color" : "#5cb85c"}
                        }
                        break;
                    case "Created":
                        return{
                            //classes: 'test',
                            css: {"color" : "#337ab7"}
                        }
                        break;
                    case "Canceled":
                        return{
                            //classes: 'test',
                            css: {"color" : "#d9534f"}
                        }
                        break;
                    case "Restarted":
                        return{
                            //classes: 'test',+
                            css: {"color" : "#ed9c28"}
                        }
                        break;
                }
            },
            columns: [{
                field: 'event',
                title: 'Event:'
                //sortable:true
            },{
                field: 'date_time',
                title: 'DateTime:'
                //sortable:true
                //filterControl:'select'
            }],
        });
        //$('#files_'+index).bootstrapTable({
        //    url: '/php/core.php?method=getIomFiles',
        //    contentType: 'application/x-www-form-urlencoded',
        //    method: 'POST',
        //    cardView: true,
        //    queryParams: function (p){
        //        return {
        //            "iom_id":row['id']
        //        }
        //    },
        //    columns: [{
        //        field: 'filename',
        //        title: 'Name:'
        //        //sortable:true
        //    }],
        //});
        $.ajax({
            url: '/php/core.php?method=getIomFiles',
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            method: 'POST',
            data: { "iom_id" : row['id'] }
        }).success(function (data) {
            var divHTML='';
            for(var i=0;i<data.length;i++){
                var filepath = data[i]['filepath'];
                divHTML+='<div class="col-lg-3" style="padding=5px; margin-bottom:10px;" align="center">'+
                    '<div><a class="btn btn-default" href="../' + filepath + '" download="' + data[i]['title'] +'.'+ data[i]['type']+'"><div><i class="fa fa-file-' + filetypes[data[i]['type']] + ' fa-2x"></i></div></a></div>'+
                    '<div style="font-size:12px; word-wrap:break-word;">'+data[i]['title']+'</div>'+
                    '</div>';
            }
            $('#files_'+index).html(divHTML);
            console.log(divHTML);
        });

        $('#applysum_'+index).off('click').on('click',function (){
            $(this).addClass('disabled');
            $.ajax({
                url: '/php/core.php?method=sendInvoiceSum',
                contentType: 'application/x-www-form-urlencoded',
                dataType: 'json',
                method: 'POST',
                data: { "iom_id" : row['id'],"cost": $('#invoiceSum_'+index).val() }
            }).success(function (data) {
                if (data['type']=='success'){
                    swal("Success!", "Success update invoice sum.", "success");
                    $('#invoice_'+index).bootstrapTable('refresh');
                    $('#invoiceSum_'+index).val(0)
                    $('#applysum_'+index).removeClass('disabled');
                }else{
                    $('#invoiceSum_'+index).val(0)
                    swal("Canceled!", "Unknown error.", "success");
                    $('#applysum_'+index).removeClass('disabled');
                }
            });
        });

    });

    //$(".table").fixMe();
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
                        $('#budget_inputs').append('<div id="bi_' + item + '" class="form-group"><span class="col-lg-6">' + data_content + '</span>' +
                            '<input budget_id="' + item + '" class="form-control" type="number" min="0" data-minlength="1" placeholder="Cost size..." required/>' +
                            '<span class="glyphicon form-control-feedback" aria-hidden="true"></span><span class="help-block with-errors"></span></div>');
                        //$('#budget_inputs').validator();
                        $('#budget_inputs').validator("validate");
                    } else {
                        //$(input).remove();
                    }
                });
            }
        }else{
            $('#budget_inputs').html('');
        }
    });


});

function resetForm(){
    $('#myWizard a:first').tab('show');
    $('#purchase_text').val('');
    $('.selectpicker').selectpicker('deselectAll');
    //$('.selectpicker').selectpicker('destroy');
    $('#budget_inputs').html('');
    $('#input-1').fileinput('clear');
    $('.control-block').click();
    $('#myWizard').removeClass('right').addClass('left');
    //$('#testtable').bootstrapTable('refresh');
    //$('#purchase_budget_table').bootstrapTable('destroy');
    $('#legend_iom').attr('iom_id','');
    $('#input-1').fileinput('unlock');

}