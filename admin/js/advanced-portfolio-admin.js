(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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
		jQuery(document).on('change','#select_portfolio_type', function(){
	            var type = jQuery(this).val();
	            if(type=='slider_single' || type=="slider_double"){
	                jQuery(document).find('#portfolio-slider-box').show();
	            }
	            else{
	                jQuery(document).find('#portfolio-slider-box').hide();
	            }
	        });
		jQuery(document).on('change','#portfolio_type', function(){
			if(jQuery(this).attr('checked')=='checked'){
				jQuery(document).find('.ap_video_portfolio_media').show();
			}
			else{
				jQuery(document).find('.ap_video_portfolio_media').hide();
			}
		});
	});
})( jQuery );
