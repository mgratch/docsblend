<?php
class ctDefaultValues{
    protected $collectImages = false;
    public $imagesArray = array();
    public $variablesToCompile = array();
    public $task = null;
    public function __construct($task = null){
        if($task !== null){
            $this->collectImages = true;
            $this->task = $task;
        }

    }
    public function panel(){
        return $this;
    }
    public function section(){
        return $this;
    }
    public function option($id,$slug,$type,$options = array())
    {
        if('get_variables' !== $this->task) {
            if (null !== $id) {
                if ($this->collectImages && $type == 'image') {
                    $this->imagesArray[] = 'ct_option_' . $id;
                    return $this;
                }
                if (get_theme_mod('ct_option_' . $id) != '' && !isset($options['default'])) {
                    return $this;
                }
                if (isset($options['default'])) {
                    set_theme_mod('ct_option_' . $id, $options['default']);
                }

            }
        }
        return $this;
    }
    public function add( $lessname, $title, $type = null, $options = array() ) {

        //#28994 changing colors in customizer fix
        if (0 === strpos($lessname, '@')) {
           $lessname = str_replace('-', '_', $lessname);
        }

        $lessname = str_replace('@','',$lessname);

        $this->variablesToCompile[] = 'ct_customizer_'.$lessname;
        return $this;

    }


}