var UsersJSON;
var roles = ["General director", "Financial director", "Financial controller", "Financial", "Department leader", "Initiator"];
var valid = ["usernick", "userMail", "userName", "userSecondname", "userPosition", "inputPassword"];
$(document).ready(function () {
    $('.selectpicker').selectpicker();
        getUsersJSON();

    $("#usernick").keyup(function () {
        validator("usernick", ($('#usernick').val() == "" || $('#usernick').val().length < 3));
    });

    $("#userMail").keyup(function () {
        validator("userMail", ($('#userMail').val() == "" || !validateEmail($('#userMail').val())));
    });

    $("#userName").keyup(function () {
        validator("userName", ($('#userName').val() == "" || !validateWords($('#userName').val())));
    });

    $("#userSecondname").keyup(function () {
        validator("userSecondname", ($('#userSecondname').val() == "" || !validateWords($('#userSecondname').val())));
    });

    $("#userPosition").keyup(function () {
        validator("userPosition", ($('#userPosition').val() == "" || !validateWords($('#userPosition').val())));
    });

    $("#inputPassword").keyup(function () {
        validator("inputPassword", ($('#inputPassword').val() == "" || $('#inputPassword').val().length < 6));
    });

    $('#showPanel').click(function (event) {
        event.preventDefault();
        if ($('#showPanel').hasClass('btn-success'))
        {
            $('#showPanel').html("<span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span>");
            $('#userPanel').slideDown();
            $('#showPanel').addClass('btn-warning');
            $('#showPanel').removeClass('btn-success');
        }
        else if ($('#showPanel').hasClass('btn-warning'))
        {
            $('#showPanel').html("<span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span>");
            $('#userPanel').slideUp();
            $('#showPanel').addClass('btn-success');
            $('#showPanel').removeClass('btn-warning');
        }
    });

    $('#addUser').click(function (event) {
        event.preventDefault();
        var data;
        data = {
            "fullname": $('#userName').val() + " " + $('#userSecondname').val(),
            "position": $('#userPosition').val(),
            "role": "5",
            "department": "department",
            "deprole": "department",
            "username": $('#usernick').val(),
            "password": $('#inputPassword').val(),
            "email": $('#userMail').val()};

        $.ajax({
            url: "php/addUser.php",
            type: "POST",
            data: data,
            success: getUsersJSON
        });
    });
});

function getUsersJSON()
{
    $('#usersTable').html("<div class='timer-loader' style ='position: absolute;top: 50%;left: 50%;'></div>");
    $.ajax({
        url: "php/getUsers.php",
        dataType: "json",
        success: usersTable
    });
}

function usersTable(json)
{
    UsersJSON = json;
    var html = "<table id='tree' class='table table-bordered table-hover'  style='table-layout:fixed;'>";
    var department = "";
    var treegrid = 0;
    var departmentID = 1;
    for (var i = 0; i < UsersJSON.length; i++)
    {
        if (department != UsersJSON[i]["department"]) {
            department = UsersJSON[i]["department"];
            departmentID = treegrid + 1;
            treegrid += 1;
            html += "<tr class='treegrid-" + departmentID + " success'><td  class='col-md-5'>" + department + "</td><td class='col-md-3'></td><td class='col-md-3'></td><td class='col-md-1'></td></tr>";
        }
        treegrid += 1;
        html += "<tr class='treegrid-" + treegrid + " treegrid-parent-" + departmentID + "'>"
                + "<td><span class='glyphicon glyphicon-user' aria-hidden='true'></span> " + UsersJSON[i]["fullname"] + "</td><td>" + UsersJSON[i]["position"] + "</td><td>" + roles[UsersJSON[i]["role"] - 1] + "</td>"
                + "<td style='text-align: center;'>"
                + "<button type='button' class='btn btn-warning btn-xs' aria-label='Left Align'>"
                + "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>"
                + "</button>"
                + "<button type='button' class='btn btn-danger btn-xs' aria-label='Left Align'>"
                + "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"
                + "</button>"
                + "</td></tr>";
    }
    html += "</table>";
    $('#usersTable').html(html);

    $('#tree').treegrid({
        expanderExpandedClass: 'glyphicon glyphicon-minus',
        expanderCollapsedClass: 'glyphicon glyphicon-plus'
    });
}

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function validateWords(string) {
    var re = /^[^\W\d_]+$/;
    return re.test(string);
}

function validator(name, state)
{
    if (state)
    {
        $('#addUser').addClass("disabled");
        $('#' + name).parent().parent(".form-group").addClass("has-error");
        $('#' + name).parent().find('.help-block').slideDown();
        if (valid.indexOf(name) == -1)
            valid.push(name);
    }
    else
    {

        $('#' + name).parent().parent(".form-group").removeClass("has-error");
        $('#' + name).parent().find('.help-block').slideUp();
        if (valid.indexOf(name) != -1)
            valid.splice(valid.indexOf(name), 1);
        if (valid.length == 0) {
            $('#addUser').removeClass("disabled");
        }
    }
}