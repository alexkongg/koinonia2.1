<?php get_header(); ?>

    <div class="content container_16 clearfix">
        <!-- post -->
		<div id="main" role="main" class="grid_12 clearfix">
        
	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" class="grid_12 alpha boxshadow main post clearfix">
			    
			    <div class="post_header grid_8 prefix_2 alpha">
			     
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

				    <?php 
                    $tags = '';
				    foreach((get_the_category()) as $category) {
				        $tags .= $category->name . ', ';
				    } 
				    $tags = substr($tags, 0, -2); // remove the last ', '
				    ?>
 
    				<h5>By <?php the_author_meta('first_name') ?> <?php the_author_meta('last_name') ?> on <?php the_time('M j, Y') ?> | Filed under <? echo $tags; ?> 

<?
require('disqus_vals.php');
$disqus = new Disqus($disqus_vars['user_api_key'], $disqus_vars['forum_api_key']);
$my_url = get_permalink();
//echo "my_url is $my_url<br>";
$thread = $disqus->get_thread_by_url($my_url);
//echo "<br>thread is ". $thread->id."<br>";
$num_comments = 0;
if ($thread != "" ) {
	$num_posts_obj = $disqus->get_num_posts(array($thread->id));
	foreach ($num_posts_obj as $num_posts) {
	  $num_comments = $num_posts[1];
	}
}
?>
					<? if ($num_comments > 0) {
						echo " | <a href='#disqus_thread'>".$num_comments . " comment"; 
						if ($num_comments != 1) { echo "s"; }
						echo "</a>";
					   }
					?>
    				    </h5>

                        <!-- post header comments -->
    					
    			</div> <!-- end .post_header -->

				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

				<?php // get flickr photo gallery, if it exists
				   
				 	$galleries = get_post_custom_values('gallery');
					if(!is_null($galleries)){
						foreach($galleries as $gallery):
							$split = split(':',$gallery);
							$button_text = 'View Pictures';
							$flickr_set_id = $split[0];
						
							if(count($split) == 2){
								$button_text = $split[1];
							}
					
					
				?>
		     
		     	<div class="prefix_2 grid_10 alpha button-wrapper"> 
		     	    <span class="button" id="set-<?php echo $flickr_set_id ?>"><span><?php echo $button_text ?></span></span>
		     	</div>
		
				<?php endforeach ?>
				<?php } ?>
			
			</div><!-- /#post -->
			
			<div id="galleria-wrapper"class="grid_12 alpha boxshadow post clearfix">
			    <div class="post_header grid_12 alpha">
                    <h2>&nbsp;</h2>
                    <h5><a href="#" class="goback">« back to <?php the_title(); ?> post</a></h5>
                </div>

    			<div id="galleria" class="grid_12 alpha">
                    &nbsp;
			    </div>
			    
			    <div class="post_footer grid_12 alpha">
                    <h5><a href="#" class="goback">« back to <?php the_title(); ?> post</a></h5>			     
			    </div>
			</div><!-- /#galleria-wrapper -->

            <div class="grid_12 alpha boxshadow post clearfix">
                
                <div class="grid_8 prefix_2 alpha">
    			    <?php comments_template(); ?>                
    			</div> <!-- end .grid_8 pre_2 alpha -->
    			
            </div><!-- /comments -->

			<?php endwhile; else: ?>

				<p>Sorry, no posts matched your criteria.</p>

			<?php endif; ?>
			
	</div> <!-- end #main -->

    <?php get_sidebar(); ?>

  </div> <!-- end .container -->

<?php get_footer(); ?>
