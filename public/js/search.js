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
          console.log(data);
        },
    });
}