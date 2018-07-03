$(document).ready(function() {

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	function refreshTable(pageIndex) {
		$('div.row.justify-content-center').fadeOut();
		$('div.row.justify-content-center').load('https://vocsway.com/people/' + pageIndex, function() {
				$('div.row.justify-content-center').fadeIn();

		});
	}
	
	$('#next-slide').on('click', function() {
		
				var currentPage = $('.page-item-footer').find('.active').text().trim();
				var currIndex = currentPage.substr(currentPage.length - 1);
				var nextPage = $('.page-item-footer').find('#fp-viewing-'+(parseInt(currIndex) + 1));
				if(nextPage.length > 0){
					nextPage.removeClass('down');
					nextPage.addClass('active');
					$('.page-item-footer').find('#fp-viewing-'+currIndex).removeClass('active');
					$('.page-item-footer').find('#fp-viewing-'+currIndex).addClass('up');
					var scrollVar = nextPage.index();	
					$('#scroll_page').animate({
						scrollTop: (scrollVar * 16) - 7
					}, 777);
					refreshTable(parseInt(currIndex) + 1);
				}
			});
	
	$('#prev-slide').on('click', function() {
				var currentPage = $('.page-item-footer').find('.active').text().trim();
				var currIndex = currentPage.substr(currentPage.length - 1);
				var prevPage = $('.page-item-footer').find('#fp-viewing-'+(parseInt(currIndex) - 1));
				if (prevPage.length > 0){
					$('.page-item-footer').find('#fp-viewing-'+currIndex).removeClass('active');
					$('.page-item-footer').find('#fp-viewing-'+currIndex).addClass('down');
					prevPage.removeClass('up');
					prevPage.addClass('active');
					var scrollVar = prevPage.index();
					$('#scroll_page').animate({
						scrollTop: scrollVar*16 - 7
					}, 777);
					refreshTable(parseInt(currIndex) - 1);	
				}	
			});
});