<?php

namespace SayHello\Theme\Package;

/**
 * oEmbed stuff
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Oembed
{

	private $same_site = false;

	public function __construct()
	{
		if (isset($_SERVER['HTTP_REFERER'])) {
			$url_parts = parse_url($_SERVER['HTTP_REFERER']);
			if ($url_parts['host'] === $_SERVER['SERVER_NAME'] || (bool) preg_match('~permanenttourist\.[ch|hello|local]~', $url_parts['host'])) {
				$this->same_site = true;
			}
		}
	}
	public function run()
	{
		if ($this->same_site) {
			add_action('embed_head', [$this, 'embedStyles']);

			add_filter('embed_thumbnail_image_size', function () {
				if (get_post_type() == 'photo') {
					return 'large';
				}
				return 'thumbnail';
			}, 10, 0);

			add_filter('embed_thumbnail_image_shape', function () {
				if (get_post_type() == 'photo') {
					return 'rectangular';
				}
				return 'square';
			}, 10, 0);

			add_filter('embed_content', function () {
				if ($this->same_site) {
					switch (get_post_type()) {
						case 'photo':
							$extra = '';
							if (has_post_thumbnail()) {
								$thumbnail_meta = wp_get_attachment_metadata(get_post_thumbnail_id());
								if (is_array($thumbnail_meta['image_meta']) && isset($thumbnail_meta['image_meta']['created_timestamp']) && $thumbnail_meta['image_meta']['created_timestamp'] > 0) {
									$extra.=sprintf(
										'<time class="c-article__date c-article__date--captured" datetime="%1$s">%2$s</time>',
										date_i18n('c', $thumbnail_meta['image_meta']['created_timestamp']),
										sprintf(_x('Photographed on %s', 'date', 'picard'), date_i18n('jS F Y', $thumbnail_meta['image_meta']['created_timestamp']))
									);
								}
							}

							$extra .= sprintf(
								'<time class="c-article__date" datetime="%s">%s</time>',
								get_the_date('c'),
								sprintf(__('Published on %s', 'sht'), get_the_date())
							);

							$extra .= sprintf(
								'<p class="c-oembed__more"><a class="c-oembed__morelink" target="_top" href="%s">%s</a></p>',
								get_the_permalink(),
								__('View full-sized photo', 'picard')
							);
							break;
						default:
							$extra = sprintf(
								'<time class="c-article__date" datetime="%s">%s</time>',
								get_the_date('c'),
								sprintf(__('Published on %s', 'sht'), get_the_date())
							);

							$extra .= sprintf(
								'<p><a href="%s">%s</a></p>',
								get_the_permalink(),
								__('Read more', 'picard')
							);
							break;
					}
					echo $extra;
				}
			});

			remove_action('embed_content_meta', 'print_embed_comments_button');
			remove_action('embed_content_meta', 'print_embed_sharing_button');
			add_action('embed_content_meta', function () {
				return;
			});
		}
	}

	public function embedStyles()
	{
		sht_theme()->Package->Assets->loadFonts();
		wp_enqueue_style(sht_theme()->prefix . '-oembed-style', get_template_directory_uri() . '/assets/styles/oembed.min.css', [], sht_theme()->version);
	}
}
