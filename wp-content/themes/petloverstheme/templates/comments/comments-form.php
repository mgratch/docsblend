<?php if (((get_post_type() == 'post' && ct_get_context_option("posts_single_show_comment_form", 1))
        || get_post_type() == 'page' && ct_get_context_option("pages_single_show_comment_form", 0)
        || get_post_type() == 'portfolio' && ct_get_context_option("portfolio_single_show_comment_form", 0)
    )
    && comments_open()
) : ?>

    <form role="form" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post"
          class="ct-u-paddingBottom20">
        <h4 class="ct-fw-600 ct-u-marginBottom10"><?php _e('Leave a comment.', 'ct_theme') ?></h4>

        <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    <label class="text-uppercase" for="comment_name"><?php _e('Name *', 'ct_theme') ?></label>
                    <input id="comment_name" required type="text" name="author" class="form-control input-lg"
                           placeholder="<?php _e('Name', 'ct_theme') ?>">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    <label class="text-uppercase" for="comment_email"><?php _e('Email *', 'ct_theme') ?></label>
                    <input id="comment_email" required type="email" name="email" class="form-control input-lg"
                           placeholder="<?php _e('Email', 'ct_theme') ?>">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="text-uppercase" for="comment_message"><?php _e('Message *', 'ct_theme') ?></label>
                    <textarea id="comment_message" class="form-control input-lg" rows="12" name="comment" required
                              placeholder="<?php _e('<Message', 'ct_theme') ?>"></textarea>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-10">
                <button type="submit" class="btn btn-motive ct-u-marginTop30">
                   <span><?php _e('Submit Comment', 'ct_theme') ?></span> <i class="fa fa-comments"></i>
                </button>










            </div>
        </div>
        <?php comment_id_fields(); ?>
        <?php do_action('comment_form', get_the_ID()); ?>
        <?php if (false): ?><?php comment_form() ?><?php endif; ?>
    </form>
<?php endif; ?>