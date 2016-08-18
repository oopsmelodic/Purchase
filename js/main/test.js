/**
 * Created by melodic on 17.08.2016.
 */

function format_money(n) {
    var fixed = parseInt(n);
    return fixed.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")+' ₽';
}


$(document).ready(function () {

    $('#testtable').bootstrapTable({
        url: '/php/core.php?method=getAllBudgets',
        filterControl:true,
        groupBy:true,
        groupByField:['department_name'],
        showFooter:true,
        columns: [{
            title:'ID',
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
            footerFormatter:function(data){
                var sum = 0;
                for (var i= 0,len = data.length;i<len;i++){
                    //sum += data[i]['planed_cost'];
                    var obj  = data[i]
                    sum +=  parseInt(obj['planed_cost']);
                }
                return format_money(sum);
            },
            formatter: function(id,data){
                return format_money(data['planed_cost'])
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
    }).on('expand-row.bs.table',function (event,index,row){
        //$('#summer_'+index).summernote({
        //    shortcuts: false
        //});
        console.log(row);

        $('#iom_'+index).bootstrapTable({
            url: '/php/core.php?method=getBudgetIoms',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
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


});
