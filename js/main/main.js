$(function (){

    //LatestActions

    $('#latest_actions').bootstrapTable({
        url: '/php/core.php?method=getLatestActions',
        columns: [{
            field: 'latest_action',
            title: '',
            sortable:true
        }],
        strictSearch: true,
        cardView:true
    });

    $.ajax({
        url: "/php/core.php?method=getBudgetsGraph",
        type:"post",
        dataType:"json",
    }).success(function (data){
        if (data!=null){
            $('#test_chart').highcharts({
                chart: {
                    zoomType:'xy'
                },
                title: {
                    text: 'Budgets Graph Example',
                    x: -20 //center
                },
                subtitle: {
                    text: 'Just For test',
                    x: -20
                },
                xAxis: {
                    categories: data['categories']
                },
                yAxis: {
                    title: {
                        text: 'Cost'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: data['series']
            });
        }
    });

});