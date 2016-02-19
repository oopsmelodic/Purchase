var valid = ["username", "email", "fullname", "position", "password"];
var deproles;
$(document).ready(function () {
    $('.selectpicker').selectpicker();

    $.ajax({
        url: "php/core.php?method=getDepRoles",
        type: "POST"
    }).success(function (data) {
        deproles = JSON.parse(data);
    });

    $('#testtable').bootstrapTable({
        url: '/php/core.php?method=getUsers',
        columns: [{
                field: 'id',
                title: 'Department  User ID',
                sortable: true
            }, {
                field: 'fullname',
                title: 'Fullname',
                sortable: true
            }, {
                field: 'role',
                title: 'Role',
                sortable: true
            },
            {
                field: 'operate',
                title: 'Item Operate',
                align: 'center',
                events: operateEvents,
                formatter: operateFormatter
            }],
        search: true,
        //height: 600,
        strictSearch: true,
        showRefresh: true,
        detailView: false,
        groupBy: true,
        groupByField: ['department']
    }).on('dbl-click-row.bs.table', function (el, row) {

    });

    $('#showPanel').click(function (event) {
        event.preventDefault();
        slider(false);
    });

    $('#addUser').click(function (event) {
        event.preventDefault();
        bootbox.dialog({
            title: "Register user",
            message: bootboxMessage("", "", "", "", true),
            buttons: {
                success: {
                    label: "Add user",
                    className: "btn-success modalbtn",
                    callback: function () {
                        var data;
                        data = {
                            "fullname": $('#fullname').val(),
                            "position": $('#position').val(),
                            "role": $('#roles').val(),
                            "department": $('#departments').val(),
                            "username": $('#username').val(),
                            "password": $('#password').val(),
                            "email": $('#email').val()};
                        $.ajax({
                            url: "php/addUser.php",
                            type: "POST",
                            data: data
                        }).success(function (data) {
                            if (data === "success")
                            {
                                $('#testtable').bootstrapTable('refresh');
                                message = "User <strong>" + $('#username').val() + "</strong> was registered.";
                            } else
                            {
                                message = data;
                            }
                            bootbox.alert(message);
                        });
                    }
                }
            }
        }
        ).on('shown.bs.modal', function () {
            setValidator();
            $("#password").keyup(function () {
                validator("password", ($('#password').val() == "" || $('#password').val().length < 6));
            });
            valid = ["username", "email", "fullname", "position", "password"];
            validator("password", ($('#password').val() == "" || $('#password').val().length < 6));
            $('.selectpicker').selectpicker();
        });
    });
});

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function validateWords(string) {
    var re = /^[^\W\d_]+$/;
    return re.test(string);
}

function validatePosition(string) {
    var re = /^[a-zA-Z_ ]*$/;
    return re.test(string);
}

function validator(name, state)
{
    if (state)
    {
        $('.modalbtn').addClass("disabled");
        $('#' + name).parent().parent(".form-group").addClass("has-error");
        $('#' + name).parent().find('.help-block').slideDown();
        if (valid.indexOf(name) == -1)
            valid.push(name);
    } else {
        $('#' + name).parent().parent(".form-group").removeClass("has-error");
        $('#' + name).parent().find('.help-block').slideUp();
        if (valid.indexOf(name) != -1)
            valid.splice(valid.indexOf(name), 1);
        if (valid.length == 0) {
            $('.modalbtn').removeClass("disabled");
        }
    }
}
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
        bootbox.dialog({
            title: "Editing user: " + row['name'] + "",
            message: bootboxMessage(row["fullname"], row['username'], row['email'], row['position'], false),
            buttons: {
                success: {
                    label: "Save",
                    className: "btn-success modalbtn",
                    callback: function () {
                        $.ajax({
                            url: "php/core.php?method=updateUser",
                            type: "POST",
                            data: {
                                "fullname": $('#fullname').val(),
                                "position": $('#position').val(),
                                "role": $('#roles').val(),
                                "department": $('#departments').val(),
                                "username": $('#username').val(),
                                "password": $('#password').val(),
                                "email": $('#email').val(),
                                "id": row['id']
                            }
                        }).success(function (data) {
                            if (data === "success")
                            {
                                $('#testtable').bootstrapTable('refresh');
                                message = "User <strong>" + row['name'] + "</strong> was updated.";
                            } else
                            {
                                message = data;
                            }
                            bootbox.alert(message);
                        });
                    }
                }
            }
        }
        ).on('shown.bs.modal', function () {
            setValidator();
            $("#password").keyup(function () {
                validator("password", ($('#password').val().length !== 0 && $('#password').val().length < 6));
            });
            valid = ["password"];
            validator("password", ($('#password').val().length !== 0 && $('#password').val().length < 6));
            $('.selectpicker').selectpicker();
            $('#roles').selectpicker('val', row['roleid']);
            $('#departments').selectpicker('val', row['depid']);
        });
    },
    'click .remove': function (e, value, row, index) {
        bootbox.confirm("Are you sure to delete user: <b>" + row['fullname'] + "?</b>", function (result) {
            if (result) {
                $.ajax({
                    url: "php/core.php?method=deleteUser",
                    type: "POST",
                    async: 0,
                    data: {"id": row["id"]}
                }).success(function (data) {
                    var message = "";
                    if (data === "success")
                    {
                        $('#testtable').bootstrapTable('remove', {
                            field: 'id',
                            values: [row.id]
                        });
                        message = "User <strong>" + row['name'] + "</strong> was deleted.";
                    } else
                    {
                        message = data;
                    }
                    bootbox.alert(message);
                });
            }
        });
    }
};
function setValidator()
{
    $("#username").keyup(function () {
        validator("username", ($('#username').val() == "" || $('#username').val().length < 3) || checkuserexists($('#username').val()));
    });
    $("#email").keyup(function () {
        validator("email", ($('#email').val() == "" || !validateEmail($('#email').val())));
    });

    $("#fullname").keyup(function () {
        validator("fullname", ($('#fullname').val() == "" || !validatePosition($('#fullname').val())));
    });

    $("#position").keyup(function () {
        validator("position", ($('#position').val() == "" || !validatePosition($('#position').val())));
    });
}
function bootboxMessage(fullname, username, email, position, newuser)
{
    var display = (newuser) ? '' : 'style="display:none;"';
    var danger = (newuser) ? ' has-error' : '';
    var msg = '<div class="row">  ' +
            '<div class="col-md-12"> ' +
            '<form class="form-horizontal"> ' +
            '<div class="form-group' + danger + '"> ' +
            '<label class="col-md-4 control-label" for="name">Fullname</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="fullname" name="fullname" type="text" class="form-control input-md" value="' + fullname + '"> ' +
            '<span class="help-block"' + display + '>Only letters</span> </div> ' +
            '</div> ' +
            '<div class="form-group' + danger + '"> ' +
            '<label class="col-md-4 control-label" for="name">Username</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="username" name="username" type="text" class="form-control input-md" value="' + username + '"> ' +
            '<span class="help-block" id="usercontroll" ' + display + '>Minimum of 3 characters</span> </div> ' +
            '</div> ' +
            '<div class="form-group' + danger + '"> ' +
            '<label class="col-md-4 control-label" for="name">E-Mail</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="email" name="email" type="text" class="form-control input-md" value="' + email + '"> ' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group' + danger + '"> ' +
            '<label class="col-md-4 control-label" for="name">Position</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="position" name="position" type="text" class="form-control input-md" value="' + position + '"> ' +
            '<span class="help-block" ' + display + '>Only letters</span> </div> ' +
            '</div> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="name">Department</label> ' +
            '<div class="col-md-4"> ' +
            '<select class="selectpicker" id="departments" data-width="100%" style="display:inline;">' + deproles["departments"] + '</select>' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="name">Role</label> ' +
            '<div class="col-md-4"> ' +
            '<select class="selectpicker" id="roles" data-width="100%" style="display:inline;">' + deproles["roles"] + '</select>' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group' + danger + '"> ' +
            '<label class="col-md-4 control-label" for="name">Password</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="password" name="password" type="text" class="form-control input-md" placeholder="Type new password..."> ' +
            '<span class="help-block" ' + display + '>Minimum of 6 characters</span> </div> ' +
            '</div> ' +
            '</div> </div>' +
            '</form> </div>  </div>';
    return msg;
}