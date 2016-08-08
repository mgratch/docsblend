<?php

/**
 * Draws team
 */
class ctTeamShortcode extends ctShortcodeQueryable implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Team';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'team';
    }


    /**
     * Handles shortcode
     *
     * @param $atts
     * @param null $content
     *
     * @return string
     */

    public function handle($atts, $content = null)
    {

        $attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
        extract($attributes);

        $team = $this->getCollection($attributes, array('post_type' => 'team'));

        $counter = 0;
        $counter2 = 0;

        $teamBoxHtml = '';

        foreach ($team as $p) {
            $custom = get_post_custom($p->ID);

            $customPostSocials = new ctSocialsMetaFields();
            $team_position = isset($custom["team_position"][0]) ? $custom["team_position"][0] : "";
            $team_surname = isset($custom["team_surname"][0]) ? $custom["team_surname"][0] : "";
            $team_name = isset($custom["team_name"][0]) ? $custom["team_name"][0] : "";
            $description = isset($custom["description"][0]) ? $custom["description"][0] : "";
            $small_description = isset($custom["small_description"][0]) ? $custom["small_description"][0] : "";



            if (has_post_thumbnail($p->ID)) {
                $image = ct_get_feature_image_src($p->ID, 'full');
            } else {
                $image = '';
            }


            $counter2++;
            if ($counter2 == 1) {
                $teamBoxHtml .= '<div class="row">';
            }


            if ($columns == 2) {
                $teamBoxHtml .= '<div class="col-md-6 col-sm-12">';
            } elseif ($columns == 3) {
                $teamBoxHtml .= '<div class="col-md-4 col-sm-6">';
            } else {
                $teamBoxHtml .= '<div class="col-md-3 col-sm-4">';
            }

            //$socialsHtml = $customPostSocials->getTheSocialsHtml(array('use_global'=>'no'), $p->ID);
            $socialsHtml = $customPostSocials->getTheSocialsHtml(array('use_global'=>'no'), $p->ID);

            //forward params
            $teamBoxHtml .= ('[person_box type ="1"  name="' . $team_name . ' ' . $team_surname . '" position="' . $team_position . '" desc="'.$small_description.'" link="' . get_permalink( $p->ID ) . '" image="' . $image . '" ][/person_box]');
            $teamBoxHtml .= '</div>';

            if ($counter2 == $columns || $counter == count($team)) {
                $counter2 = 0;
                $teamBoxHtml .= '</div>';
            }


        }

        return do_shortcode($teamBoxHtml);
    }


    /**
     * Returns params from array ($custom)
     *
     * @param $arr
     * @param $key
     * @param int $index
     * @param string $default
     *
     * @return bool
     */

    protected function getFromArray($arr, $key, $index = 0, $default = '')
    {
        return isset($arr[$key][$index]) ? $arr[$key][$index] : $default;
    }

    /**
     * Shortcode type
     * @return string
     */
    public function getShortcodeType()
    {
        return self::TYPE_SHORTCODE_SELF_CLOSING;
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        $atts = $this->getAttributesWithQuery(array(
            'limit' => array(
                'label' => __('limit', 'ct_theme'),
                'default' => 20,
                'type' => 'input',
                'type' => 'input',
                'help' => __("Number of elements", 'ct_theme')
            ),

            'columns' => array('label' => __('Columns', 'ct_theme'), 'default' => '3', 'type' => 'select',
                'choices' => array('2' => '2', '3' => '3', '4' => '4'), 'help' => __("Columns number", 'ct_theme')),


        ));

        if (isset($atts['cat'])) {
            unset($atts['cat']);
        }

        return $atts;
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-user',
	        'description' => __( "Add multiple team boxes", 'ct_theme')
	        ));
    }


}


new ctTeamShortcode();
