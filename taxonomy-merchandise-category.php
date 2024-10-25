<?php
get_header();
get_template_part('components/content-blocks', null, ['object_id' => 'term_' . get_queried_object()->term_id]);
get_footer();
