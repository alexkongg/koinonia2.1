<?php 
/*
Template Name: About Us
*/
get_header(); 
?>

<div class="about-wrapper">
	<div class="content container_16 clearfix">
		<div id="main" class="grid_12 clearfix" role="main">
			<div id="" class="grid_12 alpha boxshadow post clearfix">
				<div class="post_header grid_12 alpha">
				    <h2><a href="#"><?php the_title(); ?></a></h2>
				</div>
	
				<div class="grid_12 alpha">
					<?php 
					$main_img = getcustom('main_img'); 
					    if ($main_img) { ?>
					        <img id="hero" src="<?php echo $main_img; ?>"/>
					<?php } ?>
				</div>

				<div class="grid_6 alpha">
                	<p><?php outputcustom('main'); ?></p>
				</div>

				<div class="grid_6 omega">
                	<p><?php outputcustom('main2'); ?></p>
				</div>
				
				<div class="grid_12 alpha">
				    <h2>What you might expect</h2>
				</div>
				
				<div class="grid_4 alpha">
				    <h4>Bible Study</h4>
				    <?php 
					$biblestudy_img = getcustom('biblestudy_img'); 
					    if ($biblestudy_img) { ?>
					        <img src="<?php echo $biblestudy_img; ?>"/>
					<?php }  ?>
				    <p><?php outputcustom('biblestudy'); ?></p>
				</div>
				
				<div class="grid_4">
				    <h4>Life Groups</h4>
			        <?php 
					$lifegroups_img = getcustom('lifegroups_img'); 
					    if ($lifegroups_img) { ?>
					        <img src="<?php echo $lifegroups_img; ?>"/>
					<?php } ?>
				    <p><?php outputcustom('lifegroups');?></p>
				</div>
				
				<div class="grid_4 omega">
				    <h4>Community</h4>
				    <?php 
					$community_img = getcustom('community_img'); 
					    if ($community_img) { ?>
					        <img src="<?php echo $community_img; ?>"/>
					<?php } ?>
				    <p><?php outputcustom('community'); ?></p>
				</div>
				
                <!-- video: width and height set on default -->
                <div class="video grid_12 alpha">
                    <div class="video-inner">
                        <iframe src="http://player.vimeo.com/video/29846322?title=0&amp;byline=0&amp;portrait=0&amp;color=FDD91C" width="809" height="455" frameborder="0"></iframe>            
                    </div>
                </div>

				<div class="grid_12 alpha">
				    <h2>Looking for a church?</h2>
				    <div class="grid_9 alpha">
    				    <?php 
    					$church_img = getcustom('church_img'); 
    					    if ($church_img) { ?>
    					        <img src="<?php echo $church_img; ?>"/>
    					<?php } ?>
				    </div>
				    <div class="grid_3 omega">
    				    <p><?php outputcustom('church'); ?></p>				        
				    </div>
				</div>
				
			</div>
		</div> <!-- /main -->
		
		<div id="sidebar" class="grid_4">
			<div id="contact-us" class="grid_4 alpha slickpanel widget">
				<h3>Contact Us</h3>

					<?php
					$submitted = $_GET['send_email'];
					if (!isset($submitted)) {
                        // form has NOT been submitted yet
					?>
					<p class="padding"><?php outputcustom('contact'); ?></p>

					<div id="form" class="padding">						
						<form method="get" id="msgform">
						  <p><label for="your-name">Name</label>
						      <br /><input type="text" name="your-name" value="" id="your-name" class="required"></p>
						  <p><label for="your-email">Email <small>(for us to contact you)</small></label>
						      <br /><input type="text" name="your-email" value="" id="your-email" class="required email"></p>
						  <p><label for="your-phone">Phone <small>(optional)</small></label>
						      <br /><input type="text" name="your-phone" value="" id="your-phone"></p>
						  <p><label for="your-message">Comments or questions?</label>
						      <br /><textarea name="your-message" id="your-message" rows="15" class="required"></textarea></p>

						  <p><input type="submit" name="send_email" value="Contact Us" class="button"></p>
						</form>
						
            		</div>
            		
            		<?php
				    }
				    else {
				        // form has been submitted
			            $from = $_GET['your-name'] . '<' . $_GET['your-email'] . '>';
                        $to = 'abeyang@gmail.com';
                        $subject = 'message from a2f Riverside website';
                        $msg = $_GET['your-message'] . "\r\n\r\n" . 'Phone: ' . $_GET['your-phone'];

                    	date_default_timezone_set('America/Los_Angeles');   // Abe: is this necessary?
                    	$headers = "From: $from\r\n";
                    	$headers .= "To: $to\r\n";
                    	$headers .= "Content-Type: text/html";
                    	if ( mail('',$subject,$msg,$headers) ) {
                    		echo '<p class="padding">The message has been sent!</p>';
                    	} else {
                    		echo '<p class="padding">The message has failed!</p>';
                    	}
				    }
					?>
				</div>
			</div>
		</div>
	</div> <!-- /content -->
	
</div>

<?php get_footer(); ?>