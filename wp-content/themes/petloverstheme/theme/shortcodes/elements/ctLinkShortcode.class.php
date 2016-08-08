<?php

/**
 * Price tag shortcode
 */
class ctLinkShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface{


    /**
     * Returns name
     * @return string|void
     */
    public function getName() {
        return 'Link';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName() {
        return 'link';
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
        extract( shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts ) );


        if ($email == 'yes' || $email == 'true'){
            $link = is_email($link);
            $mailto = 'mailto:';
        }else{
            $mailto = '';
        }

        $mainContainerAtts = array(
            'href'   => $mailto . $link,
            'target' => '_' . $target,
            'class'  => array( $class )
        );

        return '<a' . $this->buildContainerAttributes( $mainContainerAtts, $atts ) . ">" . do_shortcode( $content ) . '</a>';
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes() {
        return array(


            'link'    => array(
                'label'   => __( "Link", 'ct_theme' ),
                'default' => '',
                'type'    => 'input',
                'help'    => __( "Link URL", 'ct_theme' )
            ),
            'email'   => array(
                'label'   => __( 'Email link?', 'ct_theme' ),
                'default' => 'no',
                'type'    => 'select',
                'options' => array( 'yes' => 'yes', 'no' => 'no' ),
                'help'    => __( "Select yes for email link", 'ct_theme' )
            ),
            'target'  => array(
                'label'   => __( 'target', 'ct_theme' ),
                'default' => 'blank',
                'type'    => 'select',
                'options' => array(
                    'blank'  => __( 'blank', 'ct_theme' ),
                    'self'   => __( 'self', 'ct_theme' ),
                    'parent' => __( 'parent', 'ct_theme' ),
                    'top'    => 'top'
                ),
                'help'    => __( "The target parameter specifies where to open the linked document.<br>blank:	Opens the linked document in a new window or tab (this is default)<br>
self:	Opens the linked document in the same frame as it was clicked<br>
parent:	Opens the linked document in the parent frame<br>
top:	Opens the linked document in the full body of the window<br>
framename:	Opens the linked document in a named frame", 'ct_theme' )
            ),
            'content' => array( 'label' => __( 'Content', 'ct_theme' ), 'default' => '', 'type' => "textarea" ),
            'class'   => array(
                'label'   => __( "Custom class", 'ct_theme' ),
                'default' => '',
                'type'    => 'input',
                'help'    => __( "Custom class name", 'ct_theme' )
            ),
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo() {
        return new ctVisualComposerInfo( $this, array(
	        'icon' => 'fa-link',
	        'description' => __( "Add link or email address", 'ct_theme')
        ) );
    }


}

new ctLinkShortcode();