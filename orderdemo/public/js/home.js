$(function(){
    var orderTable = $('#orderOverview').DataTable( {
        dom: "Btrip",
        pageLength: 10,
        ajax: {
            "url": "/orderOverview/data",
            "type": "POST",
            'headers': {
				'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
			}
        },
        serverSide: true,
        processing: true,
        ordering: true,
        order: [[0, "asc" ]],
        columns: [
            { data: 'Customer.CustomerId' },
            { data: 'Customer.Name' },
            { 
                data: null,
                render: function(data, type, row){
                    for(var i = 0;i < data.CustomerStatus.length;i++){
                        if(row.Customer.CustomerStatusId === data.CustomerStatus[i].CustomerStatusId){
                            return data.CustomerStatus[i].Name;
                        }
                    }
                    return "Unknown";
                }
            },
            { 
                data: null,
                render: function(data, type, row){
                    if($.inArray(row.Customer.CustomerId.toString(), Object.keys(data.greenData)) !== -1){
                        return data.greenData[row.Customer.CustomerId].count;
                    }
                    else return 'N/A';
                }
            },
            { 
                data: null,
                render: function(data, type, row){
                    if($.inArray(row.Customer.CustomerId.toString(), Object.keys(data.greenData)) !== -1){
                        return "$" + data.greenData[row.Customer.CustomerId].sum;
                    }
                    else return 'N/A';
                }
            },
        ],
        rowCallback: function (row, data) {
            console.log(data);
            for(var i = 0;i < data.CustomerStatus.length;i++){
                if(data.Customer.CustomerStatusId === data.CustomerStatus[i].CustomerStatusId){
                    if(data.CustomerStatus[i].Code == 'RE'){
                        $(row).addClass('red');
                    }
                }
            }
            if($.inArray(data.Customer.CustomerId.toString(), Object.keys(data.orangeData)) !== -1){
                $(row).addClass('orange');
            }
            if($.inArray(data.Customer.CustomerId.toString(), Object.keys(data.greenData)) !== -1){
                if(data.greenData[data.Customer.CustomerId].sum >= 200) $(row).addClass('green');
            }
        }
    });

    
});