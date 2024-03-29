<?php
if( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists('acf_contact_form_7') ) {
    class acf_contact_form_7 extends acf_field
    {
        function __construct($settings)
        {
            $this->name = 'CONTACT_FORM_7';
            $this->label = __('Contact Form 7', 'acf-contact-form-7');
            $this->category = 'content';
            $this->settings = $settings;
            add_action('wp_ajax_acf_contact_form_7_close', array($this,'acf_contact_form_7_close_callback'));
	        if(!file_exists(dirname(__FILE__)."/fields.conf")) {
		        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	        }
            parent::__construct();
        }

        function render_field($field)
        {
            if(!file_exists(dirname(__FILE__)."/fields.conf")) {
                $test = fopen(dirname(__FILE__)."/fields.conf", "w");
                fclose($test);
            } else {
                $test_content = file_get_contents(dirname(__FILE__)."/fields.conf");
                if(empty($test_content)) {
                    ?>
                    <div id="acf-contact-form-7" class="hidden" style="max-width:800px">
                        <p><?php echo __('Do you like this plugin?', 'acf-contact-form-7'); ?></p>
                        <a href="<?php echo __('https://wordpress.org/plugins/acf-contact-form-7/#reviews', 'acf-contact-form-7'); ?>" target="_blank"><?php echo __('Leave feedback please', 'acf-contact-form-7'); ?></a>
                        <br>
                        <a href="https://money.yandex.ru/to/41001943592305" target="_blank"><?php echo __('Also we will be grateful to you for any donations for development', 'acf-contact-form-7'); ?></a>
                        <br>
                        <a href="<?php echo __('https://wordpress.org/support/plugin/acf-contact-form-7', 'acf-contact-form-7'); ?>" target="_blank"><?php echo __('If you find a mistake or have a wish, write to us', 'acf-contact-form-7'); ?></a>
                        <br><br>
                        <a href="http://beetle.net.ua/" target="_blank"><?php echo __('Author', 'acf-contact-form-7'); ?> Beetle (www.beetle.net.ua)</a>
                    </div>
                    <?php
                }
            }

            $cf = WPCF7_ContactForm::find();
            ?>
            <select name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>">
                <option disabled<?php if (empty($field['value'])) { ?> selected<?php } ?>><?php echo __('Select form', 'acf-contact-form-7'); ?></option>
                <?php
                foreach ($cf as $form) {
                    $value = '[contact-form-7 id="'.$form->id().'" title="'.$form->title().']';?>
                    <option value='<?php echo $value; ?>'<?php if ($field['value']==$value) { ?> selected<?php } ?>><?php echo $form->title(); ?></option>
                    <?php
                }
                ?>
            </select>
            <?php
        }

        function enqueue(){
            wp_register_script('acf-contact-form-7',$this->settings['url'].'assets/js/acf-contact-form-7.js',array('jquery','jquery-ui-dialog'),$this->settings['version'],false);
            wp_enqueue_script( 'acf-contact-form-7' );
            wp_enqueue_style( 'wp-jquery-ui-dialog' );
        }

        function acf_contact_form_7_close_callback()
        {
            file_put_contents(dirname(__FILE__)."/fields.conf","www.beetle.net.ua");
            wp_die();
        }
    }

    new acf_contact_form_7( $this->settings );

}

?>
