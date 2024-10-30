<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Advanced_Portfolio
 * @subpackage Advanced_Portfolio/public/partials
 */

	$options=apply_filters('codeincept_portfolio_options',$options);
	$categories = apply_filters('codeincept_portfolio_categories',wp_get_object_terms($id, 'portfolio_category', array()));
	$term_ids=array();

    foreach ($categories as $key => $value) {
    	$term_ids[]=$value->term_id;
    }
	$args = array(
      'post_type' => 'advanced-portfolio',
      'post_status'=> 'publish',
      'posts_per_page'=> $options['items'],
      'tax_query' => array(
	        'relation' => 'OR',  	
		        array(
			        'taxonomy' => 'portfolio_category',
			        'field'    => 'term_id',
			        'terms'    => $term_ids,
		        )
          	),
    );
    $loop = new WP_Query( $args );   
    if ( $loop->have_posts()):   

?>
	<div class="advanced_portfolio">
	      	<section class="filter-section">
			    <div class="containernnn">
			        <div class="row">
			            <div class="col-sm-12 col-xs-12">			           
			                <div class="filter-container isotopeFilters portfoliofilters">
			                	<?php if(count($categories)):  ?>
			                    <ul class="list-inline filter">
			                    	<?php 
			                    	$others='';
			                    	if(isset($options['showall']) &&  $options['showall']=='yes'){  ?>
			                       <li class="active"><a href="#" data-filter="*">All </a></li>
			                    	<?php 
			                    	$others='all';
			                    		} 
			                    		$x=1;
			                         foreach ($categories as $key => $value):
			                         	if(isset($options['showall']) && $options['showall']!='yes' && $x==1){
			                        echo '<li><a href="#" data-filter=".'.$value->slug.'" class="active">'.$value->name.'</a></li>';
				                   	}else{
			                        echo '<li><a href="#" data-filter=".'.$value->slug.'">'.$value->name.'</a></li>';
				                   	}
				                   $x++;
				                    endforeach;  ?>
			                    </ul>
			                    <?php endif; ?>
			                </div>
			                
			            </div>
			        </div>
			    </div>
			</section>
			<section class="portfolio-section iq-portfolio  port-col">
			    <div class="container">
			        <div class="iq_row">
			            <div class="isotopeContainer">
			            <?php while($loop->have_posts()): $loop->the_post(); 

			                $terms = get_the_terms( get_the_ID(), 'portfolio_category' );

			                if ( $terms && ! is_wp_error( $terms ) ) : 
			                    $links = array();
			 
			                    foreach ( $terms as $term ) 
			                    {
			                        $links[] = $term->slug;
			                    }
			                    $tax = join( " ", $links );     
			                else :  
			                    $tax = '';  
			                endif;
			                //$styles='';
			                $columns=(in_array($options['columns'], array(1,2,3,4))) ? $options['columns'] : 4;
			                $meta=get_post_meta(get_the_ID(),'advanced_portfolios',true);
			                if(isset($options['nospace']) && $options['nospace']=='yes') 
			                	$padding='';
			                else
			                	$padding='p-15';

			                	$url=get_the_post_thumbnail_url('','full');
			                
			                ?>
			            <div class="col_<?php echo $columns; ?> isotopeSelector <?php echo strtolower($tax).' '.$others; ?> ">
			                
			                	<div class="<?php echo $options['style'].' '.$padding; ?>">
				                
			                	<?php 
			                	if(isset($meta['mediatype']) && $meta['mediatype']=='video'){
			                	include( dirname(__FILE__).'/single_item_video.php' );  
			                	}else{
			                	include( dirname(__FILE__).'/single_item.php' );  
				                }
			                	?>
			                
			                
			                </div>
			            </div>
			         <?php  endwhile; ?>
			            </div>
			        </div>
			    </div>
			</section>
		</div>
			<?php
	      	wp_reset_postdata();
	      	else:
	      		echo __('No portfolios found for the categories','advanced-portfolio');
	      	endif;
	      	?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
