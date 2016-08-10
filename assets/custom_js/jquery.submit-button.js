$(document).ready(function() {
	$('input:submit, button:submit').click(function(){
		var $this = $(this);
		$this.prop("disabled", true);
		$(this).parents('form').submit();
		setTimeout(function() {
      $this.prop('disabled', false);
    },1000);
	});	
});