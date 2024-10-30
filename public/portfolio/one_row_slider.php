<?php

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
			<section class="portfolio-section iq-portfolio  port-col">
			    <div class="portfolio-container">
			        <div class="iq_row portfolio-carousel">
			        	
			            <?php 
			               $columns=(in_array($options['columns'], array(1,2,3,4,5,6))) ? $options['columns'] : 4;
			            if(isset($options['nospace']) && $options['nospace']=='yes') 
			                	$padding='';
			                else
			                	$padding='p-15';
			            while($loop->have_posts()): $loop->the_post(); 			               
			                //$styles='';
			                $meta=get_post_meta(get_the_ID(),'advanced_portfolios',true);
			                	$url=get_the_post_thumbnail_url('','full');
			                ?>
			            <div class="slide" >
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
			</section>
		</div>
			<script type="text/javascript">
		  jQuery(document).ready(function($){
		  	
		  	jQuery('.portfolio-carousel').slick({
		  		autoplay: true,
		  		autoplaySpeed: 3000,
		  		slidesToShow: '<?php echo isset($columns) ? $columns : 4; ?>',
		  		slidesToScroll: 1,
			  	arrows: true,
			  	infinite: true,
			  	responsive: [
			  		{
			      breakpoint: 1025,
			      settings: {
			        slidesToShow: 3,
			        slidesToScroll: 3,
			        infinite: true,
			        dots: true
			      }
			    },
			    {
			      breakpoint: 767,
			      settings: {
			        slidesToShow: 2,
			        slidesToScroll: 2
			      }
			    },
			    {
			      breakpoint: 480,
			      settings: {
			        slidesToShow: 1,
			        slidesToScroll: 1
			      }
			    }
			  	]
		  	}); 
		  });
		  </script>
			<?php
	      	wp_reset_postdata();
	      	else:
	      		echo __('No portfolios found for the categories','advanced-portfolio');
	      	endif;
	      	?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
