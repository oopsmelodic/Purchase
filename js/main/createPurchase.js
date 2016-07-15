/**
 * Created by melodic on 26.04.2016.
 */

String.prototype.capitalizeFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

$(function(){
    //$('#purchase_text').focus();

    //Control Block Template

    $('#newPurchase').on('click',function(){
            if ($('#myWizard').hasClass('right')){
                $('#myWizard').removeClass('animated right').addClass('animated left');
            }else{
                $('#myWizard').removeClass('animated left').addClass('animated right');
                $('#summernote').code('');
                $('#purchase_budget_table').bootstrapTable({
                    url: '/php/core.php?method=getBudgets',
                    contentType: 'application/x-www-form-urlencoded',
                    method: 'POST',
                    clickToSelect:true,
                    columns: [{checkbox:true},{
                        field: 'id',
                        title: '#:'
                        //sortable:true
                    },{
                        field: 'brand_name',
                        title: 'Brand:'
                        //sortable:true
                        //filterControl:'select'
                    },{
                        field: 'name',
                        title: 'Name:',
                    },{
                        field: 'cur_sum',
                        title: 'Current Sum:'
                        //sortable:true
                        //filterControl:'select'
                    },{
                        field: 'planed_cost',
                        title: 'Planed Cost:'
                        //sortable:true
                        //filterControl:'select'
                    },{
                        title:'Select Sum:',
                        align: 'center',
                        events: operateEvents,
                        formatter: function(id,data){
                            var controls='<input budget_id="'+data['id']+'" class="purchase_budget_inputs" disabled="disabled" name="budget_input_'+data['id']+'" id="budget_input_'+data['id']+'" value="0" type="number" min="0" max="'+data['cur_sum']+'">';
                            return controls;
                        }
                    }],
                }).off('check.bs.table').on('check.bs.table', function (event,row,el){
                    //console.log(row);
                    $('#budget_input_'+row['id']).prop('disabled','');
                }).off('uncheck.bs.table').on('uncheck.bs.table', function (event,row,el){
                    $('#budget_input_'+row['id']).prop('disabled','disabled').val(0);
                }).off('load-success.bs.table').on('load-success.bs.table', function (event,row,el){

                });
            }
    });


    $('select').on('changed.bs.select', function (e) {
        $(e.target).selectpicker('toggle');
    });

    $('#summernote').summernote({
        height: 150
    });

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
        $('.step').validator('validate');
        e.preventDefault();
        $(nextId).focus();
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

    });

    $('#myWizardMini').click(function (e){
        if ($('#myWizard').hasClass('right')){
            $('#myWizard').removeClass('animated right').addClass('animated half');
            $('#myWizardMini i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
        }else{
            $('#myWizard').removeClass('animated half').addClass('animated right');
            $('#myWizardMini i').removeClass('fa-chevron-right').addClass('fa-chevron-left');
        }
    });

    $('.first').click(function(){
        resetForm();
    });

    $(".nav li.disabled a").click(function() {
        return false;
    });

    function resetForm(){
        $('#myWizard a:first').tab('show');
        $('#purchase_text').val('');
        $('#summernote').summernote('code', '');
        $('.selectpicker').selectpicker('deselectAll');
        $('.selectpicker').selectpicker('refresh');
        $('#budget_inputs').html('');
        $('#input-1').fileinput('clear');
        $('.control-block').click();
        $('#myWizard').removeClass('right').addClass('left');
        $('#testtable').bootstrapTable('refresh');
        $('#purchase_budget_table').bootstrapTable('destroy');
        $('#legend_iom').attr('iom_id','');
        $('#input-1').fileinput('unlock');
    }

    $('#create_app').click(function (){
        var type = '';
        var iom_id = 0;
        if ($('#legend_iom').attr('iom_id')!=''){
            type = 'update';
            iom_id = $('#legend_iom').attr('iom_id');
        }else{
            type = 'create';
        }
        swal({
            title: "Are you sure?",
            text: type.capitalizeFirstLetter()+' application "' + $('#purchase_text').val() + '" ?',
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
                //var test_chain = $('#purchase_budget_table').bootstrapTable('getSelections');
                //console.log(test_chain);
                //Make Chain
                $('.purchase_budget_inputs').each(function (index, item) {
                    if ($(item).val()!=0) {
                        budgets_chain.push({'id': $(item).attr('budget_id'), 'value': $(item).val()});
                    }
                });
                //console.log(JSON.stringify(budgets_chain));
                $('#chain_list select').each(function (index, item) {
                    sign_chain.push($(item).selectpicker('val'));
                });
                $.ajax({
                    url: '/php/core.php?method='+type+'IomReq',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        employee_id: $('.img-user').attr('user_id'),
                        department_id: $('.img-user').attr('department_id'),
                        purchase_text: $('#purchase_text').val() || 'Empty',
                        expense_size: 0,
                        substantiation_text: $("#summernote").code(),
                        budgets: JSON.stringify(budgets_chain),
                        sign_chain: JSON.stringify(sign_chain),
                        iom_id : iom_id
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


    function createApplication(purchase_id){
        var requestType = '';
        var data = null;
        if (purchase_id!=null){
            requestType = 'update';
        }else{
            requestType = 'add';
        }
        swal({
            title: "Are you sure?",
            text: requestType.capitalizeFirstLetter()+' application "' + $('#purchase_text').val() + '" ?',
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
                //if (requestType='add') {
                //    data = {
                //        employee_id: $('.img-user').attr('user_id'),
                //        department_id: $('.img-user').attr('department_id'),
                //        purchase_text: $('#purchase_text').val() || 'Empty',
                //        expense_size: 0,
                //        substantiation_text: $("#summernote").code(),
                //        budgets: JSON.stringify(budgets_chain),
                //        sign_chain: JSON.stringify(sign_chain)
                //    };
                //}else{
                //    data = {
                //
                //    }
                //}
                $.ajax({
                    url: '/php/core.php?method='+requestType+'IomReq',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        employee_id: $('.img-user').attr('user_id'),
                        department_id: $('.img-user').attr('department_id'),
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
                            swal("Confirmed!", "Application '" + $('#purchase_text').val() + "' has been "+requestType+".", "success");
                            //location.href = '/purchase';
                            resetForm();
                            //console.log(data);
                        });
                        var str = $('.file-caption').text();
                        var files = $('#input-1').val();
                        if (files != "") {
                            $('#input-1').fileinput('upload');
                        } else {
                            swal("Confirmed!", "Application '" + $('#purchase_text').val() + "' has been "+requestType+".", "success");
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
    }

});
