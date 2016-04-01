/**
 * Created by melodic on 01.04.2016.
 */
$(document).ready(function () {
    var iom_id = $('#iom_id').attr('iom_id');
    $('#summernote').summernote({
        shortcuts: false,
        height:150

    });
    $('#summernote').summernote('disable');

    $('#budgets').bootstrapTable({
        url: '/php/core.php?method=getIomBudgets',
        contentType: 'application/x-www-form-urlencoded',
        method: 'POST',
        queryParams: function (p) {
            return {
                "iom_id": iom_id
            }
        },
        columns: [{
            field: 'budget_name',
            title: 'Name:'
            //sortable:true
        }, {
            field: 'cur_cost',
            title: 'Cost:'
            //sortable:true
            //filterControl:'select'
        }]
    });

    $('#signers').bootstrapTable({
        url: '/php/core.php?method=getIomSigners',
        contentType: 'application/x-www-form-urlencoded',
        method: 'POST',
        queryParams: function (p) {
            return {
                "iom_id": iom_id
            }
        },
        columns: [{
            field: 'id',
            title: '#',
            formatter: function (id, data, index) {
                return index + 1;
            }
        }, {
            field: 'fullname',
            title: 'Name:'
            //sortable:true
        }, {
            field: 'status',
            title: 'Status:'
            //sortable:true
            //filterControl:'select'
        }]
    });

    $('#files').bootstrapTable({
        url: '/php/core.php?method=getIomFiles',
        contentType: 'application/x-www-form-urlencoded',
        method: 'POST',
        cardView: true,
        queryParams: function (p) {
            return {
                "iom_id": iom_id
            }
        },
        columns: [{
            field: 'filename',
            title: 'Name:'
            //sortable:true
        }]
    });
});