
<div class="ap-inner">
  
<div class="article-image">
    <?php the_post_thumbnail('full'); ?>
</div>
  
<div class="article-caption">

    <div class="inner-overlay">
        <div class="portfolio-icons">
           <div class="socialFooter">
                <div class="portfolioSocial">
                	<?php if(isset($lightbox['enable']) && $lightbox['enable']=='yes'): ?>
                    <a title="<?php the_title(); ?>" class="html5lightbox" data-group='gallery' rel="<?php echo strtolower($tax); ?>" href="<?php echo $url;  ?>">
                    	<span class="portfolio-search fa fa-search"></span>
                    </a>
                    <?php endif; ?>
                   <?php if(isset($options['pagelink']) && $options['pagelink']!='yes'): ?>
                   <a href="<?php echo (isset($meta['linkurl']) && !empty($meta['linkurl'])) ? $meta['linkurl'] : get_the_permalink(); ?>" class="linkIcon">
                       <span class="portfolio-link fa fa-link"></span>
                   </a>
                  <?php endif; ?>
                   <?php if(isset($options['sharebtn']) && $options['sharebtn']!='yes'): ?>
                   <a href="javascript:void(0)" class="sharePortfolio">
                        <span class="fa fa-share-alt"></span>
                    </a>
                  <?php endif; ?>
                </div>
            </div>

        </div>
         <?php 
         if(isset($options['sharebtn']) && $options['sharebtn']!='yes'):
         echo $this->get_social_share_links();
          endif;
          ?>
      <?php if(isset($options['title']) && $options['title']!='yes'): ?>
    <div class="title">
    	<?php the_title(); ?>
    </div>
     <?php endif; ?>
    </div>
</div>

</div>