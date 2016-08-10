$(document).ready(function(){
$("input[type=checkbox]").each(function(index, element) { 
	if($(element).data( "type" )=='abstain'){		
		$(element).on('change',function(){
			if($(this).is(':checked')){
				$("input[type=checkbox]").each(function(index2, element2) { 
					if($(element2).data( "type" )=='option' &&  $(element2).data( "group" )==$(element).data( "group" ) ){		
						$(element2).prop('checked', false);
						// oldData = $element2.data('validation-minchecked-minchecked');
						// $(element2).removeAttr('data-validation-minchecked-minchecked').attr({'data-validation-minchecked-minchecked-off': oldData });
						$(element2).attr("disabled", true);
						// $(element2).removeData("validation-minchecked-minchecked");


					}
				});
				// console.log(index + ':' + $(element).data( "group" )); 
			}else{
				$("input[type=checkbox]").each(function(index2, element2) { 
					if($(element2).data( "type" )=='option' &&  $(element2).data( "group" )==$(element).data( "group" ) ){		
						$(element2).removeAttr("disabled");
					}
				});
			}
		});
	}
	});
});