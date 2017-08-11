/**
 * Created by melodic on 25.06.2017.
 */



function format_money(n) {
    var fixed = parseInt(n);
    return fixed.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")+' ₽';
}

$(function (){


    $('#budgets_graph').on('changed.bs.select',function (e,value){

        var department_id = $(this).selectpicker('val');

        $.ajax({
            url: "/php/core.php?method=getBudgetsGraph",
            type:"post",
            dataType:"json",
            async: true,
            data: {department_id: department_id}
        }).success(function (data){
            if (data!=null){
                console.log(data);
                Highcharts.stockChart('report_chart',{
                    chart: {
                        zoomType:'xy',
                        backgroundColor: 'transparent',
                        type: 'line'
                    },
                    title: {
                        text: 'Budgets Graph Example',
                        style: {"color": "#000"},
                        x: -20 //center

                    },
                    subtitle: {
                        text: 'Just For test',
                        style: {"color": "#000"},
                        x: -20
                    },
                    yAxis: {
                        labels:{
                            style: {'color':'#000'}
                        },
                        title: {
                            text: 'Cost',
                            style: {'color':'#000'}
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'left',
                        verticalAlign: 'middle',
                        borderWidth: 0,
                        enabled:true,
                        style: {'color':'#000'}
                    },
                    plotOptions: {
                        series: {
                            events: {
                                click: function (event) {
                                    var budget_id_event = this.userOptions.budget_id;
                                    $('#report_data').bootstrapTable('refresh',{query:{budget_id:budget_id_event}});
                                }
                            }
                        }
                    },
                    series: data
                });
            }
        });
    });
    $('#report_data').bootstrapTable({
        url: '/php/core.php?method=getIomsByBudget',
        contentType: 'application/x-www-form-urlencoded',
        method: 'POST',
        queryParams: function (p){
            return {
                "budget_id":0
            }
        },
        filterControl:true,
        showFooter:true,
        pagination: true,
        showExport:true,
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
                    console.log(obj['iom_invoice']);
                    if (obj['iom_invoice']!=null) {
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
        strictSearch: true,
        detailView : false,
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

    });

});