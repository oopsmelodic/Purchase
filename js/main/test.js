/**
 * Created by melodic on 17.08.2016.
 */

function format_money(n) {
    var fixed = parseInt(n);
    return fixed.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")+' ₽';
}


$(document).ready(function () {

    $('#budgets_table').bootstrapTable({
        url: '/php/core.php?method=getAllBudgets',
        filterControl:true,
        showFooter:true,
        pagination: true,
        showExport:true,
        columns: [{
            title:'Fin Year:',
            sortable:true,
            width:'5%',
            formatter: function(id,data){

                var d = new Date.parse(data['budget_date'])

                return 'FY 16-17';
            }
        },{
            field:'name',
            title: 'Name:',
            sortable:true,
            filterControl:'select'
        },{
            field:'budget_date',
            title: 'Budget Date:',
            sortable:true,
            filterControl:'select',
            formatter: function(id,data){

                var d = new Date.parse(data['budget_date'])

                return d.toString('MMMM');
            }
        },{
            field:'brand_name',
            title: 'Brand:',
            sortable:true,
            filterControl:'select'
        },{
            field:'mapping_name',
            title: 'Mapping:',
            sortable:true,
            filterControl:'select'
        },{
            field:'department_name',
            title: 'Department:',
            sortable:false,
            filterControl:'select'
        },{
            field:'budget_type',
            title: 'Budget Type:',
            sortable:true,
            filterControl:'select'
        },{
            field:'planed_cost',
            title: 'OB Value:',
            sortable:true,
            filterControl:'select',
            formatter: function(id,data){
                return format_money(data['planed_cost'])
            },
            footerFormatter:function(data){
                var sum = 0;
                for (var i= 0,len = data.length;i<len;i++){
                    //sum += data[i]['planed_cost'];
                    var obj  = data[i];
                    if (obj['planed_cost']!=null) {
                        sum += parseInt(obj['planed_cost']);
                    }else{
                        sum +=0;
                    }
                }
                return format_money(sum);
            }
        },{
            field:'cur_sum',
            title: 'Balance:',
            sortable:true,
            formatter: function(id,data){
                if (data['cur_sum']!=null) {
                    return format_money(data['cur_sum']);
                }else{
                    return format_money(data['planed_cost']);
                }
            },
            footerFormatter:function(data){
                var sum = 0;
                for (var i= 0,len = data.length;i<len;i++){
                    //sum += data[i]['planed_cost'];
                    var obj  = data[i];
                    if (obj['cur_sum']!=null) {
                        sum += parseInt(obj['cur_sum']);
                    }else{
                        sum +=0;
                    }
                }
                return format_money(sum);
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
            div.append('' +
                '<table class="box-shadow table-bordered table-condensed" id="iom_'+index+'"></table>');
            return div.html();
        }
    }).on('load-success.bs.table',function (data){
        //console.log(data);
    }).off('expand-row.bs.table').on('expand-row.bs.table',function (event,index,row){
        //$('#summer_'+index).summernote({
        //    shortcuts: false
        //});
        console.log(row);

        $('#iom_'+index).bootstrapTable({
            url: '/php/core.php?method=getBudgetIoms',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            pagination: true,
            queryParams: function (p){
                return {
                    "budget_id":row['id']
                }
            },
            columns: [{
                field: 'id',
                title: '#',
                formatter: function(id,data,index){
                    return index+1;
                }
            }, {
                field: 'name',
                title: 'IOM Name:',
                //sortable:true
            },{
                field: 'time_stamp',
                title: 'Date:'
                //sortable:true
                //filterControl:'select'
            },{
                field: 'fullname',
                title: 'Creator:',
                formatter: function(id,data){
                    return 'created by '+data['fullname']
                }
                //sortable:true
                //filterControl:'select'
            },{
                field:'iom_cost',
                title:'Iom Cost:',
                formatter: function(id,data){
                    return format_money(data['iom_cost'])
                }
            },{
                title:'URL:',
                formatter: function(id,data){
                    var host = window.location.hostname;
                    return '<a target="_blank" href="http://'+host+'/show/'+data['id']+'" class="btn btn-primary btn-sm">View</a>'
                }
            }],
        });

    });

    $('#iom_table').bootstrapTable({
        url: '/php/core.php?method=getTotalIoms',
        filterControl:true,
        showFooter:true,
        pagination: true,
        showExport:true,
        columns: [{
            field: 'name',
            title: 'Name:',
            sortable:true
        },{
            field: 'department_name',
            title: 'Department:',
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
            field: 'iom_sum',
            title: 'Iom Cost:',
            sortable:true,
            formatter: function(id,data){
                return format_money(data['iom_sum'])
            },
            footerFormatter:function(data){
                var sum = 0;
                for (var i= 0,len = data.length;i<len;i++){
                    //sum += data[i]['planed_cost'];
                    var obj  = data[i]
                    sum +=  parseInt(obj['iom_sum']);
                }
                return format_money(sum);
            }
            //filterControl:'select'
        },{
            field: 'iom_invoice',
            title: 'Iom Invoice:',
            sortable:true,
            formatter: function(id,data){
                if (data['iom_invoice']!=null) {
                    return format_money(data['iom_invoice']);
                }else{
                    return format_money(0);
                }
            },
            footerFormatter:function(data){
                var sum = 0;
                for (var i= 0,len = data.length;i<len;i++){
                    //sum += data[i]['planed_cost'];
                    var obj  = data[i];
                    if (obj['iom_invoice']!=null) {
                        sum += parseInt(obj['iom_invoice']);
                    }else{
                        sum +=0;
                    }
                }
                return format_money(sum);
            }
            //filterControl:'select'
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
                '<br><legend>Invoice Sum: </legend>'+
                '<table class="table-bordered" id="invoice_'+index+'"></table><br>' +
                '<div id="invoice_toolbar_'+index+'"><button id="applysum_'+index+'" class="btn btn-primary">Apply Invoice Pay</button></div>'+
                '</div>');
            div.append('<div class=col-lg-6>' +
                '<br><legend>Events: </legend>' +
                '<table class="table-bordered" id="events_'+index+'"></table>' +
                '<legend>Budgets: </legend>' +
                '<table class="box-shadow table-bordered" id="budget_'+index+'"></table>' +
                '</div>');

            return div.html();
        }
    }).on('load-success.bs.table',function (data){
        //console.log(data);
    }).off('expand-row.bs.table').on('expand-row.bs.table',function (event,index,row){

        $('#events_'+index).bootstrapTable({
            url: '/php/core.php?method=getIomEvents',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            pagination: true,
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

        $('#invoice_'+index).bootstrapTable({
            url: '/php/core.php?method=getInvoiceSum',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            toolbar:'#invoice_toolbar_'+index,
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
            },{
                field: 'invoice_num',
                title: 'Num:',
                //sortable:true
            },{
                field: 'invoice_date',
                title: 'Date:',
                //sortable:true
            },{
                field: 'cost',
                title: 'Cost:',
                formatter: function(id,data){
                    return format_money(data['cost'])
                }
                //sortable:true
                //filterControl:'select'
            },{
                field: 'invoice_comment',
                title: 'Comment:',
                //sortable:true
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

        $('#applysum_'+index).off('click').on('click',function (){

            bootbox.dialog({
                title: "Apply Invoice Payment",
                message:      '<div class="row"> ' +
                '<div class="col-md-12"> ' +
                '<form id="form_invoice_"'+index+' class="form-horizontal"> ' +
                '<div class="form-group"> ' +
                '<label class="col-md-4 control-label" for="name">Num</label> ' +
                '<div class="col-md-4"> ' +
                '<input id="invoiceNum_'+index+'" name="invoiceN++++um" type="number" class="form-control input-md">'  +
                '</div> ' +
                '</div>' +
                '<div class="form-group"> ' +
                '<label class="col-md-4 control-label" for="name">Date</label> ' +
                '<div class="col-md-4"> ' +
                '<input id="invoiceDate_'+index+'" name="invoiceDate" type="date" class="form-control input-md">'  +
                '</div> ' +
                '</div>'+
                '<div class="form-group"> ' +
                '<label class="col-md-4 control-label" for="name">Cost</label> ' +
                '<div class="col-md-4"> ' +
                '<input id="invoiceCost_'+index+'" name="invoiceCost" type="number" class="form-control input-md">'  +
                '</div> ' +
                '</div>'+
                '<div class="form-group"> ' +
                '<label class="col-md-4 control-label" for="name">Comment</label> ' +
                '<div class="col-md-4"> ' +
                '<textarea id="invoiceComment_'+index+'" name="invoiceComment" type="text" class="form-control input-md"></textarea>'  +
                '</div> ' +
                '</div>' +
                '</form></div>',
                buttons: {
                    success: {
                        label: "Apply",
                        className: "btn-success modalbtn",
                        callback: function () {
                            $.ajax({
                                url: '/php/core.php?method=sendInvoiceSum',
                                contentType: 'application/x-www-form-urlencoded',
                                dataType: 'json',
                                method: 'POST',
                                data: { "iom_id" : row['id'],"cost": $('#invoiceCost_'+index).val(),"date":$('#invoiceDate_'+index).val(),'num': $('#invoiceNum_'+index).val(),'comment':$('#invoiceComment_'+index).val()}
                            }).success(function (data) {
                                if (data['type']=='success'){
                                    $('#invoice_'+index).bootstrapTable('refresh');
                                    swal("Success!", "Success update invoice sum.", "success");
                                }else{
                                    swal("Canceled!", "Unknown error.", "success");
                                }
                            });
                        }
                    }
                }
            }).on('shown.bs.modal', function () {
            });
        });


    });

});
