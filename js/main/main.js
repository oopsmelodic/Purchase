


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
                    zoomType:'xy',
                    backgroundColor: 'transparent',
                },
                title: {
                    text: 'Budgets Graph Example',
                    style: {"color": "#fff"},
                    x: -20 //center

                },
                subtitle: {
                    text: 'Just For test',
                    style: {"color": "#fff"},
                    x: -20
                },
                xAxis: {
                    categories: data['categories'],
                    labels:{
                        style: {'color':'#fff'}
                    }
                },
                yAxis: {
                    labels:{
                        style: {'color':'#fff'}
                    },
                    title: {
                        text: 'Cost',
                        style: {'color':'#fff'}
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
                    borderWidth: 0,
                    style: {'color':'#fff'}
                },
                series: data['series']
            });
        }
    });

});