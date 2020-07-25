<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class('no-js'); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?>>

<div class="c-outer">

	<header class="c-pageheader">
		<div class="c-pageheader__inner">

			<?php if (!sht_theme()->Package->Customizer->embedLogo()) { ?>
				<p class="c-pageheader__title">
					<a class="c-pageheader__titlelink" href="<?php echo get_home_url();?>"><?php echo get_bloginfo('name');?></a>
				</p>
			<?php }?>

			<?php
			wp_nav_menu(
				[
					'theme_location' => 'primary',
					'container'      => 'nav',
					'container_class' => 'c-menu c-menu--primary',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'c-menu c-menu--primary',
				]
			);

			get_template_part('partials/navigation/searchdrawer');
			?>

			<button class="c-menutoggler" aria-controls="mobile-menu" aria-expanded="false">
				<span class="c-menutoggler__line"></span>
				<span class="c-menutoggler__line"></span>
				<span class="c-menutoggler__line"></span>
			</button>

		</div>

	</header>
