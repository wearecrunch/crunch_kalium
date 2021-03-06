<?php defined('ABSPATH') or die("No script kiddies please!");?>
<?php $wr_options = get_option('wr_wp'); ?>
<!--=============== content-holder ===============-->
<div class="content-holder elem scale-bg2 transition3">
    <!-- Page title -->
    <div class="dynamic-title"><?php the_title();?></div>
    <!-- Page title  end-->
    <?php get_template_part('template-parts/menu-part');?>
    <!--  Content -->
    <div class="content">
        <!--  fixed-info-container  -->
        <div class="fixed-info-container">
            <!--  content-nav -->
            <div class="content-nav">
                <ul>
                    <?php $previous_post = get_previous_post();
                    $url = is_object( $previous_post ) ? get_permalink( $previous_post->ID ) : '';
                    ?>
                    <?php  if ($previous_post) { ?>
                        <li><a href="<?php echo esc_url( $url );?>" class="ajax ln"><i class="fa fa fa-angle-left"></i></a></li>
                    <?php }?>
                    <?php if(!empty($wr_options['portfoliolink'])):?>
                        <li>
                            <div class="cases">
                                <a href="<?php echo esc_url($wr_options['portfoliolink']);?>" class="ajax">
                                            <h4>
                                            Cases
                                            </h4></a>
                            </div>
                        </li>
                    <?php else:?>
                        <li>
                            <div class="list">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ajax">
                                            <span>
                                            <i class="b1 c1"></i><i class="b1 c2"></i><i class="b1 c3"></i>
                                            <i class="b2 c1"></i><i class="b2 c2"></i><i class="b2 c3"></i>
                                            <i class="b3 c1"></i><i class="b3 c2"></i><i class="b3 c3"></i>
                                            </span></a>
                            </div>
                        </li>
                    <?php endif;?>
                    <?php $next_post = get_next_post();
                    $url = is_object( $next_post ) ? get_permalink( $next_post->ID ) : '';
                    ?>
                    <?php if ($next_post) {?>
                        <li><a href="<?php echo esc_url( $url );?>" class="ajax rn"><i class="fa fa fa-angle-right"></i></a></li>
                    <?php }?>
                </ul>
            </div>
            <!--  content-nav end-->
            <div class="case-title"><h3><?php the_title();?></h3></div>
            <div class="clearfix"></div>
            <?php if(have_posts()) : while ( have_posts() ) : the_post();?>
                <?php the_content();?>
            <?php endwhile;  endif; wp_reset_postdata(); ?>
            <?php if(get_post_meta($post->ID,'rnr_wr-infor-dis',true)=='st2'){ ?>
                <!---->
            <?php }
            else { ?>
                <h4 style="color:gray;"><?php esc_attr_e('Info','dogmawp');?></h4>
                <ul class="project-details">
                    <li><span><?php esc_attr_e('Date :','dogmawp');?></span> <?php the_time('d.m.Y') ?> </li>
                    <?php $wr_values =  rwmb_meta(
                        'rnr_pt_client',
                        $args = array(
                            'type'=>'text',
                        ),
                        $post_id = $post->ID
                    );
                    if($wr_values){
                        foreach ($wr_values as $key => $value) {
                            echo balanceTags($value) ;
                        }
                    };?>
                </ul>
            <?php } ?>
            <?php if (( get_post_meta($post->ID,'rnr_pt_button_url',true))):?>
                <a href="<?php echo esc_attr(get_post_meta($post->ID,'rnr_pt_button_url',true)); ?>" class=" btn anim-button   trans-btn   transition  fl-l" target="_blank"><span><?php echo esc_attr(get_post_meta($post->ID,'rnr_pt_button_text',true)); ?></span><i class="fa fa-long-arrow-right"></i></a>
            <?php endif;?>
        </div>
        <!--  fixed-info-container  end-->
        <!--  resize-carousel-holder  -->
        <div class="resize-carousel-holder vis-info">
            <?php $images = rwmb_meta( 'rnr_portfolio-image','type=image&size=' );
            foreach ( $images as $image ){
                echo "<!-- gallery Item-->
                                
                            <div class='scroll-box'>
                                <div class='scroll-box-item'>
                                    <div class='zoomimage'><img src='{$image['url']}' class='intense' alt=''><i class='fa fa-expand'></i></div>
                                    <img  src='{$image['url']}' class='respimg'   alt=''> 
                                    
                                </div>
                            </div>
                            
                                <!-- gallery item end-->
							   ";
            };?>

            <?php $wr_values =  rwmb_meta(
                'rnr_pt_vimeo',
                $args = array(
                    'type'=>'text',
                ),
                $post_id = $post->ID
            );
            if($wr_values){
                foreach ($wr_values as $key => $value) {
                    echo "<!-- gallery Item-->
                                <div class='scroll-box'>
                                <div class='scroll-box-item'>
                                    <div class='resp-video'>
                                        <iframe src=".$value."></iframe> 
                                    </div>
                                </div>
                            </div>
                                <!-- gallery item end-->";
                }
            };?>


        </div>
        <!--  resize-carousel-holder  -->
    </div>
    <!--  Content  end -->
    <?php get_template_part('template-parts/social-share');?>
</div>
<!-- Content holder  end -->