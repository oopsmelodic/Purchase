/**
 * Created by melodic on 17.08.2016.
 */
var filterData;

function format_money(n) {
    var fixed = parseInt(n);
    return fixed.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")+' ₽';
}

function toObject(arr) {
    var rv = {};
    for (var i = 0; i < arr.length; ++i)
        rv[i] = arr[i];
    return rv;
}

function getFilters(name,table){
    $.ajax({
        url: '/php/core.php?method=getFilterData',
        contentType: 'application/x-www-form-urlencoded',
        dataType: 'json',
        method: 'POST',
        async:false,
        data: { "field_name" : name,"table_name": table}
    }).success(function (data) {

        window['filter'+name+table] = data;

        console.log(window['filter'+name+table]);
    });

    return 'var:filter'+name+table;
}

$(document).ready(function () {
    var scrollTo = null;
    var scrollIndex = null;

    var utc = new Date().toJSON().slice(0,10).replace(/-/g,'/');
    utc = utc.toString();

    $('#budgets_table').bootstrapTable({
        url: '/php/core.php?method=getAllBudgets',
        filterControl:true,
        showFooter:true,
        pagination: true,
        showExport:true,
        exportOptions:{
            htmlContent: true,
            fileName: 'Budgets '+utc,
            excelFileFormat:'xls',
            ignoreColumn: [0],
            worksheetName:'Budgets',
            onCellHtmlData: function ($cell, rowIndex, colIndex, htmlData){
                //Check Html Included
                if (htmlData.indexOf('<div class="fht-cell">')!=-1){
                    htmlData = htmlData.slice(0,htmlData.indexOf('<div class="fht-cell">'));
                }
                if (htmlData.indexOf('₽')!=-1){
                    htmlData = htmlData.slice(0,htmlData.indexOf('₽'));
                }
                return htmlData;
            }
        },
        exportTypes:['excel'],
        strictSearch:false,
        pageSize:50,
        pageList: [50,100,500,1000,1500],
        //stickyHeader:true,
        columns: [{
            title:'FYear:',
            field:'fy',
            sortable:true,
            width:'8%',
            filterControl:'select',
            filterStrictSearch:true
            //formatter: function(id,data){
            //    var d = new Date.parse(data['budget_date']);
            //    //console.log(d.getYear());
            //    var startYear = d.getYear();
            //    var endYear = d.getYear()+1;
            //    return 'FY '+(startYear-100)+'-'+(endYear-100);
            //}
        },{
            field:'id',
            title: 'ID:',
            width:'3%',
            sortable:true
        },{
            field:'name',
            title: 'Name:',
            sortable:true,
            filterControl:'select',
            filterData: getFilters('name','budget'),
            filterStrictSearch:true
        },{
            field:'budget_date',
            title: 'Date:',
            width:'5%',
            sortable:true,
            formatter: function(id,data){

                var d = new Date.parse(data['budget_date'])

                return d.toString('MMMM');
            }
        },{
            field:'brand_name',
            title: 'Brand:',
            sortable:true,
            filterControl:'select',
            filterData: getFilters('name','budget_brand'),
            filterStrictSearch:true
        },{
            field:'mapping_name',
            title: 'Mapping:',
            sortable:true,
            filterControl:'select',
            filterData: getFilters('name','budget_mapping'),
            filterStrictSearch:true
        },{
            field:'department_name',
            title: 'Depart.:',
            sortable:false,
            filterControl:'select',
            filterData: getFilters('name','departments'),
            filterStrictSearch:true
        },{
            field:'budget_type',
            title: 'Type:',
            sortable:true,
            filterControl:'select',
            filterData: getFilters('budget_type','budget'),
            filterStrictSearch:true
        },{
            field:'planed_cost',
            title: 'OB Value:',
            sortable:true,
            formatter: function(id,data){
                return format_money(parseInt(data['planed_cost']));
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
            field:'relocation_cost',
            title: 'Relocation:',
            sortable:true,
            formatter: function(id,data){
                if (data['relocation_cost']!=null) {
                    return format_money(data['relocation_cost']);
                }else{
                    return format_money(0);
                }
            }
        },{
            field:'cur_sum',
            title: 'Balance:',
            sortable:true,
            formatter: function(id,data){
                var relocation_sum = 0;
                if (data['relocation_cost']!=null){
                    relocation_sum = parseInt(data['relocation_cost']);
                }else{
                    relocation_sum = parseInt(0);
                }
                if (data['cur_sum']!=null) {
                    return format_money(parseInt(data['cur_sum'])+relocation_sum);
                }else{
                    return format_money(parseInt(data['planed_cost'])+relocation_sum);
                }
            },
            footerFormatter:function(data){
                var relocation_sum = 0;
                if (data['relocation_cost']!=null){
                    relocation_sum = parseInt(data['relocation_cost']);
                }else{
                    relocation_sum = parseInt(0);
                }
                var sum = 0;
                for (var i= 0,len = data.length;i<len;i++){
                    //sum += data[i]['planed_cost'];
                    var obj  = data[i];
                    if (obj['cur_sum']!=null) {
                        sum += parseInt(obj['cur_sum']);
                        sum += relocation_sum;
                    }else{
                        sum += parseInt(obj['planed_cost']);
                        sum += relocation_sum;
                    }
                }
                return format_money(sum);
            }
        }],
        search: true,
        detailView : true,
        showRefresh:true,
        stickyHeader:false,
        //groupBy:true,
        //groupByField:['status'],
        detailFormatter: function (index, row){
            var div = $('<div class="col-lg-12"></div>');
            div.append('' +
                '<table class="box-shadow table-bordered table-condensed" id="iom_'+index+'"></table>'+
                '<div class="col-lg-3"><label>Relocations:</label><table class="box-shadow table-bordered table-condensed " id="relocation_'+index+'"></table>'+
                '<button class="btn btn-success" id="addrel_'+index+'">Add</button><button class="btn btn-danger" id="delrel_'+index+'">Delete</button></div>');
            return div.html();
        }
    }).off('load-success.bs.table').on('load-success.bs.table',function (event,index,row){
        //asd
        $('#budgets_table').bootstrapTable('expandRow',scrollIndex);
        $('#budgets_table').bootstrapTable('scrollTo',scrollTo);
    }).off('expand-row.bs.table').on('expand-row.bs.table',function (event,index,row){
        //$('#summer_'+index).summernote({
        //    shortcuts: false
        //});
        console.log($(this));
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
            },{
                field: 'name',
                title: 'IOM Name:'
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
                field: 'status',
                title: 'Status:'
            },{
                title:'URL:',
                formatter: function(id,data){
                    var host = window.location.hostname;
                    return '<a target="_blank" href="http://'+host+'/show/'+data['id']+'" class="btn btn-primary btn-sm">View</a>'
                }
            }]
        });

        $('#relocation_'+index).bootstrapTable({
            url: '/php/core.php?method=getBudgetRelocations',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            pagination: true,
            singleSelect:true,
            clickToSelect:true,
            queryParams: function (p){
                return {
                    "budget_id":row['id']
                }
            },
            columns: [{checkbox:true},{
                field:'cost',
                title: 'Rel Cost:',
                sortable:true,
                formatter: function(id,data){
                    if (data['cost']!=null) {
                        return format_money(data['cost']);
                    }else{
                        return format_money(0);
                    }
                }
            }]
        });

        $('#addrel_'+index).off('click').on('click',function (){
            bootbox.dialog({
                title: "Apply Relocation",
                message:      '<div class="row"> ' +
                '<div class="col-md-12"> ' +
                '<form id="form_rel_"'+index+' class="form-horizontal"> ' +
                '<div class="form-group"> ' +
                '<label class="col-md-4 control-label" for="name">Cost</label> ' +
                '<div class="col-md-4"> ' +
                '<input id="relCost_'+index+'" name="relCost" type="number" class="form-control input-md">'  +
                '</div> ' +
                '</div>'+
                '</form></div>',
                buttons: {
                    success: {
                        label: "Apply",
                        className: "btn-success modalbtn",
                        callback: function () {
                            $.ajax({
                                url: '/php/core.php?method=sendRel',
                                contentType: 'application/x-www-form-urlencoded',
                                dataType: 'json',
                                method: 'POST',
                                data: { "budget_id" : row['id'],"cost": $('#relCost_'+index).val()}
                            }).success(function (data) {
                                if (data['type']=='success'){
                                    $('#budgets_table').bootstrapTable('refresh',{silent: true});
                                    scrollTo = $('#budgets_table').bootstrapTable('getScrollPosition');
                                    scrollIndex = index;
                                    $('#relocation_'+index).bootstrapTable('refresh',{silent: true});
                                    swal("Success!", "Success add relocation.", "success");
                                }else{
                                    swal("Canceled!", "Unknown error.", "success");
                                }
                            });
                        }
                    }
                }
            }).off('load-success.bs.table').on('load-success.bs.table',function (event,index,row){

            });
        });

        $('#delrel_'+index).off('click').on('click',function (){
            var selections = $('#relocation_'+index).bootstrapTable('getSelections');
            var rel_id = selections[0]['id'];
            swal({
                title: "Delete Relocation?",
                showCancelButton: true,
                closeOnConfirm: false,
                closeOnCancel: true,
                animation: "slide-from-top",
                showLoaderOnConfirm: true
            }, function(){
                $.ajax({
                    url: '/php/core.php?method=delRel',
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    data: {id: rel_id}
                }).success(function (data){
                    if (data != null) {
                        if (data['type'] == 'success') {
                            $('#budgets_table').bootstrapTable('refresh',{silent: true});
                            scrollTo = $('#budgets_table').bootstrapTable('getScrollPosition');
                            scrollIndex = index;
                            $('#relocation_'+index).bootstrapTable('refresh',{silent: true});
                            swal("Success!", "Success delete relocation.", "success");
                        } else {
                            swal("Request Error!", data['error_msg'], "error");
                        }
                    } else {
                        swal("Request Error!", data['error_msg'], "error");
                    }
                });
            });
        });

    });

    $('#iom_table').bootstrapTable({
        url: '/php/core.php?method=getTotalIoms',
        filterControl:true,
        showFooter:true,
        pagination: true,
        showExport:true,
        exportOptions:{
            htmlContent: true,
            fileName: 'Budgets '+utc,
            excelFileFormat:'xls',
            ignoreColumn: [0],
            worksheetName:'Budgets',
            onCellHtmlData: function ($cell, rowIndex, colIndex, htmlData){
                //Check Html Included
                if (htmlData.indexOf('<div class="fht-cell">')!=-1){
                    htmlData = htmlData.slice(0,htmlData.indexOf('<div class="fht-cell">'));
                }
                if (htmlData.indexOf('₽')!=-1){
                    htmlData = htmlData.slice(0,htmlData.indexOf('₽'));
                }
                return htmlData;
            }
        },
        exportTypes:['excel'],
        columns: [{
            field: 'id',
            title: 'IOM ID:',
            sortable:true,
            formatter: function(id,data,index){
                var d1= Date.parse(data['time_stamp']);
                return data['department_name']+d1.toString('yyyyMM')+data['id'];
            }
        },{
            field: 'name',
            title: 'Description:',
            sortable:true
        },{
            field: 'department_name',
            title: 'Department:',
            sortable:true
        },{
            field: 'time_stamp',
            title: 'Budget Date:',
            sortable:true,
            formatter: function(id,data){
                var d = new Date.parse(data['time_stamp'])
                return d.toString('MMMM, yy');
            }
        },{
            field: 'status',
            title: 'Status:',
            sortable:true
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
                if (data['iom_invoice']!=null){
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
                    console.log(obj['iom_invoice']);
                    if (obj['iom_invoice']!=null){
                        sum += parseInt(obj['iom_invoice']);
                    }else{
                        sum += 0;
                    }
                }
                return format_money(sum);
            }
            //filterControl:'select'
        },{
            //field: 'calc_balance',
            title: 'Balance:',
            sortable:true,
            formatter: function(id,data){
                if (data['iom_invoice']!=null) {
                    var sum= data['iom_sum']-data['iom_invoice'];
                    return format_money(sum);
                }else{
                    return format_money(data['iom_sum']);
                }
            }
            //filterControl:'select'
        }],
        search: true,
        strictSearch: false,
        detailView : true,
        showRefresh:true,
        stickyHeader:false,
        pageSize:50,
        pageList: [50,100,500,1000,1500],
        //groupBy:true,
        //groupByField:['status'],
        detailFormatter: function (index, row){
            var div = $('<div class="col-lg-12"></div>');
            div.append('<div class="col-lg-6">' +
                '<br><legend>Invoice Sum: </legend>'+
                '<table class="table-bordered" id="invoice_'+index+'"></table><br>' +
                '<div id="invoice_toolbar_'+index+'"><button id="applysum_'+index+'" class="btn btn-primary">Apply Invoice Pay</button><button id="delsum_'+index+'" class="btn btn-danger">Delete Invoice Pay</button></div>'+
                '</div>');
            div.append('<div class=col-lg-6>' +
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
            }]
        });

        $('#invoice_'+index).bootstrapTable({
            url: '/php/core.php?method=getInvoiceSum',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            toolbar:'#invoice_toolbar_'+index,
            singleSelect:true,
            queryParams: function (p){
                return {
                    "iom_id":row['id']
                }
            },
            columns: [{checkbox:true},{
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
                    if (data['cur_cost']!=null){
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

        $('#delsum_'+index).off('click').on('click',function (){
            var selections = $('#delsum_'+index).bootstrapTable('getSelections');
            var rel_id = selections[0]['id'];
            swal({
                title: "Delete Invoice?",
                showCancelButton: true,
                closeOnConfirm: false,
                closeOnCancel: true,
                animation: "slide-from-top",
                showLoaderOnConfirm: true
            }, function(){
                $.ajax({
                    url: '/php/core.php?method=delInvoice',
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    data: {id: rel_id}
                }).success(function (data) {
                    if (data != null) {
                        if (data['type'] == 'success') {
                            $('#iom_table').bootstrapTable('refresh',{silent: true});
                            scrollTo = $('#iom_table').bootstrapTable('getScrollPosition');
                            scrollIndex = index;
                            $('#delsum_'+index).bootstrapTable('refresh',{silent: true});
                            swal("Success!", "Success delete invoice.", "success");
                        } else {
                            swal("Request Error!", data['error_msg'], "error");
                        }
                    } else {
                        swal("Request Error!", data['error_msg'], "error");
                    }
                });
            });
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
                '<input id="invoiceNum_'+index+'" name="invoiceNum" type="text" class="form-control input-md">'  +
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

    $('#getReportBudgets').click(function(){
        var reportdata = $('#budgets_table').bootstrapTable('getData','useCurrentPage');
        $.ajax({
            url: '/php/report.php',
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            method: 'post',
            data: { "data" : reportdata}
        }).success(function (result, status, xhr) {

        });
    });

});

function saveAs(blob, fileName) {
    var url = window.URL.createObjectURL(blob);

    var anchorElem = document.createElement("a");
    anchorElem.style = "display: none";
    anchorElem.href = url;
    anchorElem.download = fileName;

    document.body.appendChild(anchorElem);
    anchorElem.click();

    document.body.removeChild(anchorElem);

    // On Edge, revokeObjectURL should be called only after
    // a.click() has completed, atleast on EdgeHTML 15.15048
    setTimeout(function() {
        window.URL.revokeObjectURL(url);
    }, 1000);
}