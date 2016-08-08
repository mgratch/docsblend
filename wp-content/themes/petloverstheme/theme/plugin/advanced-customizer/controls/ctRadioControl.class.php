<?php
if (!class_exists('WP_Customize_Control')) {
    return null;
}
class ctRadioControl extends WP_Customize_Control implements ctControlsFilterableInterface
{
    public $choices = array();
    private $options;
    public function filter($string){
    }
    public function __construct($manager, $id, $options = array()){
        $this->options = $options;
        $this->rangeId = $options['lessname'];
        $this->choices = $options['choices'];
        parent::__construct($manager, $id, $options);
    }

    public function render_content()
    {
        ?>
        <label>
        <?php

        $default = esc_html__('Default', 'ct_theme');
        if ( empty( $this->choices ) )
            return;
        $name = '_customize-radio-' . $this->id;

        if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif;
        if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo esc_html($this->description) ; ?></span>
        <?php endif;
        foreach ( $this->choices as $value => $label ) :
            ?>
            <label>
                <input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> class="ct-radio-button"/>
                <?php echo esc_html( $label ); ?><br/>
            </label>
            <?php
        endforeach; ?>
        <input type="hidden" data-default-value="<?php echo esc_attr($this->setting->default);?>" <?php $this->link()?>/>
        <input class="button ct-default" type="button" value="<?php echo esc_attr($default)?>">
        </label>
        <?php
    }
}

?>