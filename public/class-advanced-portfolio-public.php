<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Advanced_Portfolio
 * @subpackage Advanced_Portfolio/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Advanced_Portfolio
 * @subpackage Advanced_Portfolio/public
 * @author     Iqbal Hussain <k.iqbal.r@gmail.com>
 */
class Advanced_Portfolio_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	private $posttype;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		add_shortcode( 'advanced-portfolio', array($this, 'advanced_portfolio_shortcode_callback' ));
		add_action('wp_head',array($this, 'lightbox_options'));

	}
	public function advanced_portfolio_shortcode_callback($atts){
		$atts= shortcode_atts(
			array(
			'id'=>''
			),$atts,'advanced-portfolio');
		if(empty($atts['id']) || !is_numeric($atts['id']))
		{
			echo __('It seems portfolio shortcode id is missing.','advanced-portfolio');
		}
		else{
		wp_enqueue_script( 'html5lightbox');
			$type=get_post_meta($atts['id'],'portfolio_type',true);
			switch ($type) {
				case 'filterable':
					$this->filterable_portfolio($atts['id']);
					break;
				case 'simple':
					$this->simple_portfolio($atts['id']);
					break;
				case 'slider_single':
					$this->slider_single_portfolio($atts['id']);
					break;
				case 'slider_double':
					$this->slider_double_portfolio($atts['id']);
					break;
				default:
					$this->filterable_portfolio($atts['id']);
					break;
			}
			
		}
	}
	public function manage_options($options)
	{
		 switch ($options['style']) {
      	case 'style-1':
      		$options['style']='modern-style';
      		break;
      	case 'style-2':
      		$options['style']='iq_portfolio_filter';
      		break;
      	case 'style-3':
      		$options['style']='full-overlay-style ';
      		break;	
      	case 'style-4':
      		$options['style']='slide-from-bottom';
      		break;	
      	case 'style-5':
      		$options['style']='slide-from-right';
      		break;	
      	case 'style-6':
      		$options['style']='slide-from-left';
      		break;	
      	case 'style-7':
      		$options['style']='flip-style';
      		break;	
      	case 'style-8':
      		$options['style']='zoom-in-zoom-out';
      		break;	
      	case 'style-9':
      		$options['style']='slide-from-top';
      		break;
      	case 'style-10':
      		$options['style']='hover-animated-skew';
      		break;		
      	default:
      		$options['style']='iq_portfolio_filter';
      		break;
      }  
      return $options;
	}
	public function filterable_portfolio($id){
		$options= $this->manage_options(get_post_meta($id,'portfolio_options',true));
		$lightbox=get_post_meta($id,'portfolio_lightbox_options',true);
		include( dirname(__FILE__).'/portfolio/filterable.php' );
	}
	public function simple_portfolio($id){
		$options= $this->manage_options(get_post_meta($id,'portfolio_options',true));
		$lightbox=get_post_meta($id,'portfolio_lightbox_options',true);

		include( dirname(__FILE__).'/portfolio/simple.php' );
	}
	public function slider_single_portfolio($id){
		$slider=get_post_meta($id,'portfolio_slider',true);
		wp_enqueue_script( 'slick');
		$options= $this->manage_options(get_post_meta($id,'portfolio_options',true));
		$lightbox=get_post_meta($id,'portfolio_lightbox_options',true);

		include( dirname(__FILE__).'/portfolio/one_row_slider.php' );
	}
	public function slider_double_portfolio($id){
		wp_enqueue_script( 'slick');
		//wp_enqueue_script( 'portfolio-slider');
		$options= $this->manage_options(get_post_meta($id,'portfolio_options',true));
		$lightbox=get_post_meta($id,'portfolio_lightbox_options',true);

		include( dirname(__FILE__).'/portfolio/two_row_slider.php' );
	}
	public function get_social_share_links(){
			?>
			<div class="socialShareLinks" style="display: none;">
            	<a href="javascript:void(0)" data-url="<?php echo 'https://www.facebook.com/sharer.php?u='.urlencode(get_the_permalink()).'&title='.urlencode(get_the_title());  ?>" target="_blank"><span class="fa fa-facebook"></span></a>
            	<a href="javascript:void(0)" data-url="<?php echo 'https://plus.google.com/share?url='.urlencode(get_the_permalink());  ?>"  target="_blank"><span class="fa fa-google-plus"></span></a>
            	<a href="javascript:void(0)" data-url="<?php echo 'https://www.linkedin.com/shareArticle?mini=true&amp;url='.urlencode(get_the_permalink()) . '&title=' . urlencode(get_the_title()) . '&source=' . get_bloginfo('url');  ?>"  target="_blank"><span class="fa fa-linkedin"></span></a>
            	<a href="javascript:void(0)" data-url="<?php echo 'https://twitter.com/home?status='.urlencode(get_the_title()). '+'. urlencode(get_the_permalink());  ?>"  target="_blank"><span class="fa fa-twitter"></span></a>
            	<a href="javascript:void(0)" data-url="<?php echo 'https://pinterest.com/pin/create/button/?url='. urlencode(get_the_permalink()).'&description='.urlencode(get_the_title());  ?>"  target="_blank"><span class="fa fa-pinterest"></span></a>
            	<a href="javascript:void(0)" data-url="<?php echo 'https://www.tumblr.com/widgets/share/tool?canonicalUrl='. urlencode(get_the_permalink()).'&title='.urlencode(get_the_title());  ?>"  target="_blank"><span class="fa fa-tumblr"></span></a>
        	</div>
			<?php
	}
		public function lightbox_options(){
			?>
			<script type="text/javascript">
			var html5lightbox_options = {
			        showplaybutton: false,
			        fullscreenmode: true,
			        titlestyle: "outside",
			        showsocial: true,
			        socialdirection: "vertical",
			        socialposition: "position:absolute;top:0;right:-10;",
			        shownavigation: true

			};
			</script>
			<?php
		}
	public function videoEmbed($url) {
	    if (strpos($url, 'youtube') > 0) {
	    	$regexstr = '~
			(?:				 				# Group to match embed codes
				(?:&lt;iframe [^&gt;]*src=")?	 	# If iframe match up to first quote of src
				|(?:				 		# Group to match if older embed
					(?:&lt;object .*&gt;)?		# Match opening Object tag
					(?:&lt;param .*&lt;/param&gt;)*  # Match all param tags
					(?:&lt;embed [^&gt;]*src=")?  # Match embed tag to the first quote of src
				)?				 			# End older embed code group
			)?				 				# End embed code groups
			(?:				 				# Group youtube url
				https?:\/\/		         	# Either http or https
				(?:[\w]+\.)*		        # Optional subdomains
				(?:               	        # Group host alternatives.
				youtu\.be/      	        # Either youtu.be,
				| youtube\.com		 		# or youtube.com 
				| youtube-nocookie\.com	 	# or youtube-nocookie.com
				)				 			# End Host Group
				(?:\S*[^\w\-\s])?       	# Extra stuff up to VIDEO_ID
				([\w\-]{11})		        # $1: VIDEO_ID is numeric
				[^\s]*			 			# Not a space
			)				 				# End group
			"?				 				# Match end quote if part of src
			(?:[^&gt;]*&gt;)?			 			# Match any extra stuff up to close brace
			(?:				 				# Group to match last embed code
				&lt;/iframe&gt;		         	# Match the end of the iframe	
				|&lt;/embed&gt;&lt;/object&gt;	        # or Match the end of the older embed
			)?				 				# End Group of last bit of embed code
			~ix';
	    	preg_match($regexstr, $url, $matches);
			$video_id = $matches[1];
	    	$html['iframe']='<iframe class="videoheight" style="margin:0auto;" src="https://www.youtube.com/embed/'.$video_id.'?rel=0" width="100%" height="auto" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""> </iframe>';
	    	$html['videolink']='https://www.youtube.com/watch?v='.$video_id;
	    	$html['thumb'] = 'http://img.youtube.com/vi/' . $video_id. '/0.jpg';
	        return $html;
	    } elseif (strpos($url, 'vimeo') > 0) {
	    	$regexstr = '~
			# Match Vimeo link and embed code
			(?:&lt;iframe [^&gt;]*src=")?		# If iframe match up to first quote of src
			(?:							# Group vimeo url
				https?:\/\/				# Either http or https
				(?:[\w]+\.)*			# Optional subdomains
				vimeo\.com				# Match vimeo.com
				(?:[\/\w]*\/videos?)?	# Optional video sub directory this handles groups links also
				\/						# Slash before Id
				([0-9]+)				# $1: VIDEO_ID is numeric
				[^\s]*					# Not a space
			)							# End group
			"?							# Match end quote if part of src
			(?:[^&gt;]*&gt;&lt;/iframe&gt;)?		# Match the end of the iframe
			(?:&lt;p&gt;.*&lt;/p&gt;)?		        # Match any title information stuff
			~ix';
			preg_match($regexstr, $url, $matches);
			$video_id = $matches[1];
			$html['iframe']='<iframe src="https://player.vimeo.com/video/'.$video_id .'" width="640" height="272" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
	    	$html['videolink']='https://player.vimeo.com/video/'.$video_id.'';
			$html['thumb'] = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"))[0]['thumbnail_large'];
	        return $html;
	    } else {
	        return 'unknown';
	    }
	}
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advanced_Portfolio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Portfolio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'slick', plugin_dir_url( __FILE__ ) . 'css/slick.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'slick-theme', plugin_dir_url( __FILE__ ) . 'css/slick-theme.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'fontawesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advanced-portfolio-public.css', array(), $this->version, 'all',1000);

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advanced_Portfolio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Portfolio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( 'isotope', plugin_dir_url( __FILE__ ) . 'js/isotope.min.js', array( 'jquery' ), $this->version, false );
		wp_register_script( 'slick', plugin_dir_url( __FILE__ ) . 'js/slick.min.js', array( 'jquery' ), $this->version, false );
		wp_register_script( 'portfolio-slider', plugin_dir_url( __FILE__ ) . 'js/slider-custom.js', array( 'jquery' ), $this->version, false );
		wp_register_script( 'html5lightbox', plugin_dir_url( __FILE__ ) . 'js/html5lightbox.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-portfolio-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name, 'ajax_var', array(
		    'url' => admin_url('admin-ajax.php'),
		    'nonce' => wp_create_nonce('ajax-nonce')
		));
	}

}
