<?php
$code = '[ct_slider type="custom" directionnav="false" autoplay="true" limit="100" post_id="' . get_the_ID() . '"]';

echo do_shortcode($code);
