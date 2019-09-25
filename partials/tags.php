<?php

if (!empty(get_the_terms(get_the_ID(), 'post_tag'))) {
	the_terms(get_the_ID(), 'post_tag', '<ul class="c-taxonomyentries c-taxonomyentries--post_tag"><li class="c-taxonomyentry c-taxonomyentry--post_tag">', '</li><li class="c-taxonomyentry c-taxonomyentry--post_tag">', '</li></ul>');
}
