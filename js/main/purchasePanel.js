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


window.operateEvents = {
    'click .control': function (e, value, row, index) {
        //alert(row['id']);
        var button = $(this).html();
        swal({
            title: "Are you sure?",
            text: button + " application '" + row['name'] + "'?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/php/core.php?method=signIom',
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    data: {id: row['id'], type: button}
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
            } else {
                //swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
    }
};


$(document).ready(function () {

    $('#summernote').summernote();

    $('.selectpicker').selectpicker({
        noneSelectedText: ''
    });
    //getUsersJSON();
    //$('#chain_list').validator();
    $('#summernote').summernote({height: 300});
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
                sortable: true
            }, {
                field: 'name',
                title: 'Name:',
                sortable: true
            }, {
                field: 'latest_action',
                title: 'Latest Action:',
                sortable: true
                        //filterControl:'select'
            }, {
                field: 'status',
                title: 'Status:',
                align: 'center',
                sortable: true
            }, {
                field: 'user_last_status',
                title: 'User status:',
                align: 'center',
                sortable: true
            }, {
                title: 'Controls:',
                align: 'center',
                events: operateEvents,
                formatter: function (id, data) {
                    console.log(data.sign_status);
                    var controls = '';
                    if (data.sign_status == 1) {
                        controls += '<div><button class="btn btn-success control">Confirm</button><button class="btn btn-danger control">Cancel</button></div>';
                    }
                    return controls;
                }
            }],
        search: true,
        strictSearch: true,
        detailView: true,
        showRefresh: true,
        toolbar: '#toolbar',
        //groupBy:true,
        //groupByField:['status'],
        detailFormatter: function (index, row) {
            var div = $('<div class="col-lg-12"></div>');
            div.append('<div class="col-lg-6">' +
                    '<span class="label label-primary">Budgets: </span>' +
                    '<table id="budget_' + index + '"></table>' +
                    '<span class="label label-primary">Substantation: </span><br><textarea id="summer_' + index + '" readonly="readonly">' + row["substantation"] + '</textarea>' +
                    '<span class="label label-primary">Files: </span>' +
                    '<table id="files_' + index + '"></table>' +
                    '</div>');
            div.append('<div class=col-lg-6>' +
                    '<span class="label label-primary">Signers: </span>' +
                    '<table id="signers_' + index + '"></table>' +
                    '</div>');

            return div.html();
        }
    }).on('load-success.bs.table', function (data) {
        //console.log(data);
    }).on('expand-row.bs.table', function (event, index, row) {
        $('#summer_' + index).summernote({
            shortcuts: false
        });
        $('#summer_' + index).code(row['substantation']);
        $('#signers_' + index).bootstrapTable({
            url: '/php/core.php?method=getIomSigners',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            queryParams: function (p) {
                return {
                    "iom_id": row['id']
                }
            },
            columns: [{
                    field: 'id',
                    title: '#',
                    formatter: function (id, data, index) {
                        return index + 1;
                    }
                }, {
                    field: 'fullname',
                    title: 'Name:',
                    //sortable:true
                }, {
                    field: 'status',
                    title: 'Status:'
                            //sortable:true
                            //filterControl:'select'
                }],
        });
        $('#budget_' + index).bootstrapTable({
            url: '/php/core.php?method=getIomBudgets',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            queryParams: function (p) {
                return {
                    "iom_id": row['id']
                }
            },
            columns: [{
                    field: 'budget_name',
                    title: 'Name:'
                            //sortable:true
                }, {
                    field: 'cur_cost',
                    title: 'Cost:'
                            //sortable:true
                            //filterControl:'select'
                }],
        });
        $('#files_' + index).bootstrapTable({
            url: '/php/core.php?method=getIomFiles',
            contentType: 'application/x-www-form-urlencoded',
            method: 'POST',
            cardView: true,
            queryParams: function (p) {
                return {
                    "iom_id": row['id']
                }
            },
            columns: [{
                    field: 'filename',
                    title: 'Name:'
                            //sortable:true
                }],
        });
    });


    //$(".table").fixMe();
    //selects
    $('#budget_select').selectpicker().on('changed.bs.select', function (item, val) {
        var selectedOptions = $(this).context.selectedOptions;
        var cur_select = $(this).selectpicker('val');
        if (cur_select != null) {
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
                                '<input class="form-control" type="number" min="0" data-minlength="1" placeholder="Cost size..." required/>' +
                                '<span class="glyphicon form-control-feedback" aria-hidden="true"></span><span class="help-block with-errors"></span></div>');
                        //$('#budget_inputs').validator();
                        $('#budget_inputs').validator("validate");
                    } else {
                        //$(input).remove();
                    }
                });
            }
        } else {
            $('#budget_inputs').html('');
        }
    });

});
