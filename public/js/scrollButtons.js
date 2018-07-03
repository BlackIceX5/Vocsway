$(document).ready(function() {
	
	var $scroll = 0;
	
	var $elem = $('.secondScrollContainer');
	$('#page-action-holder-left').click (function() {
		$('.secondScrollContainer').animate({scrollTop: $scroll - 200 }, 'slow');
		$scroll = $scroll - 200;
    });
	
	$('#page-action-holder-right').click (function() {
		
		$('.secondScrollContainer').animate({scrollTop: $scroll +200 }, 'slow');
		$scroll = $scroll +200;
    });

	
});