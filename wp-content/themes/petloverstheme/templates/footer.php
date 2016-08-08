<?php $class = apply_filters('footer_class', 1); ?>

<footer class="<?php echo sanitize_html_class($class) ?>">
    <?php if (is_active_sidebar('post-footer1') ):?>
    <div class="ct-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php dynamic_sidebar('post-footer1'); ?>
                </div>

            </div>
        </div>
    </div>
    <?php endif;?>

    <?php do_action('ct_before_footer_container') ?>
    <section class="ct-footer ct-footer-list">
        <div class="container">
            <div class="row">
                <?php ct_footer_columns('ct-u-paddingBoth30') ?>
            </div>
        </div>
    </section>
    <?php do_action('ct_after_footer_container') ?>

    <?php if( is_active_sidebar('post-footer2')) :?>
    <div class="ct-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php dynamic_sidebar('post-footer2'); ?>
                </div>

            </div>
        </div>
    </div>
    <?php endif;?>




</footer>