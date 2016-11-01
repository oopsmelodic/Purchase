var valid = ["username", "email", "fullname", "position", "password"];
var deproles;

function format_money(n) {
    var fixed = parseInt(n);
    return  fixed.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")+' ₽';
}

String.prototype.capitalizeFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

$(document).ready(function () {
    $('.selectpicker').selectpicker();

    //toFix
    $.ajax({
        url: "php/core.php?method=getDepRoles",
        type: "POST"
    }).success(function (data) {
        deproles = JSON.parse(data);
        console.log(deproles);
    });

    var columns = [];
    var groupfield = "";
    var method = "";
    var table = 'employee';

    columns.push({
        field:'id',
        title: '#',
        sortable:true
    },{
        field:'username',
        title: 'Username:',
        sortable:true
    },{
        field:'department',
        title: 'Department:',
        sortable:true
    },{
        field:'fullname',
        title: 'Fullname',
        sortable:true
    },{
        field:'role',
        title: 'Role',
        sortable:true
    },{
        field: 'operate',
        title: 'Item Operate',
        align: 'center',
        events: operateEvents,
        formatter: operateFormatter
    });
    //groupfield = ["department"];
    method = "getUsers";

    $('#datatable').bootstrapTable({
        url: '/php/core.php?method='+method,
        columns: columns,
        pagination: true,
        search: true,
        //height: 600,
        strictSearch: true,
        showRefresh: true,
        detailView: false,
        groupBy: true,
        groupByField: groupfield,
        method: 'POST',
        contentType: 'application/x-www-form-urlencoded',
        queryParams: function (p){
            return {
                "table":table
            }
        }
    });


    $('.nav.nav-pills li').on('click',function(){
        $('#datatable').bootstrapTable('destroy');
        var table = $(this).find('a').attr('table');
        var columns = [];
        var groupfield = "";
        var method = "";
        //COLUMN OPERATOR
        switch (table){
            case 'employee':
                    columns.push({
                        field:'id',
                        title: '#',
                        sortable:true
                    },{
                        field:'fullname',
                        title: 'Fullname',
                        sortable:true
                    },{
                        field:'role',
                        title: 'Role',
                        sortable:true
                    });
                    //groupfield = ["department"];
                    method = "getUsers";

                break;
            case 'budget':
                    columns.push({
                        title:'ID',
                        sortable:true,
                        formatter: function(id,data){

                            var d = new Date.parse(data['budget_date'])

                            return 'FY 16-17';
                        }
                    },{
                        field:'name',
                        title: 'Name:',
                        sortable:true
                    },{
                        field:'budget_date',
                        title: 'Budget Date:',
                        sortable:true,
						formatter: function(id,data){

                            var d = new Date.parse(data['budget_date'])

                            return d.toString('MMMM');
                        }						
                    },{
                        field:'brand_name',
                        title: 'Brand:',
                        sortable:true
                    },{
                        field:'mapping_name',
                        title: 'Mapping:',
                        sortable:true
                    },{
                        field:'department_name',
                        title: 'Department:',
                        sortable:false
                    },{
                        field:'budget_type',
                        title: 'Budget Type:',
                        sortable:true
                    },{
                        field:'planed_cost',
                        title: 'OB Value:',
                        sortable:true,
                        formatter: function(id,data){
                            return format_money(parseInt(data['planed_cost']));
                        }
                    },{
                        field:'relocation_cost',
                        title: 'Relocation:',
                        sortable:true,
                        formatter: function(id,data){
                            if (data['relocation_cost']!=null) {
                                return format_money(data['relocation_cost']);
                            }else{
                                return format_money(0);
                            }
                        }
                    },{
                        field:'cur_sum',
                        title: 'Balance:',
                        sortable:true,
                        formatter: function(id,data){
                            var relocation_sum = 0;
                            if (data['relocation_cost']!=null){
                                relocation_sum = parseInt(data['relocation_cost']);
                            }else{
                                relocation_sum = parseInt(0);
                            }
                            if (data['cur_sum']!=null) {
                                return format_money(parseInt(data['cur_sum'])+relocation_sum);
                            }else{
                                return format_money(parseInt(data['planed_cost'])+relocation_sum);
                            }
                        }
                    });
                    //groupfield = ["department_name"];
                    method = "getAllBudgets";

                break;
            case 'budget_relocations':
                columns.push({
                    field:'name_relocation',
                    title: 'Budget Name:',
                    sortable:true
                },{
                    field:'budget_date_relocation',
                    title: 'Budget Date:',
                    sortable:true,
                    formatter: function(id,data){

                        var d = new Date.parse(data['budget_date_relocation'])

                        return d.toString('MMMM');
                    }
                },{
                    field:'cost',
                    title: 'Balance:',
                    sortable:true,
                    formatter: function(id,data){
                        if (data['cost']!=null) {
                            return format_money(data['cost']);
                        }else{
                            return format_money(0);
                        }
                    }
                });
                //groupfield = ["department_name"];
                method = "getRelocations";

                break;

            case 'budget_mapping':
                columns.push({
                    field:'id',
                    title: '#',
                    sortable:true
                },{
                    field:'name',
                    title: 'Name:',
                    sortable:true
                });
                //groupfield = ["brand_name"];
                method = "getMappings";

                break;

            case 'budget_brand':
                columns.push({
                    field:'id',
                    title: '#',
                    sortable:true
                },{
                    field:'name',
                    title: 'Name:',
                    sortable:true
                });
                //groupfield = ["brand_name"];
                method = "getBrands";

                break;
        }
        columns.push({
            field: 'operate',
            title: 'Item Operate',
            align: 'center',
            events: operateEvents,
            formatter: operateFormatter
        });

        $('#datatable').bootstrapTable({
            url: '/php/core.php?method='+method,
            columns: columns,
            pagination: true,
            search: true,
            //height: 600,
            strictSearch: true,
            showRefresh: true,
            detailView: false,
            //groupBy: true,
            //groupByField: groupfield,
            method: 'POST',
            contentType: 'application/x-www-form-urlencoded',
            queryParams: function (p){
                return {
                    "table":table
                }
            }
        });

        $('#datatable').attr("table_name",table);

    });


    $('#addUser').click(function (event) {
        event.preventDefault();
        var table = $('#datatable').attr('table_name');
        //console.log('Tablename: '+table);
        var columns = [];
        var data = $('#datatable').bootstrapTable('getData');

        for (key in data[0]){
            if (key!='_data'){
                columns.push(key);
            }
        }

        bootbox.dialog({
            title: "Add new:",
            message: bootboxMessage(null,columns),
            buttons: {
                success: {
                    label: "Add "+table,
                    className: "btn-success modalbtn",
                    callback: function () {
                        if ($('#password').val()!=''){
                            columns.push('password');
                        }
                        var data = {};
                        for (var i=0; i<columns.length;i++){
                            data[columns[i]]=$('#'+columns[i]).val();
                        }
                        console.log(data);
                        $.ajax({
                            url: "php/core.php?method=add"+table.capitalizeFirstLetter(),
                            type: "POST",
                            dataType:"json",
                            data: data
                        }).success(function (data) {
                            if (data['type']=='success') {
                                $('#datatable').bootstrapTable('refresh');
                                swal("Confirmed!", "User '" + $('#username').val() + "' has been created.", "success");
                            }else{
                                swal("You can't create user. Cause: ",data['error_msg'],"error");
                            }
                        });
                    }
                }
            }
        }).on('shown.bs.modal', function () {
            $('.selectpicker').selectpicker();
        });
    });
    $('#datatable').attr('table_name',table);
    //$('.active').click();
    console.log($('#datatable').attr('table_name'));

});

function checkuserexists(username)
{
    var existor;
    $.ajax({
        url: "php/core.php?method=checkUser",
        type: "POST",
        async: 0,
        data: {"username": username}
    }).success(function (data) {
        if (data === "exists")
        {
            $("#usercontroll").html("Username allready exists");
            existor = true;
        } else if (data === "nonexists")
        {
            $("#usercontroll").html("Minimum of 3 characters");
            existor = false;
        }
    });
    return existor;
}

function operateFormatter(value, row, index) {
    return [
        '<a class="edit" href="javascript:void(0)" title="Edit">',
        '<i class="glyphicon glyphicon-edit"></i>',
        '</a>  ',
        '<a class="remove" href="javascript:void(0)" title="Remove">',
        '<i class="glyphicon glyphicon-remove"></i>',
        '</a>'
    ].join('');
}
window.operateEvents = {
    'click .edit': function (e, value, row, index) {
        var table = $('#datatable').attr('table_name');
        var columns = [];
        for(var key in row){
            if (key !='_data'){
                columns.push(key);
            }
        }
        bootbox.dialog({
            title: "Editing row: " + row['id'] + "",
            message: bootboxMessage(row,columns),
            buttons: {
                success: {
                    label: "Save",
                    className: "btn-success modalbtn",
                    callback: function () {
                        var data = {};
                        for (var i=0; i<columns.length;i++){
                            data[columns[i]]=$('#'+columns[i]).val();
                        }
                        data['id']=row['id'];
                        $.ajax({
                            url: "/php/core.php?method=update"+table.capitalizeFirstLetter(),
                            type: "POST",
                            dataType: "json",
                            data: data
                        }).success(function (data) {
                            if (data['type']=="success"){
                                $('#datatable').bootstrapTable('refresh');
                                swal("Updated!", "Updated row by name: '" + row['name'] + "'.", "success");
                            }else{
                                swal("Request Error!",data['error_msg'],"error");
                            }
                        });
                    }
                }
            }
        }
        ).on('shown.bs.modal', function () {
            $('.selectpicker').selectpicker();
            $('#role').selectpicker('val', parseInt(row['roleid']));
            $('#department').selectpicker('val', parseInt(row['depid']));
            $('#department_name').selectpicker('val', parseInt(row['budget_department']));
            $('#brand_name').selectpicker('val', parseInt(row['budget_brand']));
            $('#mapping_name').selectpicker('val', parseInt(row['budget_mapping']));
            $('#budget_type').selectpicker('val',row['budget_type']);
        });
    },
    'click .remove': function (e, value, row, index) {
        var table = $('#datatable').attr('table_name');
        swal({
            title: "Are you sure?",
            text: "Delete row by name '"+row['name']+"'?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "php/core.php?method=delete"+table.capitalizeFirstLetter(),
                    type: "POST",
                    dataType:"json",
                    async: 1,
                    data: {"id": row["id"]}
                }).success(function (data) {
                    if (data['type'] == "success"){
                        swal("Deleted!", "Deleted row by name: '" + row['name'] + "'.", "success");
                        $('#datatable').bootstrapTable('remove', {
                            field: 'id',
                            values: [row.id]
                        });
                    }else{
                        swal("Request Error!",data['error_msg'],"error");
                    }
                });
            } else {
                //swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
    }
};

function bootboxMessage(row,columns){
    var display = (row!=null) ? '' : 'style="display:none;"';
    var danger =  '';
    var str =     '<div class="row"> ' +
                    '<div class="col-md-12"> ' +
                        '<form id="form_'+$('#datatable').attr("table_name")+'" class="form-horizontal"> ';
    console.log(columns);
    for (var i=0;i<columns.length;i++){
        switch (columns[i]){
            case 'department':
                str+='<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="name">Department</label> ' +
                        '<div class="col-md-4"> ' +
                            '<select class="selectpicker" id="department" data-width="100%" style="display:inline;">' + deproles["departments"] + ':</select>' +
                        '</div> ' +
                    '</div> ';
                break;
            case 'role':
                str+='<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="name">Role</label> ' +
                        '<div class="col-md-4"> ' +
                            '<select class="selectpicker" id="role" data-width="100%" style="display:inline;">' + deproles["roles"] + ':</select>' +
                        '</div> ' +
                    '</div> ';
                break;
            case 'budget_department':
                str+='<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="name">Department</label> ' +
                    '<div class="col-md-4"> ' +
                    '<select class="selectpicker" id="department_name" data-width="100%" style="display:inline;">' + deproles["departments"] + ':</select>' +
                    '</div> ' +
                    '</div> ';
                break;
            case 'budget_brand':
                str+='<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="name">Budget Brand:</label> ' +
                    '<div class="col-md-4"> ' +
                    '<select class="selectpicker" id="brand_name" data-width="100%" style="display:inline;">' + deproles["brand_name"] + ':</select>' +
                    '</div> ' +
                    '</div> ';
                break;
            case 'budget_mapping':
                str+='<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="name">Mapping Brand:</label> ' +
                    '<div class="col-md-4"> ' +
                    '<select class="selectpicker" id="mapping_name" data-width="100%" style="display:inline;">' + deproles["mapping_name"] + ':</select>' +
                    '</div> ' +
                    '</div> ';
                break;
            case 'name_relocation':
                str+='<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="name">Relocation Budget:</label> ' +
                    '<div class="col-md-8"> ' +
                    '<select class="selectpicker" id="name_relocation" data-width="100%" data-live-search="true" style="display:inline;">' + deproles["budgets"] + ':</select>' +
                    '</div> ' +
                    '</div> ';
                break;
            case 'budget_type':
                str+='<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="name">Budget Type</label> ' +
                        '<div class="col-md-4"> ' +
                            '<select class="selectpicker" id="budget_type" data-width="100%" style="display:inline;"><option data-content="CAPEX">CAPEX</option><option data-content="OPEX">OPEX</option></select>' +
                        '</div> ' +
                    '</div> ';
                break;
            default:
                if (columns[i]!='id' && columns[i]!='budget_relocations' && columns[i]!='budget_date_relocation' && columns[i]!='relocation_cost' && columns[i]!='budget_type' && columns[i]!='cur_sum' && columns[i]!='roleid' && columns[i]!='depid' && columns[i]!='position' && columns[i]!='mapping_name' && columns[i]!='department_name' && columns[i]!='brand_name' && columns[i]!='undefined' && columns[i]!='date_time' && columns[i]!='type_name') {
                    str += '<div class="form-group' + danger + '">' +
                                '<label class="col-md-4 control-label" for="name">' + columns[i].replace(/_/g," ").capitalizeFirstLetter() + ':</label>' +
                                '<div class="col-md-4">' +
                                    '<input id="' + columns[i] + '" name="' + columns[i] + '" type="text" class="form-control input-md" value="' + ((row!=null)? row[columns[i]] : '') + '">' +
                                    //'<span class="help-block"' + display + '>Only letters</span> ' +
                                '</div>' +
                            '</div>';
                }
                if (columns[i]=='username'){
                    str+='<div class="form-group' + danger + '"> ' +
                            '<label class="col-md-4 control-label" for="name">Password:</label> ' +
                            '<div class="col-md-4"> ' +
                                '<input id="password" name="password" type="text" class="form-control input-md" placeholder="Type new password..."> ' +
                                '<span class="help-block" ' + display + '>Minimum of 6 characters</span> ' +
                            '</div> ' +
                        '</div> ';
                }
                break;
        }
    }
    str +='</form> ' +
            '</div>  ' +
        '</div>';
    return str;
}