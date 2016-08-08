<?php

?>


<div class="row">
    <?php
    $terms = get_terms('faq_category', 'hide_empty=1');

    $counter = 0;
    $resetCounter2 = 0;
    $counter2 = 0;

    foreach ($terms as $term) {

    $custom_attributes['post_type'] = 'faq';
    $custom_attributes['tax_query'] = array(
        array(
            'taxonomy' => 'faq_category',
            'field' => 'id',
            'terms' => $term->term_id

        )
    );
    $faqCollection = get_posts($custom_attributes);
    ?>

    <div class="ct-u-paddingBoth70">


        <div class="panel-group" id="accordion-<?php echo esc_html($term->slug) ?>">
            <?php
            foreach ($faqCollection as $p) {
                $custom = get_post_custom($p->ID);
                ?>



                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a data-toggle="collapse" <?php echo ct_esc_attr('data-parent', '#accordion-' . $term->slug) ?>
                               href="#collapse<?php echo esc_attr((int)$counter2) ?>" <?php echo $counter2 > $resetCounter2 ? 'class="collapsed"' : 'class="collapse"'; ?>>
                                <div class="ct-Diamond ct-Diamond--motive"></div>
                                <?php echo esc_html(get_the_title($p->ID)) ?>
                            </a>
                        </div>
                    </div>
                    <div id="collapse<?php echo (int)$counter2 ?>"
                         class="panel-collapse collapse  <?php echo $counter2 > $resetCounter2 ? '' : 'in'; ?>">
                        <div class="panel-body">
                            <?php echo do_shortcode($p->post_content) ?>
                        </div>
                    </div>
                </div>
                <?php
                $counter2++;
            }
            ?>
        </div>
    </div>
    <?php
    if ($counter == 1) {
    ?></div>
<div class="row">
    <?php $counter = 0;
    } else {
        $counter++;
    }
    $resetCounter2 = $counter2;
    }
    ?>
</div>