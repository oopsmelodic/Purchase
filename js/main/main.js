


$(function (){

    //LatestActions

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
            }
        }
    };

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

    $("#latest_iom").bootstrapTable({
        url: '/php/core.php?method=getAllIoms',
        columns: [{
            field: 'id',
            title: 'IOM ID:',
            sortable:true,
            formatter: function(id,data,index){
                return '201609-'+index;
            }
        }, {
            field: 'name',
            title: 'Name:',
            sortable:true
        }, {
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
            title:'Actions:',
            align: 'center',
            events: operateEvents,
            formatter: function(id,data){
                console.log(data.sign_status);
                var controls='';
                if (data.sign_status==1){
                    controls = '<button class="btn btn-success control btn-sm">Confirm</button><button class="btn btn-danger btn-sm control">Cancel</button>'
                }else{
                    if (data.user_last_status != null) {
                        controls += data.user_last_status + '<br><br>' || '';
                    }else{
                        controls +='';
                    }
                }
                if($('.img-user').attr('user_id')==120 && data.sign_status==1) {
                    controls += '<button class="btn btn-success control btn-sm">Send to C.H</button>';
                }
                return controls;
            }
        }],
        search: false,
        pagination: true,
        strictSearch: true,
        detailView : false,
        showRefresh:true,
        stickyHeader:false,
        toolbar: '#toolbar'
        //groupBy:true,
        //groupByField:['status'],
    });

    //$.ajax({
    //    url: "/php/core.php?method=getBudgetsGraph",
    //    type:"post",
    //    dataType:"json",
    //}).success(function (data){
    //    if (data!=null){
    //        $('#test_chart').highcharts({
    //            chart: {
    //                zoomType:'xy',
    //                backgroundColor: 'transparent',
    //            },
    //            title: {
    //                text: 'Budgets Graph Example',
    //                style: {"color": "#fff"},
    //                x: -20 //center
    //
    //            },
    //            subtitle: {
    //                text: 'Just For test',
    //                style: {"color": "#fff"},
    //                x: -20
    //            },
    //            xAxis: {
    //                categories: data['categories'],
    //                labels:{
    //                    style: {'color':'#fff'}
    //                }
    //            },
    //            yAxis: {
    //                labels:{
    //                    style: {'color':'#fff'}
    //                },
    //                title: {
    //                    text: 'Cost',
    //                    style: {'color':'#fff'}
    //                },
    //                plotLines: [{
    //                    value: 0,
    //                    width: 1,
    //                    color: '#808080'
    //                }]
    //            },
    //            legend: {
    //                layout: 'vertical',
    //                align: 'right',
    //                verticalAlign: 'middle',
    //                borderWidth: 0,
    //                style: {'color':'#fff'}
    //            },
    //            series: data['series']
    //        });
    //    }
    //});

});