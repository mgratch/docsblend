<?php

/**
 * Class ctEasyImageGalleryPlugin
 * ver 1.1
 */
class ctEasyImageGalleryPlugin
{

    /**
     * gets the current post type in the WordPress Admin
     */
    public static function get_current_post_type()
    {
        global $post, $typenow, $current_screen;

        //we have a post so we can just get the post type from that
        if ($post && $post->post_type)
            return $post->post_type;

        //check the global $typenow - set in admin.php
        elseif ($typenow)
            return $typenow;

        //check the global $current_screen object - set in sceen.php
        elseif ($current_screen && $current_screen->post_type)
            return $current_screen->post_type;

        //lastly check the post_type querystring
        elseif (isset($_REQUEST['post_type']))
            return sanitize_key($_REQUEST['post_type']);


        elseif (isset ($_REQUEST['post']) && get_post_type($_REQUEST['post']))
            return get_post_type($_REQUEST['post']);

        //we do not know the post type!
        return null;
    }


    /**
     *
     */
    public function __construct()
    {
        //var_dump(self::get_current_post_type());

        $unsupportedTypes = array();
        $unsupportedTypes = apply_filters('ctEasyGalleryUnsupportedPostTypes', $unsupportedTypes);


        if (is_array($unsupportedTypes) && !empty($unsupportedTypes)) {
            if (in_array(self::get_current_post_type(), $unsupportedTypes)) {
                //var_dump($unsupportedTypes);
                return '';
            } else {
                add_action('add_meta_boxes', array($this, 'GalleryView360'));
                add_action('save_post', array($this, 'ct_view_image_gallery_save_post'));
            }
        } else {
            add_action('add_meta_boxes', array($this, 'GalleryView360'));
            add_action('save_post', array($this, 'ct_view_image_gallery_save_post'));
        }
    }


    /**
     *
     */
    public function GalleryView360()
    {
        add_meta_box('easy-image-gallery', 'Gallery', array(
            $this,
            'galleryBox'
        ), '', 'normal');
    }

    /**
     * Add metabox Gallery View 360
     */
    public function galleryBox()
    {
        global $post;
        ?>
        <style type="text/css">

            .gallery_images:after,
            #gallery_images_container:after {
                content: ".";
                display: block;
                height: 0;
                clear: both;
                visibility: hidden;
            }

            .gallery_images > li {
                float: left;
                cursor: move;
                margin: 0 20px 20px 0;
                position: relative;
            }

            .gallery_images li.image img {
                width: 160px;
                height: 160px;
            }

            .ct_gallery_view .delete {
                width: 16px;
                height: 16px;
                display: block;
                background: url("<?php echo esc_url(CT_THEME_ASSETS .'/images/cross-circle.png')?>") no-repeat center center;
                position: absolute;
                top: 0;
                right: 0;
            }

            .gallery_images.ui-sortable > li {
                cursor: move !important;
                border: 2px solid transparent;
            }

            .gallery_images.ui-sortable > li.wc-metabox-sortable-placeholder {
                border: 2px dashed #ccc;
            }


        </style>


        <p class="add_gallery_images hide-if-no-js ">
            <a class="button button-secondary" href="#"><?php esc_html_e('Add gallery images', 'ct_theme'); ?></a>
        </p>

        <div id="gallery_images_container" class="ct_gallery_view">

            <ul class="gallery_images">
                <?php

                $image_gallery = get_post_meta($post->ID, '_easy_image_gallery', true);
                $attachments = array_filter(explode(',', $image_gallery));

                if ($attachments)
                    foreach ($attachments as $attachment_id) {
                        $img = wp_get_attachment_image($attachment_id, 'medium');
                        if (!empty($img)) {
                            echo '<li class="image" data-attachment_id="' . esc_attr($attachment_id) . '">
                            ' . $img . '
                            <ul class="actions">
                                <li><a href="#" class="delete" title="' . esc_html__('Remove image', 'ct_theme') . '"></a></li>
                            </ul>
                       </li>';
                        }

                    }
                ?>
            </ul>


            <input type="hidden" id="image_gallery" name="image_gallery"
                   value="<?php echo esc_attr($image_gallery); ?>"/>
            <?php wp_nonce_field('easy_image_gallery', 'easy_image_gallery'); ?>

        </div>
        <?php

        /**
         * Props to WooCommerce for the following JS code
         */
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {

                // Uploading files
                var image_gallery_frame;
                var $image_gallery_ids = $('#image_gallery');
                var $gallery_images = $('#gallery_images_container ul.gallery_images');

                jQuery('.add_gallery_images').on('click', 'a', function (event) {

                    var $el = $(this);
                    var attachment_ids = $image_gallery_ids.val();

                    event.preventDefault();

                    // If the media frame already exists, reopen it.
                    if (image_gallery_frame) {
                        image_gallery_frame.open();
                        return;
                    }

                    // Create the media frame.
                    image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                        // Set the title of the modal.
                        title: '<?php esc_html__('Add Images to Gallery', 'ct_theme' ); ?>',
                        button: {
                            text: '<?php esc_html__('Add to gallery', 'ct_theme' ); ?>'

                        },
                        multiple: true
                    });

                    // When an image is selected, run a callback.
                    image_gallery_frame.on('select', function () {

                        var selection = image_gallery_frame.state().get('selection');

                        selection.map(function (attachment) {

                            attachment = attachment.toJSON();

                            if (attachment.id) {
                                attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

                                $gallery_images.append('\
                                <li class="image" data-attachment_id="' + attachment.id + '">\
                                    <img src="' + attachment.url + '" />\
                                    <ul class="actions">\
                                        <li><a href="#" class="delete" title="<?php esc_html__('Remove image', 'ct_theme' ); ?>"></a></li>\
                                    </ul>\
                                </li>');
                            }

                        });

                        $image_gallery_ids.val(attachment_ids);
                    });

                    // Finally, open the modal.
                    image_gallery_frame.open();
                });

                // Image ordering
                $gallery_images.sortable({
                    items: 'li.image',
                    cursor: 'move',
                    scrollSensitivity: 40,
                    forcePlaceholderSize: true,
                    forceHelperSize: false,
                    helper: 'clone',
                    opacity: 0.65,
                    placeholder: 'wc-metabox-sortable-placeholder',
                    start: function (event, ui) {
                        ui.item.css('background-color', '#f6f6f6');
                    },
                    stop: function (event, ui) {
                        ui.item.removeAttr('style');
                    },
                    update: function (event, ui) {
                        var attachment_ids = '';

                        $('#gallery_images_container ul li.image').css('cursor', 'default').each(function () {
                            var attachment_id = jQuery(this).attr('data-attachment_id');
                            attachment_ids = attachment_ids + attachment_id + ',';
                        });

                        $image_gallery_ids.val(attachment_ids);
                    }
                });

                // Remove images
                $('#gallery_images_container').on('click', 'a.delete', function () {

                    $(this).closest('li.image').remove();

                    var attachment_ids = '';

                    $('#gallery_images_container ul li.image').css('cursor', 'default').each(function () {
                        var attachment_id = jQuery(this).attr('data-attachment_id');
                        attachment_ids = attachment_ids + attachment_id + ',';
                    });

                    $image_gallery_ids.val(attachment_ids);

                    return false;
                });

            });
        </script>
    <?php
    }


    /**
     * Save function
     *
     * @since 1.0
     */
    function ct_view_image_gallery_save_post($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;


        // check user permissions

        if (!isset($_POST['easy_image_gallery']) || !wp_verify_nonce($_POST['easy_image_gallery'], 'easy_image_gallery'))
            return;

        if (isset($_POST['image_gallery']) && !empty($_POST['image_gallery'])) {

            $attachment_ids = sanitize_text_field($_POST['image_gallery']);

            // turn comma separated values into array
            $attachment_ids = explode(',', $attachment_ids);

            // clean the array
            $attachment_ids = array_filter($attachment_ids);

            // return back to comma separated list with no trailing comma. This is common when deleting the images
            $attachment_ids = implode(',', $attachment_ids);

            update_post_meta($post_id, '_easy_image_gallery', $attachment_ids);
        } else {
            delete_post_meta($post_id, '_easy_image_gallery');
        }

        // link to larger images
        if (isset($_POST['easy_image_gallery_link_images']))
            update_post_meta($post_id, '_easy_image_gallery_link_images', $_POST['easy_image_gallery_link_images']);
        else
            update_post_meta($post_id, '_easy_image_gallery_link_images', 'off');

        do_action('ct_easy_image_gallery_save_post', $post_id);
    }

}

new ctEasyImageGalleryPlugin();


/**
 * @param $PostID
 * @param string $size
 * @return array
 */
function ct_get_easy_gallery_Images($PostID, $size = 'ct_featured_image')
{
    $custom = get_post_custom($PostID);
    $image_gallery = isset($custom["_easy_image_gallery"][0]) ? $custom["_easy_image_gallery"][0] : "";

    $attachments = array_filter(explode(',', $image_gallery));
    $urlArr = array();

    foreach ($attachments as $attachment_id) {
        $get_image_id = wp_get_attachment_image_src($attachment_id, $size);
        if (!empty($get_image_id)) {

            if (is_array($get_image_id)){
                $img = $get_image_id[0];
            }else{
                continue;
            }
            $urlArr[] = $img;
        }
    }
    return $urlArr;
}

/**
 * @param $PostID
 * @return array
 */
function ct_get_easy_gallery_attachments($PostID)
{
    $custom = get_post_custom($PostID);
    $image_gallery = isset($custom["_easy_image_gallery"][0]) ? $custom["_easy_image_gallery"][0] : "";
    return  array_filter(explode(',', $image_gallery));
}


/**
 * @param $PostID
 * @return array|bool
 */
function ct_easy_galery_exist($PostID)
{
    if (is_array(get_post_meta($PostID, '_easy_image_gallery', true))) {
        return false;
    } else {
        $custom = get_post_custom($PostID);
        $image_gallery = isset($custom["_easy_image_gallery"][0]) ? $custom["_easy_image_gallery"][0] : "";

        if (!empty($image_gallery)) {
            $attachments = explode(',', $image_gallery);

            if (!empty($attachments)) {
                return $attachments;
            } else {
                return false;
            }
        }

    }
}