/**
 * Created by melodic on 26.02.2016.
 */

//var last_iom_id = 0;

$(function () {
    $('#summernote').summernote();

    $('.selectpicker').selectpicker({
        //noneSelectedText: ''
        //dropupAuto:false
    });

    $('select.chain_unit').on('changed.bs.select', function (e) {
        $(e.target).selectpicker('toggle');
    });

    //titles = {'id-0': 'file-name-1', 'id-1': 'file-name-2'};

    $('#budget_select').selectpicker().on('changed.bs.select', function (item, index) {
        var selectedOptions = $(this).context.selectedOptions;
        var cur_select = $(this).selectpicker('val');
        if (cur_select != null) {
            $('#expense').removeAttr('required');
            $('#purchase_form').validator('validate');
            $.each($('#budget_inputs div'), function () {
                var this_id = $(this).attr('id').split("_")[1];
                //console.log(cur_select.indexOf(this_id));
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
        } else {
            $('#expense').attr('required', '');
            $('#purchase_form').validator('validate');
            $('#budget_inputs').html('');

        }
    });

    $('#purchase_form').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: 'Create application "' + $('#purchase_text').val() + '" ?',
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
                    var sign_chain = [];
                    var budgets_chain = [];
                    //Make Chain
                    $('#budget_inputs input').each(function (index, item) {
                        budgets_chain.push({'id': $(item).attr('budget_id'), 'value': $(item).val()});
                    });
                    //console.log(JSON.stringify(budgets_chain));
                    $('#chain_list select').each(function (index, item) {
                        sign_chain.push($(item).selectpicker('val'));
                    });
                    $.ajax({
                        url: '/php/core.php?method=addIomReq',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            employee_id: $('#user_id').attr('user_id') || 0,
                            department_id: $('#department_id').attr('department_id') || 0,
                            purchase_text: $('#purchase_text').val() || 'Empty',
                            expense_size: $('#expense').val() || 'Empty',
                            substantiation_text: $("#summernote").code(),
                            budgets: JSON.stringify(budgets_chain),
                            sign_chain: JSON.stringify(sign_chain)
                        }
                    }).success(function (data) {
                        if (data != null) {
                            $('#input-1').on('filepreupload', function (event, dataz, previewId, index, jqXHR) {
                                dataz.form.append("iom_id", data['id']);
                            });
                            $('#input-1').on('fileuploaded', function (event, dataz, previewId, index, jqXHR) {
                                swal("Confirmed!", "Application '" + $('#purchase_text').val() + "' has been created.", "success");
                                location.href = '/purchase';
                                //console.log(data);
                            });
                            var str = $('.file-caption').text();

                            var files = $('#input-1').val();
                            if (files != "") {
                                $('#input-1').fileinput('upload');
                            } else {
                                swal("Confirmed!", "Application '" + $('#purchase_text').val() + "' has been created.", "success");
                                location.href = '/purchase';
                            }
                        } else {
                            //swal("Error", "Just a Error", "error");
                        }
                    });
                } else {

                }
            });
        }
    });


});