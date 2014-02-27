<?php	
global $post;

if( $post->comment_status != 'closed' ):
	if( post_password_required() ): 
?>

<p class="hr hr-wide gap-big"></p>

<div id="comments">
        <p class="nopassword">
            <?php _e( 'This post is password protected. Enter the password to view any comments.', LANGUAGE_ZONE ); ?>
        </p>
</div>
    <?php
        /* Stop the rest of comments.php from being processed,
        * but don't kill the script entirely -- we still have
        * to fully load the template.
        */
        return;
    endif;
    ?>
    
	<?php if ( have_comments() ): ?>

        <p class="hr hr-wide gap-big"></p>
        
        <div id="comments">
            <h2><?php
                comments_number(
                    '',
                    _x('1 comment:', 'comments header', LANGUAGE_ZONE),
                    _x('% comments:', 'comments header', LANGUAGE_ZONE)
                );
                ?></h2>
            <div class="comments-container">
            <?php
            global $wp_query;

            wp_list_comments(
                array(
                    'max_depth'     => 5,
                    'style'         => 'div',
                    'callback'      => 'dt_single_comments',
                    'end-callback'  => 'dt_comments_end_callback',
                    'comments_nmbr' => count($wp_query->comments)
                )
            );
            ?>
            <?php paginate_comments_links(); ?>
            </div><!-- .commwnts-container -->
        </div><!-- #comments -->
	<?php endif; ?>
		<?php
		global $user_identity, $user_email, $user_login;
        $user = $email = '';
        
        get_currentuserinfo();
		if( is_user_logged_in() ) {
            $user = $user_identity;
            $email = $user_email;
        }
        
		?>
        <p class="hr hr-wide gap-big"></p>
        <div class="share_com" id="comment-form">
            <div id="form_prev_holder">
                <div id="form-holder">
                
                    <div class="header"><?php _e( 'Leave a comment:', LANGUAGE_ZONE ); ?></div>
               
                    <form action="<?php echo site_url('/wp-comments-post.php'); ?>" method="post" class="uniform get-in-touch">
                    <?php if( !is_user_logged_in() ): ?>
                        
                        <div class="i-h">
                            <input id="form_name" name="author" type="text" class="validate[required]" value="<?php echo esc_attr($user); ?>"/>
                            <div class="i-l"><span><?php _e('Name', LANGUAGE_ZONE); ?></span></div>
                        </div>

                        <div class="i-h">
                            <input id="form_email" name="email" type="text" class="validate[required,custom[email]" value="<?php esc_attr($email); ?>"/>
                            <div class="i-l"><span><?php _e('E-mail', LANGUAGE_ZONE); ?></span></div>
                        </div>

                    <?php endif; ?>
                    <div class="t-h">
                        <textarea name="comment" id="form_message" class="validate[required]"></textarea>
                    </div>
                    
                    <a href="#" class="button go_button" title="<?php _e( 'Add comment', LANGUAGE_ZONE ); ?>"><span><i class="submit"></i><?php _e( 'Submit comment', LANGUAGE_ZONE ); ?></span></a>
                    <a href="#" class="do-clear"><?php _e( 'Clear', LANGUAGE_ZONE ); ?></a>
                    
                    <?php comment_id_fields(); ?>
                    <?php do_action('comment_form', $post->ID); ?>
                </form> 
            </div><!-- form_holder -->
        </div><!-- form_prev_holder -->
    </div><!-- share-com -->
<?php endif; ?>
