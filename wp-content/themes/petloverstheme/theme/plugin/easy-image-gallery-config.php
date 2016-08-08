<?php


/**
 * Easy Gallery Integration
 */
class ctEasyImageGalleryConfig
{
    /**
     * Initializes object
     */
    public function __construct()
    {

        add_filter('ctEasyGalleryUnsupportedPostTypes', array(
            $this,
            'ctEasyGalleryUnsupportedPostTypes'
        ));

    }


    public function ctEasyGalleryUnsupportedPostTypes()
    {
        return array(
            'view360',
        'product');
    }

}

new ctEasyImageGalleryConfig();
