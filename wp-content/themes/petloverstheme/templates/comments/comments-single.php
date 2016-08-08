<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2015-01-19
 * Time: 12:52
 */

function theme_comments($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;?>

    <div class="oneComment" id="comment-<?php comment_ID(); ?>">

            <li class="ct-u-borderBottomGrayLighter ct-u-marginTop10">

                        <?php echo get_avatar($comment, $size = '55', $default = 'mystery'); //no escape required
                        ?>
                 <div>

                     <p class="ct-u-paddingBottom5"><span><?php _e(get_comment_author_link(), 'ct_theme') ?></span> - <?php echo get_comment_date() ?></p>
                     <p><?php comment_text() ?></p>


                 </div>


            </li>

    </div>

<?php
}