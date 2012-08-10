<?
/*
Template Name: Archive
*/

get_header();

include ('disqus_vals.php');
$disqus = new Disqus($disqus_vars['user_api_key'], $disqus_vars['forum_api_key']);
?>

<!-- hello sendgrid -->

    <div class="archive-wrapper content container_16 clearfix">
        
        <!--div id="main" class="grid_12"-->
	
	<!-- START OF DYNAMIC POST SUMMARY CODE for archive.php-->
			<?php
				$cat_name = single_cat_title('', false);
				if ($cat_name == "") {
					$cat_name = 'none';//'Recap,Featured';
				}
			
				function isSuper($cat){
					
					$featured = get_category(get_cat_ID('Featured'));
					$recap = get_category(get_cat_ID('Recap'));
					
					return has_category($featured,$post) && has_category($recap,$post);
					
				}
				
				function isSummary($cat){
					
					$featured = get_category(get_cat_ID('Featured'));
					$recap = get_category(get_cat_ID('Recap'));
					
					return has_category($featured,$post) || has_category($recap,$post);
					
				}
				
				$args = array();

				if ($cat_name != 'none') {
					if ($cat_name == 'Signup') {
						echo "<!--Signup query-->";
						$sticky = get_option('sticky_posts');
						$args = array(
							'posts_per_page' => 20,
							'post__in'	 => $sticky,
							'cat'		 => get_category_id($cat_name),
							'orderby'	 => 'post_date',
							'order'		 => 'DESC',
							'paged'		 => get_query_var('paged'),
							'ignore_sticky_posts' => 1);
						//$wp_query = new WP_Query('posts_per_page=20&cat='.get_category_id($cat_name).'&post__in='.$sticky.'&&orderby=post_date&order=DESC&paged='.get_query_var('paged'));
						$wp_query = new WP_Query( $args );
					} else {
						$wp_query = new WP_Query('posts_per_page=20&cat='.get_category_id($cat_name).'&orderby=post_date&order=DESC&paged='.get_query_var('paged'));
					}
					$args = array(
					    'numberposts' => -1,
					    'category' => get_category_id($cat_name),	// defined in functions.php
					    'order_by' => 'post_date',
					    'order' => 'DESC' );
				}
				else {
					$wp_query = new WP_Query('posts_per_page=20&orderby=post_date&order=DESC&paged='.get_query_var('paged'));
					$args = array(
					    'numberposts' => -1,
					    'order_by' => 'post_date',
					    'order' => 'DESC' );
				}

//				$post_array = get_posts($args);
				
				if (have_posts()) {

					$sticky_count = 0;
//					foreach($post_array as $post):
					while ($wp_query->have_posts()) : $wp_query->the_post();
						if ($cat_name == 'Signup' and !is_sticky()) {
							continue;
						}
 						else if ($cat_name == 'Signup') {
							$sticky_count++;
						}
						$grid = 'grid_4';
						$categories = get_the_category($post->ID);
		
						if(isSuper($categories)){
							$grid = 'grid_8';
						}else if(isSummary($categories)){
							$grid = 'grid_4';
						}
					
						$my_url = get_permalink();
						$thread = $disqus->get_thread_by_url($my_url);
						$num_comments = 0;
						if ($thread != "") {
							$num_posts_obj = $disqus->get_num_posts(array($thread->id));
							foreach ($num_posts_obj as $num_posts) {
								$num_comments = $num_posts[1];
							}
						}
					?>
		
			<div class="<?php echo $grid  ?> post boxshadow">
	        	        <div class="thumbnail">
        	        	    <div class="tags">
	
					
						<?php foreach($categories as $category): 
							if($category->cat_name!='Featured'){ ?>
							<span class="tag textshadow"><?php echo $category->name ?></span>	
						<?php } endforeach ?>
				   </div>
                                   <div class="bigdate">
                                       <h3 class="textshadow"><?php echo get_the_date('M') ?><br /><?php echo get_the_date('d') ?></h3>
                                   </div>
				   <? $values = get_post_custom_values('thumbnail');
                                      $thumbnail_top = get_post_custom_values('thumbnail_top');
                                      if ($values[0] != '') {
                                   ?>
				   <img src="<?php echo $values[0] ?>" <? if ($thumbnail_top[0] != '') { echo " style='top:-".$thumbnail_top[0]."px'"; }?> />
                                   <? } ?>
		                </div>
		                <div class="inner">
		                    <h3><a href="<?php the_permalink(); ?>"><?php echo $post->post_title?></a></h3>
                		    <h5><?php echo 'By ' . get_usermeta($post->post_author,'first_name') . ' '. get_usermeta($post->post_author,'last_name') ?> <?php if ($num_comments > 0) { ?> | <?php echo $num_comments ?> comment<? if ($num_comments != 1) echo 's';?><?php } ?></h5>
		                    <p><?php echo strip_shortcodes(strip_tags($post->post_content)) ?></p>
		                    <div class="gonext">&raquo;</div>
                		</div>
		       </div>
		
					<?php endwhile;//endforeach ?>
				<? 
				} else { // if no posts 
					if ($cat_name != 'Recap,Featured') {
						printf("<h3 class='center'>Sorry, but there aren't any posts in the %s category yet.</h3>", single_cat_title('',false));
					} else {
						echo("<h2 class='center'>No posts found.</h2>");
					}
					echo '<a href="' . get_option('home') . '">&larr; Go back to the homepage</a>';
				} // end if have_posts() ?>
				<? if ($cat_name == 'Signup' && $sticky_count == 0) {
					printf("<h3 class='center'>Sorry, there are no current signups. Please check again later</h3>");
				}?>
		
		<!-- END OF DYNAMIC POST SUMMARY CODE -->
           

        <? if(function_exists('wp_paginate')) { ?>
            <div class="grid_16">
    	        <? wp_paginate(); ?>
    	    </div>
        <? } ?>
        
    </div> <!-- /container -->
    <br />


<?php get_footer(); ?>
