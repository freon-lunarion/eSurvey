<script type="text/javascript">
<?php
	if ($all_unit){
?>
	$('#div_unit').hide();
	$('#swt_responden').bootstrapSwitch('setState', true);
<?php
	}else{
?>
	$('#div_all').hide();
	$('#swt_responden').bootstrapSwitch('setState', false);
<?php
	}
?>
	var base_url = "<?php echo base_url() ?>";
	$('#swt_responden').on('switch-change', function (e, data) {
    if(data.value==true){
			$('#div_unit').hide();
			$('#div_all').show();

    }else{
			$('#div_unit').show();
			$('#div_all').hide();

    }
    $.ajax({
			url: base_url + "index.php/kuesioner/ajax_responden",
			data: {kuesioner_id: <?php echo $kuesioner_id ?>},
			type: "post",
			success: function(msg){
				$("#slc_dim").html(msg);
				$('#spin_1').hide();
			}
		});
	});
</script>