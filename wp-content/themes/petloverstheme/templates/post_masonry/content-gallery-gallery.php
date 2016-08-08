<?php
$code = '[ct_slider type="custom" height="200" directionnav="false" arrow_type="ct-flexslider--arrowType2" limit="100" post_id="' . get_the_ID() . '"]';

echo do_shortcode($code);
