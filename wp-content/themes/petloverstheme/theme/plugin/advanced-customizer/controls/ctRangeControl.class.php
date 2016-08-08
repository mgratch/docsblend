<?php
if (!class_exists('WP_Customize_Control')) {
    return null;
}
class ctRangeControl extends WP_Customize_Control implements ctControlsFilterableInterface
{
    private $options;
    public function __construct($manager, $id, $options = array())
    {
        $this->options = $options;
        $this->rangeId = $options['lessname'];
        parent::__construct($manager, $id, $options);
    }

    public function render_content()
    {
        $default = esc_html__('Default', 'ct_theme');
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html($this->label);?></span>
            <strong><span class="description customize-control-description"><?php echo esc_html($this->description);?></span></strong>
            <span class="range-current-value"></span>
            <input type="range"
                   min="<?php echo esc_html($this->getOption('min'));?>"
                   max="<?php echo esc_html($this->getOption('max'));?>"
                   step="<?php echo esc_html($this->getOption('step'));?>"
                   value="<?php echo esc_attr($this->value());?>"
                   data-default-value="<?php echo esc_attr($this->setting->default)?>"
                   data-unit="<?php echo esc_attr($this->getOption('unit'));?>"
                <?php $this->link();?> >
            <input class="button ct-default" type="button" value="<?php echo esc_attr($default)?>">
        </label>
        <?php
    }

    public function filter($string){
    }
    protected function getOption($name){
        return isset($this->options[$name]) ? $this->options[$name] : '';
    }

}

?>