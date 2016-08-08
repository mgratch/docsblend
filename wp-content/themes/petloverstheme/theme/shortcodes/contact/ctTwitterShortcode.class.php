<?php
require_once CT_THEME_LIB_DIR . '/shortcodes/socials/ctTwitterShortcodeBase.class.php';

/**
 * Twitter shortcode
 */
class ctTwitterShortcode extends ctTwitterShortcodeBase implements ctVisualComposerShortcodeInterface {

    public function enqueueScripts() {

        wp_register_script( 'ct-flex-slider', CT_THEME_ASSETS . '/plugins/flexslider/jquery.flexslider-min.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'ct-flex-slider' );

        wp_register_script( 'ct-flex-easing', CT_THEME_ASSETS . '/js/jquery.easing.1.3.js', array( 'ct-flex-slider' ), false, true );
        wp_enqueue_script( 'ct-flex-easing' );

        wp_register_script( 'ct-flexslider_init', CT_THEME_ASSETS . '/js/flexslider_init.js', array( 'ct-flex-slider' ), false, true );
        wp_enqueue_script( 'ct-flexslider_init' );
    }


    /**
     * Handles shortcode
     *
     * @param $atts
     * @param null $content
     *
     * @return string
     */

    public function handle( $atts, $content = null ) {
        $attributes = shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts );
        extract( $attributes );

        $id                = 'twitter-' . rand( 100, 1000 );
        $mainContainerAtts = array(
            'class' => array(),
            'id'    => $id
        );


        $newwindow  = $newwindow == 'false' || $newwindow == 'no' ? false : true;
        $html       = '';
        $followLink = $this->getFollowLink( $user );
        $tweets     = $this->getTweets( $attributes );

        $counter = 1;
        $class   = ' tweet';
        foreach ( $tweets as $tweet ) {
            $html .= $counter == 1 ? '<ul class="tweet_list slides">' : '';
            $class .= $counter == 1 ? ' tweet_first' : '';
            $class .= $counter == 2 ? ' tweet_even' : ' tweet_odd';
            $html .= '
                <li class="' . $class . ' tweet_odd">
                <p>
                ' . ( $tweet->user ? '<a class="tweet_user" href="' . $followLink . '">' . $tweet->user . '</a>' : '' ) . '
                <span class="tweet_text">' . $tweet->content . '</span>
                <span class="tweet_time"><a href="' . $followLink . '">' . $this->ago( $tweet->updated ) . '</a>
                </span></p></li>';

            //$html .= $counter == 3 ? '</ul>' : '';
            $counter ++;
            //$counter = ($counter < 50) ? $counter : 1;

        }
        if ( $counter != 1 ) {
            $html .= '</ul>';
        }

        if ( $simple_style == 'true' || $simple_style == 'yes' ) {
            $twitter = '
        <div ' . $this->buildContainerAttributes( array_merge( $mainContainerAtts ), $atts ) . '>
            <div class="twitter-logo">
            <i class="fa fa-twitter"></i>
        </div>
            <div' . $this->buildAttributes( array(
                    'data-controlnav'   => 'false',
                    'data-directionnav' => 'false',
                    'data-touch'        => 'true',
                    'data-prevtext'     => 'false',
                    'data-nexttext'     => 'false',
                    'class'             => array( 'twitter', 'type1', 'flexslider' )
                ) ) . '>
            ' . $html . '
            </div>
        </div>

        ';
        } else {
            $twitter = '
        <div ' . $this->buildContainerAttributes( $mainContainerAtts, $atts ) . '>
        <div class="text-center">
            <div class="ct-twitter twitter type2 flexslider">
            ' . $html . '

        </div>
        </div></div>

        ';
        }

        return do_shortcode( $twitter );
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes() {
        $args = array_merge(
            array(
                'widgetmode'   => array( 'default' => 'false', 'type' => false ),
                'simple_style' => array(
                    'label'   => __( 'Simple style ?', 'ct_theme' ),
                    'default' => 'no',
                    'type'    => 'select',
                    'choices' => array( 'no' => 'no', 'yes' => 'yes' ),
                    'help'    => __( "Inline or block style", 'ct_theme' )
                ),
            ), parent::getAttributes() );

        return $args;
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo() {
        return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-twitter-square' ) );
    }
}

new ctTwitterShortcode();