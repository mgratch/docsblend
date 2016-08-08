<?php

/**
 * Class ctGetOptionHelper
 */

//define ('NEW_LINE',chr (13). chr (10));
define ('NEW_LINE','<br>');
class ctCodeDistiller
{


    /**
     *
     */
    public function generate()
    {
        $newAttr = $this->getArray()?$this->getArray():array();
        $output = '';
        foreach ($newAttr as $k => $v) {

            $v['desc'] = isset($v['desc'])?$v['desc']:'';
            $v['std'] = isset($v['std'])?$v['std']:'';

            $type = $v['type'];


            switch ($type){
                case 'select':
                    $output.="->add('".$v['id']."', __('".$v["title"]."', 'ct_theme'), '".$type."',".NEW_LINE;
                    $output.="array('choices' => array(".NEW_LINE;

                    foreach ($v["options"] as $k2=>$v2){
                        $output.="'".$k2."' => __('".$v2."', 'ct_theme'),".NEW_LINE;
                    }
                    $output.="),".NEW_LINE;

                    $output.="'default'=>'".$v['std']."',".NEW_LINE;
                    $output.="'description'=>'".$v['desc']."'))".NEW_LINE;
                break;


                case 'text':
                case 'select_show':
                    $output.="->add('".$v['id']."', __('".$v["title"]."', 'ct_theme'), '".$type."',".NEW_LINE;
                    $output.="array('default'=>'".$v['std']."',".NEW_LINE;
                    $output.="'description'=>'".$v['desc']."'))".NEW_LINE;
                    break;

            }
            $output.=NEW_LINE;
            $output.=NEW_LINE;
        }


    return '<pre>'.$output.'</pre>';
    }


    /**
     * @return string
     */
    public function getArray()
    {
        return array(
            array(
                'id' => 'shop_product_single_show_share',
                'title' => __("Show share icons?", 'ct_theme'),
                'type' => 'select_show',
                'std' => 1
            )

        );

    }


}


$obj = new ctCodeDistiller();
echo ($obj->generate());exit();