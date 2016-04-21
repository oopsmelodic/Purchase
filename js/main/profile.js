/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$('#saveForm').on('submit', function (e) {
    event.preventDefault();
    $.ajax({
        url: '/php/core.php?method=setUserSetting',
        contentType: 'application/x-www-form-urlencoded',
        dataType: 'json',
        method: 'POST',
        data: {
            "settings": JSON.stringify({
                "email": $('#email').prop('checked'),
                "stay_login": $('#stay_login').prop('checked')
            })
        }
    }).success(function () {
        swal("Success!", "Settings saved.", "success");
    });
});