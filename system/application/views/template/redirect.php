<script type="text/javascript">
	jQuery(document).ready(function($) {
		var time = <?php echo $time ?> * 1000
		window.setTimeout(function(){
        window.location.href = "<?php echo $loc ?>";
    }, time);
		window.setInterval(function() {
			var timeLeft    = $("#timeLeft").html();                                
		  if(eval(timeLeft) >0){
		    $("#timeLeft").html(eval(timeLeft)- eval(1));
		  }
		}, 1000);
	});
</script>
