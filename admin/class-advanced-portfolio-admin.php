<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Advanced_Portfolio
 * @subpackage Advanced_Portfolio/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advanced_Portfolio
 * @subpackage Advanced_Portfolio/admin
 * @author     Iqbal Hussain <k.iqbal.r@gmail.com>
 */
class CI_Advanced_Portfolio_Admin {

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
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->posttype='advanced-portfolio';
		$this->options=get_option('ap_singlepage_settings',true);
		if(isset($this->options['slug']) && !empty($this->options['slug'])){
			$this->posttype=$this->options['slug'];
		}

		add_action( 'init', array($this, 'portfolio_register'), 10 );
		add_action( 'init', array($this, 'register_portfolio_taxonomies'));
		add_action( 'add_meta_boxes', array($this, 'portfolio_register_metabox' ));
		add_action( 'save_post_advanced-portfolio', array($this, 'save_portfolio_meta_box_data' ));
		add_action( 'admin_menu', array($this,'register_admin_menu'));
	
	}
	
	public function portfolio_register() {
		$labels = array(
			'name'                  => _x( 'Portfolios', 'Post Type General Name', 'advanced-portfolio' ),
			'singular_name'         => _x( 'Portfolio', 'Post Type Singular Name', 'advanced-portfolio' ),
			'menu_name'             => __( 'Portfolio', 'advanced-portfolio' ),
			'name_admin_bar'        => __( 'Portfolio', 'advanced-portfolio' ),
			'archives'              => __( 'Item Archives', 'advanced-portfolio' ),
			'attributes'            => __( 'Item Attributes', 'advanced-portfolio' ),
			'parent_item_colon'     => __( 'Parent Item:', 'advanced-portfolio' ),
			'all_items'             => __( 'Add Portfolio', 'advanced-portfolio' ),
			'add_new_item'          => __( 'Add New Item', 'advanced-portfolio' ),
			'add_new'               => __( 'Add New', 'advanced-portfolio' ),
			'new_item'              => __( 'New Item', 'advanced-portfolio' ),
			'edit_item'             => __( 'Edit Item', 'advanced-portfolio' ),
			'update_item'           => __( 'Update Item', 'advanced-portfolio' ),
			'view_item'             => __( 'View Item', 'advanced-portfolio' ),
			'view_items'            => __( 'View Items', 'advanced-portfolio' ),
			'search_items'          => __( 'Search Item', 'advanced-portfolio' ),
			'not_found'             => __( 'Not found', 'advanced-portfolio' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'advanced-portfolio' ),
			'featured_image'        => __( 'Featured Image', 'advanced-portfolio' ),
			'set_featured_image'    => __( 'Set featured image', 'advanced-portfolio' ),
			'remove_featured_image' => __( 'Remove featured image', 'advanced-portfolio' ),
			'use_featured_image'    => __( 'Use as featured image', 'advanced-portfolio' ),
			'insert_into_item'      => __( 'Insert into item', 'advanced-portfolio' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'advanced-portfolio' ),
			'items_list'            => __( 'Items list', 'text_domain' ),
			'items_list_navigation' => __( 'Items list navigation', 'advanced-portfolio' ),
			'filter_items_list'     => __( 'Filter items list', 'advanced-portfolio' ),
		);
			$temp=(isset($this->options['single_page']) && $this->options['single_page']=='yes') ? true : false;
			$args = array(
				'label'                 => __( 'Portfolio', 'advanced-portfolio' ),
				'description'           => __( 'Portfolio for your site', 'advanced-portfolio' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor','thumbnail','excerpt','comments','reviews'),
				'hierarchical'          => false,
				'public'                => $temp,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'show_in_nav_menus'		=> false,
				'rewrite'				=> array('slug'=>$this->posttype),
				'menu_position'         => 5,
				'menu_icon'           => 'dashicons-portfolio',
				'show_in_admin_bar'     => false,
				'show_in_nav_menus'     => false,
				'can_export'            => false,
				'has_archive'           => false,
				'exclude_from_search'   => $temp,
				'publicly_queryable'    => $temp,
				'capability_type'       => 'page',
			);
		$Multiplelabels = array(
			'name'                  => _x( 'Add Portfolio Shortcodes & Settings', 'Post Type General Name', 'advanced-portfolio' ),
			'singular_name'         => _x( 'Portfolios', 'Post Type Singular Name', 'advanced-portfolio' ),
			'menu_name'             => __( 'Portfolios', 'advanced-portfolio' ),
			'name_admin_bar'        => __( 'Portfolios', 'advanced-portfolio' ),
		);
		$multipleargs = array(
				'label'                 => __( 'Add Portfolio Shortcodes & Settings', 'advanced-portfolio' ),
				'description'           => __( 'Portfolio Shortcode for your site', 'advanced-portfolio' ),
				'labels'                => $Multiplelabels,
				'supports'              => array( 'title','thumbnail'),
				'hierarchical'          => false,
				'public'                => false,
				'show_ui'               => true,
				'show_in_menu'          => false,
				'rewrite'				=> false,
				'menu_position'         => null,
				'show_in_admin_bar'     => false,
				'can_export'            => false,
				'has_archive'           => true,
				'exclude_from_search'   => true,
				'publicly_queryable'    => false,
				'capability_type'       => 'post',
			);
		register_post_type( 'advanced-portfolio' , $args );
		register_post_type( 'advportfolios' , $multipleargs );

		}
		public function register_portfolio_taxonomies(){
			register_taxonomy(
				'portfolio_tags',
				array('advanced-portfolio'),
				array(
					'label' => __( 'Tags','glassco' ),
					'rewrite' => array( 'slug' => 'portfolio_tags' ),
					'hierarchical' => false,
				)
			);
			register_taxonomy(
				'portfolio_category',
				array('advanced-portfolio','advportfolios'),
				array(
					'label' => __( 'Category','glassco' ),
					'rewrite' => array( 'slug' => 'portfolio_category' ),
					'hierarchical' => true,
				)
			);
		}
		public function portfolio_register_metabox(){
			add_meta_box( 
				'portfolio-meta-box-id', 
				__('Portfolio Details','glassco'), 
				array($this,'portfolio_metabox_callback'), 
				'advanced-portfolio', 
				'normal', 
				'high' );
			add_meta_box( 
				'portfolio-shortcode-box', 
				__('Portfolio Shortcode','glassco'), 
				array($this,'portfolio_shortoce_metabox_callback'), 
				'advportfolios', 
				'side', 
				'high' );
		}
		public function portfolio_shortoce_metabox_callback(){
			global $post;
			?>
			<div class="portfolio_shortoce_metabox">
				<p>[advanced-portfolio id="<?php echo $post->ID; ?>"]</p>
			</div>
			<?php
		}
		public function portfolio_metabox_callback($post){
			wp_nonce_field( 'portfolio_meta_box_nonce', 'portfolio_meta_box_nonce' );
			$portfolio=get_post_meta($post->ID,'advanced_portfolios',true);
			//echo $post->ID;
			?>
			<div class="advancedportfolio_settings">
			<table style="width: 100%; text-align: left;">
				<tbody>
					
					<tr>
					<th><label for="linkurl"> <?php _e('Redirect External URL','advanced-portfolio'); ?></label></th>
					<td><input type="text" name="portfolio[linkurl]" id="linkurl" 
						value="<?php echo isset($portfolio['linkurl']) ? esc_attr($portfolio['linkurl']) :''; ?>" class="widefat"></td>
					</tr>
					<tr>
					<th><label for="portfolio_type"> <?php _e('Select if you want to display video for your portfolio.'); ?></label></th>
					<td>
						<label class="switch">
						  <input type="checkbox" value="video" <?php echo (isset($portfolio['mediatype']) && $portfolio['mediatype']=='video') ? 'checked' :''; ?> id="portfolio_type" name="portfolio[mediatype]" class="portfolioSwitchery">
						  <span class="slider round"></span>
						</label>
					</td>
					</tr>
				</tbody>
			</table>
			<div class="ap_video_portfolio_media" <?php echo (isset($portfolio['mediatype']) && $portfolio['mediatype']=='video') ? 'style="display: block;"' :'style="display: none;"'; ?>>
				<table style="width: 100%; text-align: left;">
				<tbody>
					<tr>
					<th><label for="portfolio_featured"> <?php _e('Use Video as a Featured image'); ?></label></th>
					<td>
						<label for="portfolio_featured">
						  <input type="checkbox" value="yes" <?php echo (isset($portfolio['video_featured']) && $portfolio['video_featured']=='yes') ? 'checked' :''; ?> id="portfolio_featured" name="portfolio[video_featured]">
						 <?php _e('Use Video thumbnail as a Featured image'); ?>
						</label>
					</td>
					</tr>
					<tr>
					<th><label for="portfolio_embed"> <?php _e('Embedded Video Code or URL (Youtube/Vimeo)','advanced-portfolio'); ?></label></th>
					<td>
						<textarea name="portfolio[embed]" id="portfolio_embed" class="widefat" rows="5" placeholder="Place Embeded Code">
							<?php echo (isset($portfolio['embed']) && !empty($portfolio['embed'])) ? esc_attr($portfolio['embed']) :trim(''); ?>
						</textarea>
					</td>
					</tr>
				</tbody>
			</table>
			</div>
		</div>
			<?php
		}
	public function save_portfolio_meta_box_data($post_id){
		// Bail if we're doing an auto save
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	     
	    // if our nonce isn't there, or we can't verify it, bail
	    if( !isset( $_POST['portfolio_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['portfolio_meta_box_nonce'], 'portfolio_meta_box_nonce' ) ) return;
	     
	    // if our current user can't edit this post, bail
	    if( !current_user_can( 'edit_post' ) ) return;
	    
	    // save 
	    	update_post_meta($post_id,'advanced_portfolios',$_POST['portfolio']);
	   
	}

	public function register_admin_menu(){
		global $submenu;
	    unset($submenu['edit.php?post_type=advanced-portfolio'][10]);
		add_submenu_page( 'edit.php?post_type=advanced-portfolio', 
			'Portfolios', 
			'Portfolio Shortcodes', 
			'manage_options', 
			'edit.php?post_type=advportfolios'
			);
		add_submenu_page( 'edit.php?post_type=advanced-portfolio', 
			'Settings', 
			'Settings', 
			'manage_options', 
			'portfolio-settings',
			array($this,'settings_menu_page_callback' )
			);
		
			
	}
	public function settings_menu_page_callback(){
		require_once plugin_dir_path( __FILE__ ) . 'class-advanced-portfolio-settings.php';
		$settings= new CI_Advanced_Portfolio_Settings();
	}
	
	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advanced-portfolio-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-portfolio-admin.js', array( 'jquery' ), $this->version, false );

	}

}
