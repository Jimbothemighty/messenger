var content = $('.body');
var sidebar = $('.col-sidebar');

	var getContentHeight = content.outerHeight();
	var getSidebarHeight = sidebar.outerHeight();

	if ( getContentHeight > getSidebarHeight ) {
		sidebar.css('min-height', getContentHeight);
	}

	if ( getSidebarHeight > getContentHeight ) {
		content.css('min-height', getSidebarHeight);
	}

