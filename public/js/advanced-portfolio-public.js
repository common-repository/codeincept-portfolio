(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
    
	 jQuery(document).ready(function(){
        jQuery(".sharePortfolio").click(function(e){
            e.preventDefault();
            jQuery(this).closest('.article-caption').find('.socialShareLinks').slideToggle();
        });
        //social links 
        jQuery(".socialShareLinks a").click(function(e){
            e.preventDefault();
            var url = $(this).data('url');
            window.open(url,'sharer','toolbar=0,status=0,width=648,height=395');
            return true;
        });
        
// portfolio
    var portfolio = window.portfolio || {},
        $win = $( window );
    portfolio.Isotope = function () {
// 4 column layout
        var isotopeContainer = $('.isotopeContainer');
        if( !isotopeContainer.length || !jQuery().isotope ) return;
        $win.load(function(){
            isotopeContainer.isotope({
                itemSelector: '.isotopeSelector'
            });
        $('.isotopeFilters').on( 'click', 'a', function(e) {
                $('.isotopeFilters').find('.active').removeClass('active');
                $(this).parent().addClass('active');
                var filterValue = $(this).attr('data-filter');
                isotopeContainer.isotope({ filter: filterValue });
                e.preventDefault();
            });
        });
        // 3 column layout
        var isotopeContainer2 = $('.isotopeContainer2');
        if( !isotopeContainer2.length || !jQuery().isotope ) return;
        $win.load(function(){
            isotopeContainer2.isotope({
                itemSelector: '.isotopeSelector'
            });
        $('.isotopeFilters2').on( 'click', 'a', function(e) {
                $('.isotopeFilters2').find('.active').removeClass('active');
                $(this).parent().addClass('active');
                var filterValue = $(this).attr('data-filter');
                isotopeContainer2.isotope({ filter: filterValue });
                e.preventDefault();
            });
        });
        
        // 2 column layout
        var isotopeContainer3 = $('.isotopeContainer3');
        if( !isotopeContainer3.length || !jQuery().isotope ) return;
        $win.load(function(){
            isotopeContainer3.isotope({
                itemSelector: '.isotopeSelector'
            });
        $('.isotopeFilters3').on( 'click', 'a', function(e) {
                $('.isotopeFilters3').find('.active').removeClass('active');
                $(this).parent().addClass('active');
                var filterValue = $(this).attr('data-filter');
                isotopeContainer3.isotope({ filter: filterValue });
                e.preventDefault();
            });
        });
        
        // 1 column layout
        var isotopeContainer4 = $('.isotopeContainer4');
        if( !isotopeContainer4.length || !jQuery().isotope ) return;
        $win.load(function(){
            isotopeContainer4.isotope({
                itemSelector: '.isotopeSelector'
            });
        $('.isotopeFilters4').on( 'click', 'a', function(e) {
                $('.isotopeFilters4').find('.active').removeClass('active');
                $(this).parent().addClass('active');
                var filterValue = $(this).attr('data-filter');
                isotopeContainer4.isotope({ filter: filterValue });
                e.preventDefault();
            });
        });
    };
    portfolio.Isotope();
    jQuery(window).load(function(){
        $('.isotopeFilters a.active').trigger( 'click');
    });
   // myTheme.Fancybox();
    jQuery(window).load(function(){
        //jQuery(document).find('.portfoliofilters ul > li > a').trigger( 'click');
    });
});
})( jQuery );
