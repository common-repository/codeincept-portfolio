<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Booking_With_Woocommerce
 * @subpackage Booking_With_Woocommerce/admin/partials
 */

if(!class_exists('CI_Advanced_Portfolio_Settings'))
{
	class CI_Advanced_Portfolio_Settings 
	{
        private $posttype;
		function __construct()
		{
            $this->posttype='advanced-portfolio';
            $this->options=get_option('ap_singlepage_settings',true);
            if(isset($this->options['slug']) && !empty($this->options['slug'])){
                $this->posttype=$this->options['slug'];
            }
			$this->init_settings();
		}
       
		public function init_settings(){
			?>
			<nav class="nav-tab-wrapper ">
        <?php $tabs = array(
                'single_page' =>  __('Single Page','advanced_portfolio'),
                'support' =>  __('Support','advanced_portfolio'),
        );
        $tabs=apply_filters('advanced_portfolio',$tabs);
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : key($tabs);
        ?>
        <?php
        foreach( $tabs as $tab => $name ){
            $class = ( $tab == $active_tab ) ? ' nav-tab-active' : '';
            ?>
            <a class='nav-tab <?php echo $class; ?>' href="edit.php?post_type=<?php echo $this->posttype; ?>&page=portfolio-settings&tab=<?php echo $tab; ?>">
                <?php echo $name; ?>
            </a>
            <?php } ?>
        </nav>
        <?php
        	switch ($active_tab) {
        		case 'single_page':
        				$this->single_page();
        			break;
                case 'support':
                        $this->support_page();
                    break;   
        		default:
        				$this->single_page();
        		break;
        	}
		}
		public function single_page(){

            if(isset($_POST['app-singlepage-settings'])){

                $singlepage=$_POST['singlepage'];

                $singlepage['single_page']=isset($singlepage['single_page']) ? 'yes' : 'no';

                update_option('ap_singlepage_settings',$singlepage);

            }

            else{

                $singlepage=get_option('ap_singlepage_settings',true);

            }

			?>

            <div class="adv-p-settings postbox-container">

                <div class="bww postbox">

            <form action="" method="post">

            <table class="form-table">

                <tr valign="top" class="">

                <td colspan="2">

                    <h3><?php _e('Single Page Settings', 'advanced_portfolio'); ?></h3><hr/>

                </td>

            </tr>

            <tr valign="top" class="">

                <th scope="row" class="titledesc"><?php _e('Enable portfolio item single page?','advanced_portfolio'); ?></th>

                <td class="forminp forminp-checkbox">

            <label for="bww-use">

            <input name="singlepage[single_page]" id="bww-use" type="checkbox" class="" value="1" <?php if(isset($singlepage['single_page']) && $singlepage['single_page']=='yes'){ echo 'checked'; } ?>>

                <?php _e('Check this setting to use single page for portfolio items'); ?></label>

                </td>

            </tr>

            <tr valign="top" class="">

                <th scope="row" class="titledesc"><?php _e('Custom slug for portfolio?','advanced_portfolio'); ?></th>

                <td class="forminp forminp-checkbox">

            <label for="ap-slug">

            <input name="singlepage[slug]" id="ap-slug" type="text" class="" value="<?php if(isset($singlepage['slug']) && !empty($singlepage['slug'])){ echo $singlepage['slug']; } ?>" placeholder="advance-portfolio">

                <?php _e('Want to use custom slug? default is "advance-portfolio"'); ?></label>

                </td>

            </tr>

          

                </tbody>

            </table>

            <p class="submit">

                <input name="app-singlepage-settings" class="button-primary" type="submit" value="<?php _e('Save changes','advance-portfolio'); ?>">

            </p>

            </form>

            </div>

        </div>

            <?php

		}

		

        public function support_page(){

            ?>  

              <div class="adv-p-settings postbox-container">

                <div class="bww postbox">

            
            </div>

        </div>



            <?php

        }

	}



}



