<?php

/**
 * Socials shortcode
 */
class ctSocialsShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Socials';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'socials';
    }

    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */
    public function handle($atts, $content = null)
    {
        $attributes = (shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

        extract ($attributes);

        if (!isset($atts['rss']) || $atts['rss'] == 'no' || $atts['rss'] == 'false') {
            $attributes['rss'] = null;
        } else {
            $rssUrl = get_bloginfo('rss2_url');
        }


        //sort by order of the parameters and create new array
        $soc = $this->getSocials($attributes);
        $socialsSorted = array();
        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, $soc)) {
                $socialsSorted[$key] = $soc[$key];
            }
        }


        $tooltip_placement = ($tooltip_placement && $tooltip_placement != 'none') ? ' data-toggle="tooltip" data-placement="' . $tooltip_placement . '" ' : '';

        //generate style string

        //$align = ($align != '') ? 'pull-' . $align : '';
        $header = '' . $header . '';


        $mainContainerAtts = array(
            'class' => array(
                 $class
            ),
        );


        if ($align == 'right') {
            $html = '<div class="pull-right"><div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>';
        } elseif ($align == 'left') {
            $html = '<div class="pull-left"><div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>';
        } else {
            $html = '';
        }


        $html .= $header;


        $html .= '';


        $OpHelpersettings = $use_global == 'no' ? array('priority' => array('shortcode')) : array();


        if($type=='1'){

        foreach ($socialsSorted as $key => $value) {
            if ($attributes) {
                if (array_key_exists($key, $attributes)) {
                    if (ct_get_context_option($key, '', $attributes, $OpHelpersettings)) {
                        if ($key == 'rss') {
                            $attributes[$key] = '';
                        }
                        //custom icon?
                        $param = $key . '_custom_icon';
                        if (array_key_exists($param, $attributes)) {
                            if ($attributes[$param] != '') {
                                $icon = 'fa fa-fw ' . $attributes[$param];
                            } else {
                                $icon = $value['class'];
                            }
                        } else {
                            $icon = $value['class'];
                        }
                        //$userName = $atts[$key];
                        $userName = ct_get_context_option($key, '', $attributes, $OpHelpersettings);
                        $baselink = $value['link'];
                        $socialName = $key;

                        if ($socialName == 'email' || $socialName == 'tumblr') {
                            $userName = '';
                        }

                        $html .= '<a class="btn ct-squareButton btn-default" href="' . esc_url($baselink .   $userName) . '" target="_blank" title="' . $socialName . '"><i class="' .
                            $icon . '"></i></a>';
                    }
                }
            }
        }
        $html .= '';
        if ($align != '') {
            $html .= '';
        }

        }elseif($type=='2'){
            foreach ($socialsSorted as $key => $value) {
                if ($attributes) {
                    if (array_key_exists($key, $attributes)) {
                        if (ct_get_context_option($key, '', $attributes, $OpHelpersettings)) {
                            if ($key == 'rss') {
                                $attributes[$key] = '';
                            }
                            //custom icon?
                            $param = $key . '_custom_icon';
                            if (array_key_exists($param, $attributes)) {
                                if ($attributes[$param] != '') {
                                    $icon = 'fa fa-fw ' . $attributes[$param];
                                } else {
                                    $icon = $value['class'];
                                }
                            } else {
                                $icon = $value['class'];
                            }
                            //$userName = $atts[$key];
                            $userName = ct_get_context_option($key, '', $attributes, $OpHelpersettings);
                            $baselink = $value['link'];
                            $socialName = $key;

                            if ($socialName == 'email' || $socialName == 'tumblr') {
                                $userName = '';
                            }

                            $html .= '<li><a data-toggle="tooltip" data-placement="bottom" href="' . esc_url($baselink .   $userName) . '" target="_blank" title="' . $socialName . '"><i class="' .
                                $icon . '"></i></a></li>';
                        }
                    }
                }
            }
            $html .= '';
            if ($align != '') {
                $html .= '';
            }

        }elseif($type=='3'){
            foreach ($socialsSorted as $key => $value) {
                if ($attributes) {
                    if (array_key_exists($key, $attributes)) {
                        if (ct_get_context_option($key, '', $attributes, $OpHelpersettings)) {
                            if ($key == 'rss') {
                                $attributes[$key] = '';
                            }
                            //custom icon?
                            $param = $key . '_custom_icon';
                            if (array_key_exists($param, $attributes)) {
                                if ($attributes[$param] != '') {
                                    $icon = 'fa fa-fw ' . $attributes[$param];
                                } else {
                                    $icon = $value['class'];
                                }
                            } else {
                                $icon = $value['class'];
                            }
                            //$userName = $atts[$key];
                            $userName = ct_get_context_option($key, '', $attributes, $OpHelpersettings);
                            $baselink = $value['link'];
                            $socialName = $key;

                            if ($socialName == 'email' || $socialName == 'tumblr') {
                                $userName = '';
                            }

                            $html .= '<a class="btn btn-rounded btn-motiveDark" href="' . esc_url($baselink .   $userName) . '" target="_blank" title="' . $socialName . '"><span><i class="fa '.$icon.'"></i></span></a></li>';
                        }
                    }
                }
            }
            $html .= '';
            if ($align != '') {
                $html .= '';
            }



        }

        return do_shortcode($html);







    }

    /**
     * @return array
     */
    private function getSocials($atts = array())
    {
        if (!isset($atts['rss']) || $atts['rss'] == 'no' || $atts['rss'] == 'false') {
            $atts['rss'] = null;
        } else {
            $rssUrl = get_bloginfo('rss2_url');
        }

        $skype = isset($atts['skype']) ? $atts['skype'] : '';
        $tumblr = isset($atts['tumblr']) ? $atts['tumblr'] : '';
        $email = isset($atts['email']) ? $atts['email'] : '';


        $socials = array(
            'bitbucket' => array(
                'link' => 'http://bitbucket.org/',
                'class' => 'fa fa-bitbucket'
            ),
            'dribbble' => array(
                'link' => 'http://dribbble.com/',
                'class' => 'fa fa-dribbble'
            ),
            'dropbox' => array(
                'link' => 'https://www.dropbox.com/',
                'class' => 'fa fa-dropbox'
            ),
            'facebook' => array(
                'link' => 'http://www.facebook.com/',
                'class' => 'fa fa-facebook'
            ),
            'flickr' => array(
                'link' => 'http://www.flickr.com/photos/',
                'class' => 'fa fa-flickr'
            ),
            'foursquare' => array(
                'link' => 'http://foursquare.com/user/',
                'class' => 'fa fa-foursquare'
            ),
            'github' => array(
                'link' => 'http://github.com/',
                'class' => 'fa fa-github'
            ),
            'gittip' => array(
                'link' => 'http://www.gittip.com/',
                'class' => 'fa fa-gittip'
            ),
            'google' => array(
                'link' => 'http://plus.google.com/',
                'class' => 'fa fa-google-plus'
            ),
            'instagram' => array(
                'link' => 'http://instagram.com/',
                'class' => 'fa fa-instagram'
            ),
            'linkedin' => array(
                'link' => 'http://www.linkedin.com/',
                'class' => 'fa fa-linkedin'
            ),
            'pinterest' => array(
                'link' => 'http://www.pinterest.com/',
                'class' => 'fa fa-pinterest'
            ),
            'renren' => array(
                'link' => 'http://www.renren.com/profile.do?id=',
                'class' => 'fa fa-renren'
            ),
            'rss' => array(
                'link' => '$rssUrl',
                'class' => 'fa fa-rss'
            ),
            'skype' => array(
                'link' => 'skype:' . $skype . '?call',
                'class' => 'fa fa-skype'
            ),
            'stack_exchange' => array(
                'link' => 'http://gamedev.stackexchange.com/users/',
                'class' => 'fa fa-stack-exchange'
            ),
            'stack_overflow' => array(
                'link' => 'http://stackoverflow.com/users/',
                'class' => 'fa fa-stack-overflow'
            ),
            'tumblr' => array(
                'link' => 'http://' . $tumblr . '.tumblr.com',
                'class' => 'fa fa-tumblr'
            ),
            'twitter' => array(
                'link' => 'http://www.twitter.com/',
                'class' => 'fa fa-twitter'

            ),
            'vimeo' => array(
                'link' => 'http://vimeo.com/',
                'class' => 'fa fa-vimeo-square'

            ),
            'vkontakte' => array(
                'link' => 'http://vk.com/',
                'class' => 'fa fa-vk'

            ),
            'weibo' => array(
                'link' => 'http://weibo.com/',
                'class' => 'fa fa-weibo'

            ),
            'xing' => array(
                'link' => 'http://www.xing.com/profile/',
                'class' => 'fa fa-xing'

            ),
            'youtube' => array(
                'link' => 'http://www.youtube.com/',
                'class' => 'fa fa-youtube-play'

            ),
            'email' => array(
                'link' => 'mailto:' . $email,
                'class' => 'fa fa-envelope-o'
            )
        );

        return $socials;
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        //add custom icon params
        $additionalParams = array();
        foreach ($this->getSocials() as $key => $value) {
            $additionalParams[$key . '_custom_icon'] = array('label' => ucfirst($key . ' ' . __('custom Font Awesome icon name', 'ct_theme')), 'default' => '', 'type' => 'input');
        }
        $atts1 = array(
            'use_global' => array('label' => __('Use global settings', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array(
                'no' => __('no', 'ct_theme'), 'yes' => __('yes', 'ct_theme'))
            ),


            'type' => array('label' => __('type', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array(
                '1' => __('1', 'ct_theme'),
                '2' => __('2', 'ct_theme'),
                '3' => __('3', 'ct_theme'))
            ),

            'header' => array('label' => __("Socials header", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'align' => array('label' => __('Align', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array('right' => __('Right', 'ct_theme'), 'left' => __('Left', 'ct_theme'), '' => '')),
            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'widgetmode' => array('default' => 'false', 'type' => false),
            'tooltip_placement' => array('label' => __('Tooltip placement', 'ct_theme'), 'default' => 'top', 'type' => 'select', 'options' => array('top' => __('top', 'ct_theme'), 'right' => __('right', 'ct_theme'), 'bottom' => __('bottom', 'ct_theme')), 'left' => __('left', 'ct_theme'), 'none' => __('none', 'ct_theme'), 'help' => __("Select tooltip position", 'ct_theme')),
            'bitbucket' => array('label' => __("Bitbucket", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'dribbble' => array('label' => __("Dribbble username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'dropbox' => array('label' => __("Dropbox username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'facebook' => array('label' => __("Facebook username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'flickr' => array('label' => __("Flickr username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'foursquare' => array('label' => __("Foursquare user ID", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'github' => array('label' => __("Github username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'gittip' => array('label' => __("Gittip username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'google' => array('label' => __("Google+ username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'instagram' => array('label' => __("Instagram username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'linkedin' => array('label' => __("LinkedIn username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'pinterest' => array('label' => __("Pinterest username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'Renren' => array('label' => __("Renren ID", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'rss' => array('label' => __('Rss', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('no' => __('no', 'ct_theme'), 'yes' => __('yes', 'ct_theme')), 'help' => __("Show rss feed link?", 'ct_theme')),
            'skype' => array('label' => __("Skype user", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'stack_exchange' => array('label' => __("Stack Exchange user ID", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'stack_overflow' => array('label' => __("Stack Overflow", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'tumblr' => array('label' => __("Tumblr user", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'twitter' => array('label' => __("Twitter username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'vimeo' => array('label' => __("Vimeo url - with http://", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'vkontakte' => array('label' => __("VKontakte", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'Weibo' => array('label' => __("Weibo username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'xing' => array('label' => __("xing username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'youtube' => array('label' => __("Youtube movie", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'email' => array('label' => __("E-mail", 'ct_theme'), 'default' => '', 'type' => 'input'),

        );

        $atts1 = array_merge($atts1, $additionalParams);
        return $atts1;
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-users',
            'description' => __( "Add social buttons", 'ct_theme')
        ));
    }
}

new ctSocialsShortcode();