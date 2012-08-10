<div id="sidebar" class="grid_4">

    <?php 
        $expire = 43200;        // 12 hours
        // if(wp_cacheblock_start('gcal', array('expires'=>$expire))) : 
    ?>
    <div id="upcoming" class="grid_4 alpha slickpanel widget">
        <h3>Upcoming Events</h3>
        <?php
        require('php/gcal/magazine.class.php');
            $cal = 'riverside';
            $mag = new Magazine($cal, array(
                'debug' => 0,
                    'shows' => 'normal',
                    'numdays' => 6
                    // 'startdate' => '2011-10-11'
               ));

            echo $mag->display();
        ?>
    </div>

    
    <div id="facebook" class="grid_4 alpha widget">
        <a href="http://www.facebook.com/a2friverside"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook-button.png" alt="Join us on Facebook!" /></a>
    </div>
    
<?
if (!is_home()) { // add titles and thumbnails of five most recent featured posts
?>
    <div id="recentfeatured" class="grid_4 alpha widget">
	<h3 class="featured">Featured Posts</h3>
<?
    $args = array ( 'numberposts'   => 5,
		    'category_name' => 'Featured,Recap',
		    'order_by'      => 'post_date',
                    'order'         => 'DESC' );
    $post_array     = get_posts($args);
    $start_position = 0;
    $end_position   = 0;

    foreach ($post_array as $post) {
		$thumbnail = get_post_custom_values('thumbnail');
		echo "<a class='thumb' href='".get_permalink()."'>"; 
        echo '<h5 class="textshadow">' . $post->post_title . '</h5>';
		if ($thumbnail[0] != '') {
			echo "<img src='".$thumbnail[0]."' />"; 
		}
		echo "</a>";
    }
?>
    </div>
<?
}  // end if (is_home())
?>
    <div id="recentcomments" class="grid_4 alpha widget">
        <h3 class="comments">Recent Comments</h3>
        <?include('disqus_vals.php');
            $disqus = new Disqus($disqus_vars['user_api_key']);
            $forums = $disqus->get_forum_posts($disqus_vars['forum_id'],array(limit => '100', exclude => 'spam,killed'));
            $MAX_COMMENT_COUNT = 15;
            $comment_counter   = 0;
  
            // Loop through the returned values.
            foreach ($forums as $forum) {
		$comment_counter++;
                if ($comment_counter > $MAX_COMMENT_COUNT) {
                    break;
                }
		$avatar = "'http://mediacdn.disqus.com/1314726113/images/noavatar48.png'";
		if ($forum->author->has_avatar) {
			$avatar = "'". $forum->author->avatar->medium."' width=48 height=48";
		}

		$username = '';
		if ($forum->author->display_name != "") {
			$username = $forum->author->display_name;
		}
		else if ($forum->is_anonymous) {
			if ($forum->anonymous_author->name != "") {
				$username = $forum->anonymous_author->name;
			}
			else {
				$username = "Anonymous";
			}
		}
		else {
			$username = $forum->author->username;
		}

		$my_date = substr($forum->created_at, 5, 5);
		if (substr($my_date, 0, 1) == "0") {
			$my_date = substr($my_date, 1);
		}
		$my_date = str_replace('-', '/', $my_date);

		$output .= "<a href='".$forum->thread->url."' class='clearfix'>";
		$output .= "<img src=$avatar alt='avatar' />";
		$output .= "<span class='info'>";
		$output .= "<strong class='username'>$username</strong> <span class='date'>($my_date)</span>";
		$output .= "<span class='comment'>" . strip_tags($forum->message) . "</span>";
		$output .= "</span>";
		$output .= "</a>";
            }

            // Output the list
            echo $output;
        ?>
    </div>
</div>
