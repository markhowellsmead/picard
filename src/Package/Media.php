<?php

namespace SayHello\Theme\Package;

/**
 * Everything to do with images, videos etc
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Media
{

	const META_KEY = 'video_ref';
	private $wide_aspectratio = 2;
	private $xwide_aspectratio = 2.25;

	public function run()
	{
		add_filter('jpeg_quality', [$this, 'jpegQuality']);
		add_action('after_setup_theme', [ $this, 'addImageSizes' ]);
		add_filter('image_size_names_choose', [$this, 'selectableImageSizes']);
		add_filter('body_class', [ $this, 'thumbnailAspectCSS' ]);
		add_filter('post_class', [$this, 'postClasses']);
		add_action('wpseo_add_opengraph_images', [$this, 'videoThumbnail']);
		add_filter('wpseo_opengraph_desc', [$this, 'maybeChangeDescription']);
	}

	public function addImageSizes()
	{
		add_image_size('list_view', 540*2, 9999);
		add_image_size('list_view_tall', 9999, 540);
		add_image_size('gutenberg_wide', 1280, 9999);
		add_image_size('gutenberg_full', 2560, 9999);
	}

	public function jpegQuality()
	{
		return 92;
	}

	public function selectableImageSizes($sizes)
	{
		$sizes['gutenberg_wide'] = __('Gutenberg wide', 'sht');
		$sizes['gutenberg_full'] = __('Gutenberg full', 'sht');
		return $sizes;
	}

	public function thumbnailAspectCSS($css_classes)
	{
		if (!has_post_thumbnail()) {
			return $css_classes;
		}

		$image_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'post-thumbnail');

		if (is_array($image_src)) {
			$aspect = $image_src[1] / $image_src[2];
			if ($aspect >= $this->xwide_aspectratio) {
				$css_classes[] = 'o-body--xwidethumbnail';
			} elseif ($aspect >= $this->wide_aspectratio) {
				$css_classes[] = 'o-body--squarethumbnail';
			} elseif ($aspect == 1) {
				$css_classes[] = 'o-body--squarethumbnail';
			} elseif ($aspect < 1) {
				$css_classes[] = 'o-body--tallthumbnail';
			}
		}
		return $css_classes;
	}

	public function thumbnailAspect()
	{
		$image_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'post-thumbnail');
		if (is_array($image_src)) {
			$aspect = $image_src[1] / $image_src[2];
			if ($aspect >= $this->xwide_aspectratio) {
				return 'xwide';
			} elseif ($aspect >= $this->wide_aspectratio) {
				return 'wide';
			} elseif ($aspect == 1) {
				return 'square';
			} elseif ($aspect < 1) {
				return 'tall';
			}
			return 'landscape';
		}
		return null;
	}

	public function thumbnailSize($image_size)
	{
		$size = [];
		if (is_array($image_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $image_size))) {
			$size = [
				'width' => $image_src[1],
				'height' => $image_src[2]
			];
		}
		return $size;
	}

	public function postClasses($classes)
	{
		if (has_post_thumbnail()) {
			$classes[] = 'c-article__thumbnailaspect--'.$this->thumbnailAspect();
		} else {
			$classes[] = 'c-article--nothumbnail';
		}
		if (!empty(get_field('video_ref'))) {
			$classes[] = 'has-video-thumbnail';
		}
		return $classes;
	}

	/**
	 * Get remote video thumbnail URL
	 *
	 * @param string $source_url The video URL
	 * @return string The Video Thumbnail URL
	 **/
	public static function getVideoThumbnail($source_url)
	{
		if ($source_url == '' || is_array($source_url)) {
			return '';
		}

		$atts = [
			'url' => $source_url
		];

		if (!is_string($atts['url'])) {
			return '';
		}

		$aPath = parse_url($atts['url']);
		$aPath['host'] = str_replace('www.', '', $aPath['host']);

		switch ($aPath['host']) {
			case 'youtu.be':
				$atts['id'] = preg_replace('~^/~', '', $aPath['path']);
				return 'https://i.ytimg.com/vi/'.$atts['id'].'/hqdefault.jpg';
			break;

			case 'youtube.com':
				$aParams = explode('&', $aPath['query']);
				foreach ($aParams as $param) :
					$thisPair = explode('=', $param);
					if (strtolower($thisPair[0]) == 'v') :
						$atts['id'] = $thisPair[1];
						break;
					endif;
				endforeach;
				if (!isset($atts['id']) || !$atts['id']) {
					return '';
				} else {
					return 'https://i.ytimg.com/vi/'.$atts['id'].'/hqdefault.jpg';
				}
				break;

			case 'vimeo.com':
				$urlParts = explode('/', $atts['url']);
				$hash = @unserialize(@file_get_contents('https://vimeo.com/api/v2/video/'.$urlParts[3].'.php'));
				if ($hash && $hash[0] && (isset($hash[0]['thumbnail_large']) && $hash[0]['thumbnail_large'] !== '')) {
					return $hash[0]['thumbnail_large'];
				} else {
					return '';
				}
				break;

			default:
				return '';
			break;
		}
	}

	public function maybeChangeDescription($description)
	{
		if (!empty($excerpt = wp_strip_all_tags(get_the_excerpt(), true))) {
			return $excerpt;
		}
		return $description;
	}

	public function videoThumbnail($object)
	{
		if (!has_post_thumbnail() && !empty($video_url = get_post_meta(get_the_ID(), self::META_KEY, true))) {
			$video_thumbnail = $this->getVideoThumbnail($video_url);
			$object->add_image($video_thumbnail);
		}
	}
}
