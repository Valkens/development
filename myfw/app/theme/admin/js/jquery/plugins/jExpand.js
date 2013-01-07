(function($){
    $.fn.jExpand = function(){
        var element = this;
        var expand = $(element).find("td.expand").parent().hide();
		expand.prev().find('.arrow').click(function() {
			$(this).parent().parent().next().toggle();
			$(this).toggleClass('arrowUp');
		});
    }    
})(jQuery); 