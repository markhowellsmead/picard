<?php

// $search_group_options = get_field('search_group', 'options');

?><div class="c-searchform">
	<form role="search" aria-label="searchform-regular" method="get" class="search-form" action="<?php echo esc_url(home_url('/'));?>">
		<label class="c-searchform__label">
			<span class="screen-reader-text"><?php _ex('Suche nach:', 'Search field label', 'sht');?></span>
			<input required type="search" class="c-searchform__searchfield" placeholder="<?php _ex('Enter a search term', 'Default placeholder text', 'sht');?>" value="<?php echo get_search_query();?>" name="s"></label>
			<input type="submit" class="search-submit" value="<?php _ex('Search', 'Search field button text', 'sht');?>">

			<?php if (!empty($search_group_options['quicksearch_post_type'] ?? null)) {?>
				<input type="hidden" name="post_type" value="<?php echo $search_group_options['quicksearch_post_type'];?>">
			<?php }?>
	</form>
</div>
