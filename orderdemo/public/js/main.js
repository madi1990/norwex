$(function(){
    $("#btn-submit").on("click", function(e){
        e.preventDefault();
        if($("#pet_id").val() == '' || $("#pet_name").val() == '' || $("#pet_age").val() == ''){
            showPageModal('Please fill all the fields', 'Submit Error', 'error');
            return false;
        }
        $(this).prop('disabled', true);
        $(this).text('Submitting');
        var pet_id = $("#pet_id").val();
        var target = '/pet/' + pet_id + '/uploadImage';
        var formData = new FormData($("#petForm")[0]);
		$.ajax({
	        type: 'POST',
	        url: target,
            data: formData,
            processData: false,
			contentType: false,
	        success: function(result){
	            $("#btn-submit").prop('disabled', false);
                $("#btn-submit").text('Submit form');
                if(result.code == 200){
                    showPageModal('Uploaded Successfully', 'Successful', 'success');
                }
                else{
                    showPageModal(result.message, 'Submit Error', 'error');
                }
	        },
            error: function(result){
                $("#btn-submit").prop('disabled', false);
                $("#btn-submit").text('Submit form');
                var error = 'Internal Error';
                if(result.status == 404) error = 'Url not found';
                else if(result.status == 500) error = 'Server error';
                else {
                    error = result.statusText;
                }
                showPageModal(error, 'Submit Error', 'error');
	        }
        });
        return true;
	});
});