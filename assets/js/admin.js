let pvc_modal = ( show = true ) => {
	if(show) {
		jQuery('#product-view-count-modal').show();
	}
	else {
		jQuery('#product-view-count-modal').hide();
	}
}

jQuery(function($){
	$('.product-view-count-help-heading').click(function(e){
		var $this = $(this);
		var $target = $this.data('target');
		$('.product-view-count-help-text:not('+$target+')').slideUp();
		if($($target).is(':hidden')){
			$($target).slideDown();
		}
		else {
			$($target).slideUp();
		}
	});

	$('#product-view-count_report-copy').click(function(e) {
		e.preventDefault();
		$('#product-view-count_tools-report').select();

		try {
			var successful = document.execCommand('copy');
			if( successful ){
				$(this).html('<span class="dashicons dashicons-saved"></span>');
			}
		} catch (err) {
			console.log('Oops, unable to copy!');
		}
	});
})