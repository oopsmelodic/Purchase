var UsersJSON;
var roles = ["General director", "Financial director", "Financial controller", "Financial", "Department leader", "Initiator"];
var valid = ["usernick", "userMail", "userName", "userSecondname", "userPosition", "inputPassword"];
$(document).ready(function () {

    $('#testtable').bootstrapTable({
        url: '/php/getUsers.php',
        columns: [{
            field: 'id',
            title: '#',
            sortable:true
        }, {
            field: 'fullname',
            title: 'Заголовок',
            sortable:true
        },{
            field: 'role',
            title: 'Время загрузки',
            sortable:true
            //filterControl:'select'
        },{
            field: 'department',
            title: 'Статус',
            sortable:true
        }],
        search: true,
        strictSearch: true,
        detailView : false,
        groupBy:true,
        groupByField:['department']
    }).on('dbl-click-row.bs.table',function (el,row){

    });

    $('.selectpicker').selectpicker();

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
            data: data
        }).success(function (data){

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