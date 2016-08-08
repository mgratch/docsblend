<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php $format = get_post_format();
        $format = $format ? $format : 'standard';
        $class = $format == 'standard' ? 'journal' : 'journal format-' . $format;
        $custom = get_post_custom($post->ID);


        $image_gallery = isset($custom["_easy_image_gallery"][0]) ? $custom["_easy_image_gallery"][0] : "";

        $attachments = array_filter(explode(',', $image_gallery));





        $team_position = isset($custom["team_position"][0]) ? $custom["team_position"][0] : "";
        $team_surname = isset($custom["team_surname"][0]) ? $custom["team_surname"][0] : "";
        $team_name = isset($custom["team_name"][0]) ? $custom["team_name"][0] : "";
        $description = isset($custom["description"][0]) ? $custom["description"][0] : "";
        $socials = new ctSocialsMetaFields();

       ?>
</div>
        <div class="ct-u-paddingTop70 ct-u-paddingBottom20 ct-u-motiveLight2--bg">
            <div class="container">
                <div class="row">
                    <div class="ct-teamMember-large">
                        <div class="col-sm-6 ct-u-paddingBottom50">
                            <div class="ct-teamMember">
                                <img src="<?php echo ct_get_feature_image_src(get_the_ID(), 'full'); ?>" alt="<?php echo $team_name .' '.$team_surname  ?>">
                                <div class="ct-teamMember--bg ct-u-paddingBoth20">
                                    <p class="text-uppercase text-center ct-fw-600"><?php echo $team_name .' '.$team_surname ?></p>
                                    <p class="ct-fw-400 text-center"><?php echo $team_position?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 ct-u-paddingBottom50">
                            <div class="ct-squareButton-container ct-u-paddingBottom30">
                              <?php echo ct_get_meta_socials() ?>
                            </div>

                            <p><?php echo $description?></p>
            <?php
        $code ='[ct_slider type="custom2" post_id="'.get_the_ID().'"]';
        echo do_shortcode($code);?>
                               </div>
            </div>

        </div>
    </div>

</div>
        <div class="container">
        <?php the_content() ?>


    <?php endwhile; ?>
<?php endif ?>