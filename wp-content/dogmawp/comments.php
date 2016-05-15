<?php
	define('DOING_AJAX',1);
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php esc_attr_e('This post is password protected. Enter the password to view comments.','dogmawp'); ?></p>
	<?php
		return;
	}
?>

<style>
	.validation{
		display: block;
		visibility: hidden;
		color: red;
		font-size: 17px;
	}
</style>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
<div class="comments-holder">
	
     <h3><?php	printf( _n( 'One Comment to', 'Coments ','dogmawp', get_comments_number() ),
									number_format_i18n( get_comments_number() ), '&#8220;' . get_the_title() . '&#8221;' ); ?><strong><?php	printf( _n( '%2$s', '%1$s','dogmawp', get_comments_number() ),
									number_format_i18n( get_comments_number() ), '&#8220;' . get_the_title() . '&#8221;' ); ?></strong></h3>
    

	

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	
	
	<ul class="commentlist clearafix">
	<?php wp_list_comments('callback=dogma_comment');?>
	</ul>
	
</div>

	
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php esc_attr_e('Comments are closed.','dogmawp'); ?></p>

	<?php endif; ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
 <!--  comment-form-holder -->
<div class="comment-form-holder">
        <h3><?php comment_form_title( esc_attr__('Add Comment','dogmawp'), esc_attr__('Add Comment to %s','dogmawp' ) ); ?></h3>

<div id="comment-form">



	<small><?php cancel_comment_reply_link() ?></small>


<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<h4 class="cm_sub_title"><?php printf(esc_attr__('You must be <a href="%s">logged in</a> to post a comment.','dogmawp'), wp_login_url( get_permalink() )); ?></h4>
<?php else : ?>

<form action="<?php echo esc_url(site_url()); ?>/wp-comments-post.php" method="post" id="commentform" class="contact-form">

<span id="error" class="validation"></span>

<?php if ( is_user_logged_in() ) : ?>

<h4 class="cm_sub_title"><?php esc_attr_e('Logged in as ','dogmawp'); ?> <?php printf(__('<a href="%1$s">%2$s</a>.','dogmawp'), get_edit_user_link(), $user_identity); ?> <a href="<?php echo esc_url(wp_logout_url(get_permalink())); ?>" title="<?php esc_attr_e('Log out of this account','dogmawp'); ?>"><?php esc_attr_e('Log out &raquo;','dogmawp'); ?></a></h4>

<?php else : ?>


<input class="form-control"  onClick="this.select()" value="<?php esc_attr_e('Name','dogmawp'); ?>"  type="text" name="author" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
<span id="author" class="validation">Author is required</span>


<input class="form-control"  onClick="this.select()" value="<?php esc_attr_e('Website','dogmawp'); ?>" type="text" name="url" size="22" tabindex="3" />
<span id="url" class="validation">Url is required</span>


<input class="form-control"  onClick="this.select()" value="<?php esc_attr_e('Email','dogmawp'); ?>" type="text" name="email" size="22" tabindex="2"/>
<span id="email" class="validation">Website is required</span>



<?php endif; ?>




<textarea class="form-control" rows="3" name="comment" cols="100" tabindex="4" onClick="this.select()" <?php if ($req) echo "aria-required='true'"; ?>><?php esc_attr_e('Message','dogmawp'); ?></textarea>
<span id="comment" class="validation">Comment is required</span>


<button name="submit" type="submit" id="submit" tabindex="5" value="" ><span><?php esc_attr_e('Post','dogmawp'); ?> </span> <i class="fa fa-long-arrow-right"></i></button>


<?php comment_id_fields(); ?>

<?php do_action('comment_form', $post->ID); ?>


</form>
</div>
</div>

<script type="text/javascript">
	// Assign handlers immediately after making the request,
	// and remember the jqxhr object for this request
	var response;
	var fields = ["author", "email", "url", "comment"];
	var defValues = ["Name", "Email", "Website", "Message"];
	jQuery(function($) {
	$('document').ready(function(){
		// process the form
		$('form').submit(function(event) {
			// stop the form from submitting the normal way and refreshing the page
			event.preventDefault();
			invalid = false
			for(var field in fields){
				if($('[name='+fields[field]+']') && ($('[name='+fields[field]+']').val() == defValues[field] || $('[name='+fields[field]+']').val() == "")){
					$("#"+fields[field]).css({"visibility":"visible"});
					invalid = true;
				}else{
					$("#"+fields[field]).css({"visibility":"hidden"});
				}
			}
			if(invalid)
				return;
			// get the form data
			// there are many ways to get this data using jQuery (you can use the class or id also)
			var formData = $('form').serialize() 

			// process the form
			$.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : "<?php echo esc_url(site_url()); ?>/wp-comments-post.php", // the url where we want to POST
				data        : formData, // our data object
				dataType    : 'json', // what type of data do we expect back from the server
				encode      : true,
				statusCode: {
					200: function() {
						$( "#error" ).empty();
						$( "#error" ).css({"color":"green"});
						$( "#error" ).text("Comment succesfully posted");
						setTimeout(function() {
							$("#error").css({"visibility":"hidden"});
							$("#error").css({"color":"red"});
						}, 10000);
						
					}
				}
			}).fail(function(html) {
				response = html;
				$( "#error" ).empty();
				$( "#error" ).append(jQuery(response.responseText.match('(<p[^>]*>.*?</p>)')[0]).html());
				$("#error").css({"visibility":"visible"});
			  })
		});
	});
});
</script>
<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
