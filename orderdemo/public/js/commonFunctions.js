function showPageModal(text,title,type){
    if(typeof(type) === 'undefined'){type = 'info';}
    $('#pageModalText').html(text);
    // Hide the title block if no title is provided
    if(typeof(title) === 'undefined') {
        $('.modal-header').hide();
    } else {
        $('#pageModalTitle').html(title);
    }
    $('#messageIcon').removeClass();
    if (type == 'error') {
        $('#messageIcon').html('<i class="fa fa-times-circle fa-4x" aria-hidden="true"></i>');
    } else if (type == 'success') {
        $('#messageIcon').html('<i class="fa fa-check-circle fa-4x" aria-hidden="true"></i>');
    } else {
        $('#messageIcon').html('<i class="fa fa-info-circle fa-4x" aria-hidden="true"></i>');
    }
    // Do not allow the customer to press the grey overlay or press ESC to exit the modal
    $('#pageModal').modal({
    	show: true,
    	keyboard: false,
    	backdrop: 'static'
    });
    $('#pageModal').modal('show');
}