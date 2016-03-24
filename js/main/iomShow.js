/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $('#summer_' + index).summernote({
        shortcuts: false
    });
    
    show_signers('signers',$('#iom_id').attr('iom_id')); //загружает таблицу подписантов
    
    $('#summer_' + index).code(row['substantation']);

    
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
            }]
    });
});