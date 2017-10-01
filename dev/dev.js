/**
 * Created by melodic on 05.04.2016.
 */

$(function(){
    //$('#purchase_text').focus();

    $('.control-block').on('click',function(){

        if ($('#myWizard').hasClass('right')){
            $('#myWizard').removeClass('animated right').addClass('animated left');
        }else{
            $('#myWizard').removeClass('animated left').addClass('animated right');
        }
    });


    $('select').on('changed.bs.select', function (e) {
        $(e.target).selectpicker('toggle');
    });

    $('#summernote').summernote();

    $('.tab-pane').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            e.preventDefault();
        }
    });

    $('.next').click(function(e){
        //$('form').valid();
        var nextId = $(this).parents('.tab-pane').next().attr("id");
        $('[href=#'+nextId+']').tab('show');
        e.preventDefault();
        return false;
    });

    $('.back').click(function(){

        var prevId = $(this).parents('.tab-pane').prev().attr("id");
        $('[href=#'+prevId+']').tab('show');
        return false;

    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        //update progress
        var step = $(e.target).data('step');
        var percent = (parseInt(step) / 4) * 100;

        $('.progress-bar').css({width: percent + '%'});
        $('.progress-bar').text("Step " + step + " of 4");

        //e.relatedTarget // previous tab

    })

    $('.first').click(function(){

        resetForm();

    });

    $(".nav li.disabled a").click(function() {
        return false;
    });

    function resetForm(){
        $('#myWizard a:first').tab('show');
        $('#purchase_text').val('');
        //$("#summernote").reset();
        $('.selectpicker').selectpicker('deselectAll');
        $('#budget_inputs').html('');
        $('#input-1').fileinput('clear');
        $('.control-block').click();
    };

    $('#create_app').click(function (){
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
                        employee_id: 60,
                        department_id: 5,
                        purchase_text: $('#purchase_text').val() || 'Empty',
                        expense_size: 0,
                        substantiation_text: $("#summernote").code(),
                        budgets: JSON.stringify(budgets_chain),
                        sign_chain: JSON.stringify(sign_chain)
                    }
                }).success(function (data) {
                    if (data != null) {
                        $('#input-1').on('filepreupload', function (event, dataz, previewId, index, jqXHR) {
                            dataz.form.append("iom_id", data['id']);
                            console.log(data);

                        });
                        $('#input-1').on('fileuploaded', function (event, dataz, previewId, index, jqXHR) {
                            swal("Confirmed!", "Application '" + $('#purchase_text').val() + "' has been created.", "success");
                            //location.href = '/purchase';
                            resetForm();
                            //console.log(data);
                        });
                        var str = $('.file-caption').text();
                        var files = $('#input-1').val();
                        if (files != "") {
                            $('#input-1').fileinput('upload');
                        } else {
                            swal("Confirmed!", "Application '" + $('#purchase_text').val() + "' has been created.", "success");
                            //location.href = '/purchase';
                            resetForm();
                        }
                    } else {
                        //swal("Error", "Just a Error", "error");
                    }
                });
            } else {

            }
        });
    });

});
