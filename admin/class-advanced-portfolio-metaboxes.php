<?php
if(!class_exists('CIAP_Advanced_Portfolio_Metabox_Settings'))
{
	class CIAP_Advanced_Portfolio_Metabox_Settings 
	{
		function __construct()
		{
            add_action( 'add_meta_boxes', array($this, 'portfolio_shortcode_metabox' ));
            add_action( 'save_post_advportfolios', array($this, 'save_post_advportfolios_callback' ));
            add_filter( 'manage_edit-advportfolios_columns', array($this, 'set_custom_edit_advportfolios_columns') );
            add_action( 'manage_advportfolios_posts_custom_column', array($this, 'manage_custom_columns' ), 10, 2 );
        }
		 public function portfolio_shortcode_metabox(){
            add_meta_box( 
                'portfolio-type-box', 
                __('Portfolio Type','advanced-portfolio'), 
                array($this,'portfolio_type_metabox_callback'), 
                'advportfolios', 
                'normal', 
                'high' );
            add_meta_box( 
                'portfolio-options-box', 
                __('Portfolio Options','advanced-portfolio'), 
                array($this,'portfolio_options_metabox_callback'), 
                'advportfolios', 
                'normal', 
                'high' );
            /*
            add_meta_box( 
                'portfolio-slider-box', 
                __('Portfolio Slider options','advanced-portfolio'), 
                array($this,'portfolio_slider_metabox_callback'), 
                'advportfolios', 
                'normal', 
                'high' ); */
            add_meta_box( 
                'portfolio-lightbox-box', 
                __('Portfolio LightBox Settings','advanced-portfolio'), 
                array($this,'portfolio_lightbox_metabox_callback'), 
                'advportfolios', 
                'normal', 
                'high' );
            
        }
        public function portfolio_type_metabox_callback(){
        	global $post;
        	$portfolio=get_post_meta($post->ID, 'portfolio_type',true);
        	?>
        	<div class="ciap_advanced_portfolio_main">
        	<table class="ciap_advanced_portfolio">
        		<tbody>
        			<tr>
        				<th><label for="select_portfolio_type">
        					<?php echo __('Select Portfolio Type','advanced-portfolio'); ?>
        				</label></th>
        				<td>
        					<select name="portfolio_type" id="select_portfolio_type">
        						<option value="filterable" <?php echo (isset($portfolio) && $portfolio=='filterable') ? 'selected' : ''; ?>><?php _e('Filterable Portfolio','advanced-portfolio'); ?></option>
        						<option value="simple" <?php echo (isset($portfolio) && $portfolio=='simple') ? 'selected' : ''; ?>><?php _e('Simple Grid Gallery','advanced-portfolio'); ?></option>
        						<option value="slider_single" <?php echo (isset($portfolio) && $portfolio=='slider_single') ? 'selected' : ''; ?>><?php _e('Portfolio Slider Single','advanced-portfolio'); ?></option>
                                <option value="slider_double" <?php echo (isset($portfolio) && $portfolio=='slider_double') ? 'selected' : ''; ?>><?php _e('Portfolio Slider Double','advanced-portfolio'); ?></option>
                            </select>
        				</td>
        			</tr>
        		</tbody>
        	</table>
        </div>
        	<?php
        }
        public function portfolio_options_metabox_callback(){
        	global $post;
        	$options=get_post_meta($post->ID,'portfolio_options',true);
            
            ?>
            <div class="ciap_advanced_portfolio_main">
        	<table class="ciap_advanced_portfolio">
        		<tbody>
        			<tr>
        				<th><label for="portolio_items">
        					<?php echo __('Number of portfolio items','advanced-portfolio'); ?>
        				</label></th>
        				<td>
        					<input type="text" class="widefat" name="options[items]" id="portolio_items" value="<?php echo isset($options['items']) ? $options['items'] : '-1';  ?>">
        				</td>
        			</tr>
        			<tr>
        				<th><label for="select_portfolio_style">
        					<?php echo __('Select Portfolio Style','advanced-portfolio'); ?>
        				</label></th>
        				<td>
        					<select name="options[style]" id="select_portfolio_style">
        						<option value="style-1" <?php echo (isset($options['style']) && $options['style']=='style-1') ? 'selected' : ''; ?>>
        							<?php _e('Style-1','advanced-portfolio'); ?></option>
        						<option value="style-2" <?php echo (isset($options['style']) && $options['style']=='style-2') ? 'selected' : ''; ?>>
        							<?php _e('Style-2','advanced-portfolio'); ?></option>
        						<option value="style-3" <?php echo (isset($options['style']) && $options['style']=='style-3') ? 'selected' : ''; ?>>
                                    <?php _e('Style-3','advanced-portfolio'); ?></option>
                                <option value="style-4" <?php echo (isset($options['style']) && $options['style']=='style-4') ? 'selected' : ''; ?>>
                                    <?php _e('Style-4','advanced-portfolio'); ?></option>
                                <option value="style-5" <?php echo (isset($options['style']) && $options['style']=='style-5') ? 'selected' : ''; ?>>
                                    <?php _e('Style-5','advanced-portfolio'); ?></option>
                                <option value="style-6" <?php echo (isset($options['style']) && $options['style']=='style-6') ? 'selected' : ''; ?>>
                                    <?php _e('Style-6','advanced-portfolio'); ?></option>
                                <option value="style-7" <?php echo (isset($options['style']) && $options['style']=='style-7') ? 'selected' : ''; ?>>
                                    <?php _e('Style-7','advanced-portfolio'); ?></option>
                                <option value="style-8" <?php echo (isset($options['style']) && $options['style']=='style-8') ? 'selected' : ''; ?>>
                                    <?php _e('Style-8','advanced-portfolio'); ?></option>
                                <option value="style-9" <?php echo (isset($options['style']) && $options['style']=='style-9') ? 'selected' : ''; ?>>
                                    <?php _e('Style-9','advanced-portfolio'); ?></option>
                                <option value="style-10" <?php echo (isset($options['style']) && $options['style']=='style-10') ? 'selected' : ''; ?>>
                                    <?php _e('Style-10','advanced-portfolio'); ?></option>
        					</select>
        				</td>
        			</tr>
                    <tr>
                        <th><label for="showall">
                            <?php echo __("Show All in Filterable Portfolio Categories?",'advanced-portfolio'); ?>
                        </label></th>
                        <td>
                            <input type="checkbox" name="options[showall]" value="1" id="showall" <?php echo (isset($options['showall']) && $options['showall']=='yes') ? 'checked' : ''; ?>>
                        </td>
                    </tr>
					<tr>
        				<th><label for="select_grid_columns">
        					<?php echo __('Grid Columns','advanced-portfolio'); ?>
        				</label></th>
        				<td>
        					<select name="options[columns]" id="select_grid_columns">
        						<?php  for($num=1; $num<5; $num++):  ?>
        						<option value="<?php echo $num; ?>" <?php echo (isset($options['columns']) && $options['columns']==$num) ? 'selected' : ''; ?>><?php echo $num; ?></option>
        						<?php endfor; ?>
        					</select>
        				</td>
        			</tr>
        			<tr>
        				<th><label for="columns_space">
        					<?php echo __('No Space between Columns','advanced-portfolio'); ?>
        				</label></th>
        				<td>
        					<input type="checkbox" name="options[nospace]" value="1" id="columns_space" <?php echo (isset($options['nospace']) && $options['nospace']=='yes') ? 'checked' : ''; ?>>
        				</td>
        			</tr>
                    <tr>
                        <th><label for="share_btn">
                            <?php echo __('Disable Share Icon?','advanced-portfolio'); ?>
                        </label></th>
                        <td>
                            <input type="checkbox" name="options[sharebtn]" value="1" id="share_btn" <?php echo (isset($options['sharebtn']) && $options['sharebtn']=='yes') ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="pagelink">
                            <?php echo __('Disable Page/External link Icon?','advanced-portfolio'); ?>
                        </label></th>
                        <td>
                            <input type="checkbox" name="options[pagelink]" value="1" id="pagelink" <?php echo (isset($options['pagelink']) && $options['pagelink']=='yes') ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="hidetitle">
                            <?php echo __("Don't Show Portfolio Title?",'advanced-portfolio'); ?>
                        </label></th>
                        <td>
                            <input type="checkbox" name="options[title]" value="1" id="hidetitle" <?php echo (isset($options['title']) && $options['title']=='yes') ? 'checked' : ''; ?>>
                        </td>
                    </tr>
        		</tbody>
        	</table>
        </div>
            <?php
        }
        public function portfolio_slider_metabox_callback(){
            global $post;
            $slider=get_post_meta($post->ID,'portfolio_slider',true);
            
            ?>
            <div class="ciap_advanced_portfolio_main">
            <table class="ciap_advanced_portfolio">
                <tbody>
                    <tr>
                        <th><label for="slider_autoplay">
                            <?php echo __('Disable Autoplay?','advanced-portfolio'); ?>
                        </label></th>
                        <td>
                            <input type="checkbox" name="slider[autoplay]" value="1" id="slider_autoplay" <?php echo (isset($slider['autoplay']) && $slider['autoplay']=='yes') ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="slider_speed">
                            <?php echo __('Play Speed in milliseconds','advanced-portfolio'); ?>
                        </label></th>
                        <td>
                            <input type="text" class="widefat" name="slider[speed]" id="slider_speed" value="<?php echo isset($slider['speed']) ? $slider['speed'] : '3000';  ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="slider_scroll">
                            <?php echo __('Slides to Scroll','advanced-portfolio'); ?>
                        </label></th>
                        <td>
                            <select name="slider[scroll]" id="slider_scroll">
                                <?php  for($num=1; $num<5; $num++):  ?>
                                <option value="<?php echo $num; ?>" <?php echo (isset($slider['scroll']) && $slider['scroll']==$num) ? 'selected' : ''; ?>><?php echo $num; ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="slider_arrows">
                            <?php echo __('Hide Next/Previous Arrows?','advanced-portfolio'); ?>
                        </label></th>
                        <td>
                            <input type="checkbox" name="slider[arrows]" value="1" id="slider_arrows" <?php echo (isset($slider['arrows']) && $slider['arrows']=='yes') ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="slider_dots">
                            <?php echo __('Enable bottom dot navigation?','advanced-portfolio'); ?>
                        </label></th>
                        <td>
                            <input type="checkbox" name="slider[dots]" value="1" id="slider_dots" <?php echo (isset($slider['dots']) && $slider['dots']=='yes') ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
            <?php
        }
        public function portfolio_lightbox_metabox_callback(){
        	global $post;
        	$lightbox = get_post_meta($post->ID, 'portfolio_lightbox_options', true);
        	?>
        	<div class="advancedportfolio_settings">
        	<table class="ciap_advanced_portfolio">
        		<tbody>
        			<tr>
					<th><label for="portfolio_lightbox"> <?php _e('Enable Lightbox for your portfolio.'); ?></label></th>
					<td>
						<label class="switch">
						  <input type="checkbox" value="1" <?php echo (isset($lightbox['enable']) && $lightbox['enable']=='yes') ? 'checked' :''; ?> id="portfolio_lightbox" name="lightbox[enable]" class="portfolioSwitchery">
						  <span class="slider round"></span>
						</label>
					</td>
					</tr>
        		</tbody>
        	</table>
	        </div>
        	<?php
        }
        public function save_post_advportfolios_callback($post_id){
        	// Bail if we're doing an auto save
		    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		     
		    // if our current user can't edit this post, bail
		    if( !current_user_can( 'edit_post' ) ) return;
		    
		    update_post_meta($post_id, 'portfolio_type',$_POST['portfolio_type']);
		    // save 
		    $options=$_POST['options'];
            $options['showall'] = isset($_POST['options']['showall']) ? 'yes' : 'no';
		    $options['nospace'] = isset($_POST['options']['nospace']) ? 'yes' : 'no';
            $options['sharebtn'] = isset($_POST['options']['sharebtn']) ? 'yes' : 'no';
            $options['pagelink'] = isset($_POST['options']['pagelink']) ? 'yes' : 'no';
            $options['title'] = isset($_POST['options']['title']) ? 'yes' : 'no';
		    update_post_meta($post_id, 'portfolio_options',$options);
		   	$options=$_POST['lightbox'];
		    $options['enable'] = isset($_POST['lightbox']['enable']) ? 'yes' : 'no';
		    update_post_meta($post_id, 'portfolio_lightbox_options',$options);
            if(isset($_POST['slider'])){
                $slider=$_POST['slider'];
                $slider['autoplay'] = isset($_POST['slider']['autoplay']) ? 'yes' : 'no';
                $slider['arrows'] = isset($_POST['slider']['arrows']) ? 'yes' : 'no';
                $slider['dots'] = isset($_POST['slider']['dots']) ? 'yes' : 'no';
                update_post_meta($post_id, 'portfolio_slider',$slider);
            }
        }
        public function set_custom_edit_advportfolios_columns($columns){
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'title' => __( 'Title' ,'advanced-portfolio'),
                'shortcode' => __( 'Shortcode', 'advanced-portfolio' ),
                'category' => __( 'Categories' ,'advanced-portfolio'),
                'date' => __( 'Date' )
            );

            return $columns;
        }
        public function manage_custom_columns($column, $post_id){
            global $post;
            switch ( $column ) {
                case 'shortcode' :
                        echo '<p class="advportfolios_shortcode">[advanced-portfolio id='.$post_id.']</p>';
                    break;
                case 'category' :
                     $terms = get_the_terms( $post_id, 'portfolio_category' );
                     if ( !empty( $terms ) ) {
                $out = array();
                    foreach ( $terms as $term ) {
                        $out[] = sprintf( '<a href="%s">%s</a>',
                            esc_url( add_query_arg( array( 'post_type' => 'advanced-portfolio', 'taxonomy' => 'portfolio_category' ), 'edit-tags.php' ) ),
                            esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'portfolio_category', 'display' ) )
                        );
                        }
                        echo join( ', ', $out );
                    }
                    break;
                default :
                    break;
            }
        }
	}
    
	$ciap_metabox = new CIAP_Advanced_Portfolio_Metabox_Settings();
}
