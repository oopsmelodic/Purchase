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


});