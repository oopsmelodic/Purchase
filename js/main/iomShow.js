var filetypes = {"txt": "text-o", "docx": "word-o", "doc": "word-o", "ptt": "powerpoint-o", "pttx": "powerpoint-o", "zip": "archive-o", "rar": "archive-o", "pdf": "pdf-o", "jpg": "image-o", "png": "image-o", "ttif": "image-o", "xls": "excel-o", "xlsx": "excel-o"};
$(document).ready(function () {
    var iom_id = $('#iom_id').attr('iom_id');
    $('#summernote').summernote({
        shortcuts: false,
        height: 150

    });
    $('#summernote').summernote('disable');

    $('#budgets').bootstrapTable({
        url: '/php/core.php?method=getIomBudgets',
        contentType: 'application/x-www-form-urlencoded',
        method: 'POST',
		showFooter:true,
		rowStyle: function (row,index){
			  return {
				classes: '',
				css: {"font-size": "10px"}
			  };				
			},		
        queryParams: function (p){
            return {
                "iom_id":iom_id
            }
        },
            columns: [{
                field: 'name',
                title: 'Name:'
                //sortable:true
            },{
                        field: 'budget_type',
                        title: 'Type:',
                    },{
                field: 'budget_date',
                title: 'Date:',
						formatter: function(id,data){

                            var d = new Date.parse(data['budget_date'])

                            return d.toString('MMMM, yy');
                        }						
                //sortable:true
                //filterControl:'select'
            },{
                field: 'current_balance',
                title: 'Available:',
                formatter: function(id,data){
					var sum = data['planed_cost']-data['current_balance'];						
                    return format_money(sum);
                },
				footerFormatter:function(data){
					return 'Total:';
				}
                //sortable:true
                //filterControl:'select'
            },{
                field: 'cur_cost',
                title: 'IOM Cost:',
                formatter: function(id,data){
                            if (data['cur_cost']!=null) {
                                return format_money(data['cur_cost']);
                            }else{
                                return format_money(data['planed_cost']);
                            }
                },
				footerFormatter:function(data){
					var sum = 0;
					for (var i= 0,len = data.length;i<len;i++){
						//sum += data[i]['planed_cost'];
						var obj  = data[i];
						if (obj['planed_cost']!=null) {
							sum += parseInt(obj['cur_cost']);
						}else{
							sum +=0;
						}
					}
					return format_money(sum);
				}				
                //sortable:true
                //filterControl:'select'
            },{
                title: 'C/F Balance:',
                formatter: function(id,data,index){
                    var sum = data['planed_cost']-data['current_balance'];
					sum = sum - data['cur_cost'];
                    return format_money(sum);
                }
            }],
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
		rowStyle: function (row,index){
			  return {
				classes: '',
				css: {"font-size": "11px"}
			  };				
		},
        columns: [{
                field: 'id',
                title: '#',
                formatter: function(id,data,index){
                    return index+1;
                }
            },{
                field: 'fullname',
                title: 'Name:',
                //sortable:true
            },{
                field: 'dep_name',
                title: 'Desig.,Dept.:',
				formatter: function(id,data,index){
                    return data['role_name']+', '+data['dep_name'];
                }
                //sortable:true
            },{
                field: 'status',
                title: 'Status:'
                //sortable:true
                //filterControl:'select'
            }]
    });

    $.ajax({
        url: '/php/core.php?method=getIomFiles',
        contentType: 'application/x-www-form-urlencoded',
        dataType: 'json',
        method: 'POST',
        data: { "iom_id" : iom_id }
    }).success(function (data) {
        var divHTML='';
        for(var i=0;i<data.length;i++)
        {

            var filepath = data[i]['filepath'].split('/').slice(-2).join('/');
            divHTML+='<div class="col-lg-3" style="padding=5px; margin-bottom:10px;" align="center">'+
                '<div><a class="btn btn-default" href="../' + filepath + '" download="' + data[i]['title'] +'.'+ data[i]['type']+'"><div><i class="fa fa-file-' + filetypes[data[i]['type']] + ' fa-2x"></i></div></a></div>'+
                '<div style="font-size:12px; word-wrap:break-word;">'+data[i]['title']+'</div>'+
                '</div>';
        }
        $('#files').html(divHTML);
        console.log(divHTML);
    });
});