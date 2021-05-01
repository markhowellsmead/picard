<?php

/**
 * @package Hello Roots
 * @subpackage Theme_Compat
 * @author mark@sayhello.ch 7.8.2020
 *
 * This file has been copied over from wp-includes/theme-compat/comments.php.
 * The version in Core was deprecated in WordPress 3.0.0.
 */

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' === basename($_SERVER['SCRIPT_FILENAME'])) {
	die('Please do not load this page directly. Thanks!');
}

if (post_password_required()) { ?>
	<p class="nocomments"><?php _e('This entry is password-protected. Please provide the password in order to read the comments.'); ?></p>
<?php
	return;
}

switch (get_post_type()) {
	default:
		$some_comments_text = _x('There are %s comments for this entry.', 'Comment form text', 'sht');
		$comments_closed_text = _x('Comments are not allowed on this entry.', 'Comment form text', 'sht');
		break;
}
?>

<div class="c-commentwrapper">

	<div class="c-commentwrapper__comments">
		<?php if (have_comments()) { ?>
			<h3 id="comments"><?php _ex('Comments', 'Comment list title', 'sht'); ?></h3>
			<p>
				<?php
				if ((int) get_comments_number() > 1) {
					printf($some_comments_text, get_comments_number());
				}
				?>
			</p>

			<?php if (!empty(previous_comments_link()) || !empty(next_comments_link())) {
			?>
				<div class="navigation">
					<?php if (!empty(previous_comments_link())) { ?>
						<div class="alignleft"><?php previous_comments_link(); ?></div>
					<?php }
					if (!empty(next_comments_link())) { ?>
						<div class="alignright"><?php next_comments_link(); ?></div>
					<?php } ?>
				</div>
			<?php } ?>

			<ol class="commentlist">
				<?php
				wp_list_comments([
					'avatar_size' => 62,
				]);
				?>
			</ol>

			<?php
			$previous_comments_link = previous_comments_link();
			$next_comments_link = next_comments_link();

			if ($next_comments_link . $previous_comments_link !== '') {
			?>

				<div class="navigation">
					<div class="alignleft"><?php previous_comments_link(); ?></div>
					<div class="alignright"><?php next_comments_link(); ?></div>
				</div>

			<?php }
		} else {
			// This is displayed if there are no comments so far.
			?>
			<?php if (!comments_open()) { ?>
				<h3 id="comments"><?php _ex('Comments', 'Comment list title', 'sht'); ?></h3>
				<p class="nocomments"><?php echo $comments_closed_text; ?></p>
			<?php } ?>
		<?php } ?>
	</div>
	<div class="c-commentwrapper__commentform">
		<?php
		$current_user = wp_get_current_user();

		ob_start();
		comment_form([
			'title_reply' => _x('Leave a comment', 'Comment form title', 'picard'),
			'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
			'title_reply_after' => '</h4>',
			'logged_in_as' => sprintf(
				'<p class="logged-in-as">%s</p>',
				sprintf(
					/* translators: 1: Edit user link, 2: Accessibility text, 3: User name, 4: Logout URL. */
					__('You are logged in as %s.'),
					'<span class="c-comments__currentusername">' . $current_user->display_name . '</span>'
				)
			),
		]);
		$comment_form = apply_filters('sht_comment_form', ob_get_clean());
		echo $comment_form;

		?>

	</div>
</div>
