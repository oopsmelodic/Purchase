var UsersJSON;
var roles = ["General director", "Financial director", "Financial controller", "Financial", "Department leader", "Initiator"];
$(document).ready(function () {
    $('.selectpicker').selectpicker();
    //getUsersJSON();
    $('#summernote').summernote({height: 300});
    $('.personOK').click(function (event) {
        event.preventDefault();
        if (event.target.nodeName == "BUTTON")
            personOK(event.target);
        else
            personOK($(event.target).parent());
    });
    //ITEM BUTTON CONTROLL
    $('.personADD').click(function (){
        var parent = $(this).parents('li');
        var all_count =$('#chain_list').size();
        var text = $(this).parents('li').find('.list-group-item-heading').text();
        var index = $(this).index();

        console.log(text);
        $('<li class="list-group-item">' +
                '<div class="col-lg-9"><select class="selectpicker" data-width="100%"><option>ITem1</option><option>Item2</option></select></div>' +
                '<div class="col-lg-9"><select class="selectpicker" data-width="100%"><option>Item3</option><option>Item4</option></select></div>' +
            '</li>').insertAfter(parent);
            $('.selectpicker').selectpicker();
            $('.selectpicker').on('change', function (e) {
                console.log(this);
            });
    });
});

function getUsersJSON()
{
    $.ajax({
        url: "php/getUsers.php",
        dataType: "json",
        success: usersTable
    });
}

function personOK(button)
{

    if ($(button).hasClass("btn-success"))
    {
        $(button).parents('.list-group-item').addClass('active');
        $(button).parents('.list-group-item').find('.selectpicker').prop('disabled', true).selectpicker('refresh');
        $(button).parents('.list-group-item').find('.personOK').find('.glyphicon').addClass('glyphicon-remove').removeClass('glyphicon-plus');
        $(button).addClass('btn-warning').removeClass('btn-success');

    }
    else if ($(button).hasClass("btn-warning"))
    {
        $(button).parents('.list-group-item').removeClass('active');
        $(button).parents('.list-group-item').find('.selectpicker').prop('disabled', false).selectpicker('refresh');
        $(button).parents('.list-group-item').find('.personOK').find('.glyphicon').addClass('glyphicon-plus').removeClass('glyphicon-remove');
        $(button).addClass('btn-success').removeClass('btn-warning');

//        $('#createpurch').removeClass('disabled');
    }
}
//function personOK(button)
//{
//    $(button).parent('.list-group-item').addClass('active');
//    if ($(button).parent('.list-group-item').next().text() != "")
//    {
//        $('.personBack').remove();
//        $(button).parent('.list-group-item').next().append("<select class='selectpicker inline' data-width='80%'>"
//                + "<option>Initiator</option>"
//                + "<option>General controller</option>"
//                + "<option>Controller</option>"
//                + "</select><button class='btn btn-success btn-sm inline personOK' style='right:60px; position:absolute;'>"
//                + "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button>"
//                + "<button class='btn btn-warning btn-sm inline personBack' style='right:20px; position:absolute;'>"
//                + "<span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></button>");
//        $(button).parent('.list-group-item').children('.selectpicker').prop('disabled', true).selectpicker('refresh');
//        $(button).remove();
//
//        $('.selectpicker').selectpicker();
//        $('.personOK').click(function (event) {
//            if (event.target.nodeName == "BUTTON")
//                personOK(event.target);
//            else
//                personOK($(event.target).parent());
//        });
//        $('.personBack').click(function (event) {
//        if (event.target.nodeName == "BUTTON")
//            personBack(event.target);
//        else
//            personBack($(event.target).parent());
//    });
//    }
//    else
//    {
//        $(button).parent('.list-group-item').children('.selectpicker').prop('disabled', true).selectpicker('refresh');
//        $('#createpurch').removeClass('disabled');
//        $(button).remove();
//    }
//}
//function personBack(button)
//{
//    $('.personOK').remove();
//    $(button).parent('.list-group-item').prev().append("<button class='btn btn-success btn-sm inline personOK' style='right:60px; position:absolute;'>"
//            + "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button>"
//            + "<button class='btn btn-warning btn-sm inline personBack' style='right:20px; position:absolute;'>"
//            + "<span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></button>");
//    $(button).parent('.list-group-item').prev().children('.selectpicker').prop('disabled', false).selectpicker('refresh');
//    $(button).parent('.list-group-item').prev().removeClass('active');
//    $(button).parent('.list-group-item').children('.selectpicker').selectpicker('destroy');;
//    $(button).remove();
//
//    $('.personOK').click(function (event) {
//        if (event.target.nodeName == "BUTTON")
//            personOK(event.target);
//        else
//            personOK($(event.target).parent());
//    });
//    $('.personBack').click(function (event) {
//        if (event.target.nodeName == "BUTTON")
//            personBack(event.target);
//        else
//            personBack($(event.target).parent());
//    });
//}
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
                + "</button> "
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