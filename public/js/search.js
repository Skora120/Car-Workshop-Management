$('#searchEngine').keyup(function(e) {
	var _this = $(this);
	var string = _this.val();
	var link = $('#searchEngineLink').val();

	if(string.length >= 3){
		search(string);
		if(e.which == 13){
			window.location.href = link+'/'+string;
		}
	}
});

function search(arg) {
	var token = window.Laravel.csrfToken;
	var link = $('#searchEngineLink').val();
	var string = arg;
    $.ajax({
	    type : 'GET',
	    url : link,
        beforeSend: function(xhr){
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
        },
        data : {'search' : string},
        success:function(data){
        	searchAppendInfromation(data);
          console.log(data);
        },
    });
}


function searchAppendInfromation(arg) {
    $('#searchEngineNavbarList').html('');
    if(arg.length > 0){
        for(var i = 0;i < arg.length; i++){
            var link = "";
            switch(arg[i].type){
            	case "Cars":
            	link = $('#searchEngineLinkCars').val()+"/"+arg[i].id;
            	break;
            	case "Customers":
            	link = $('#searchEngineLinkClients').val()+"/"+arg[i].id;
            	break;
            	case "Orders":
            	link = $('#searchEngineLinkJobs').val()+"/"+arg[i].id;
            	break;

            }


            var item = "<a class='list-group-item list-group-item-action above-list-search' href='"+link+"'>"
                +"<div class='row text-center'>"
                    +"<div class='col-md-12 pull-left'>"
                        +"<strong>"
                            +"From: "+arg[i].type
                        +"</strong>"
                	+"</div>"
                    +"<div class='columns-12'>"
                        +"<strong>"
                            +"Infromation: "+arg[i].description
                        +"</strong>"
                    +"</div>"
                +"</div>"
            +"</a>";

            $( "#searchEngineNavbarList" ).append(item).hide().slideDown();     
        }
    }else{
        var item = "<div class='list-group-item list-group-item-action above'>"+"Not Found"+"<div class='columns-4'>"+"</div>"+"</div>";
        $( "#searchEngineNavbarList" ).append(item).hide().slideDown();  
    }
}
