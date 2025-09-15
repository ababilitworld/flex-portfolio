<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Posttype\V1\Concrete\RealEstate\PostMeta\PostMetaBoxContent\Concrete\Section\General;

use Ababilithub\{
    FlexPortfolio\Package\Plugin\Posttype\V1\Concrete\RealEstate\POSTTYPE as RealEstatePosttype,
    FlexWordpress\Package\PostMeta\V1\Mixin\PostMeta as PostMetaMixin,
    FlexWordpress\Package\PostMetaBoxContent\V1\Base\PostMetaBoxContent as BasePostMetaBoxContent,
    FlexPhp\Package\Form\Field\V1\Factory\Field as FieldFactory,
    FlexPhp\Package\Form\Field\V1\Concrete\Text\Field as TextField,
    FlexPhp\Package\Form\Field\V1\Concrete\File\Document\Field as DocField,
    FlexPhp\Package\Form\Field\V1\Concrete\File\Image\Field as ImageField
};

use const Ababilithub\{
    FlexPortfolio\PLUGIN_PRE_HYPH,
    FlexPortfolio\PLUGIN_PRE_UNDS,
};

class PostMetaBoxContent extends BasePostMetaBoxContent
{
    use PostMetaMixin;
    public function init(array $data = []) : static
    {
        $this->posttype = RealEstatePosttype::POSTTYPE;
        $this->post_id = get_the_ID();
        $this->tab_item_id = $this->posttype.'-'.'section-general';
        $this->tab_item_label = esc_html__('General Information');
        $this->tab_item_icon = 'fas fa-edit';
        $this->tab_item_status = 'active';

        $this->init_service();
        $this->init_hook();

        return $this;
    }

    public function init_service():void
    {

    }

    public function init_hook() : void
    {
        add_action(PLUGIN_PRE_UNDS.'_'.$this->posttype.'_'.'meta_box_tab_item',[$this,'tab_item']);
        add_action(PLUGIN_PRE_UNDS.'_'.$this->posttype.'_'.'meta_box_tab_content', [$this,'tab_content']);
        //add_action('save_post', [$this, 'save'], 10, 3);
    }

    public function render() : void
    {
        $meta_values = $this->get_meta_values(get_the_ID());
        //echo "<pre>";print_r($meta_values);echo "</pre>";exit;
        ?>
            <div class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Company Contact Details</h2>
                </div>
                <div class="panel-body">
                    <div class="panel-row  two-columns">
                        <?php
                            $field = '';
                            $field = FieldFactory::get(TextField::class);
                            $field->init([
                                'name' => 'logo-text',
                                'id' => 'logo-text',
                                'label' => 'Logo Text',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter Company Logo Text',
                                'value' => $meta_values['logo-text'],
                                'data' => [
                                    'custom' => 'value'
                                ],
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>
                        <?php
                            $field = '';
                            $field = FieldFactory::get(TextField::class);
                            $field->init([
                                'name' => 'moto-text',
                                'id' => 'moto-text',
                                'label' => 'Moto Text',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter Company Moto Text',
                                'value' => $meta_values['moto-text'],
                                'data' => [
                                    'custom' => 'value'
                                ],
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>
                    </div>
                    <div class="panel-row  two-columns">
                        <?php
                            $mobileNumberField = FieldFactory::get(TextField::class);
                            $mobileNumberField->init([
                                'name' => 'mobile-number',
                                'id' => 'mobile-number',
                                'label' => 'Mobile Number',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter full mobile number of the company',
                                'value' => $meta_values['mobile-number'],
                                'data' => [
                                    'custom' => 'value'
                                ],
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>
                        <?php
                            $emailAddressField = FieldFactory::get(TextField::class);
                            $emailAddressField->init([
                                'name' => 'email-address',
                                'id' => 'email-address',
                                'label' => 'Email Address',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter E-mail address of the company',
                                'value' => $meta_values['email-address'],
                                'data' => [
                                    'custom' => 'value'
                                ],
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>
                    </div>
                    <div class="panel-row">                        
                        <?php
                            $physicalAddressField = FieldFactory::get(TextField::class);
                            $physicalAddressField->init([
                                'name' => 'physical-address',
                                'id' => 'physical-address',
                                'label' => 'Physical Address',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter physical address of the company',
                                'value' => $meta_values['physical-address'],
                                'data' => [
                                    'custom' => 'value'
                                ],
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>
                        
                    </div>
                    <div class="panel-row">
                        <?php
                            // Regular text field for map URL/embed code
                            $googleMapLocationField = FieldFactory::get(TextField::class);
                            $googleMapLocationField->init([
                                'name' => 'google-map-location',
                                'id' => 'google-map-location',
                                'label' => 'Google Map Embed Code',
                                'class' => 'custom-file-input',
                                'required' => false,
                                'help_text' => 'Paste Google Map embed code or share link',
                                'value' => $this->get_map_location($meta_values['google-map-location']),
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>
                    </div>
                    <!-- Add new fields for latitude/longitude -->
                    <div class="panel-row two-columns">
                        <?php
                            $latitudeField = FieldFactory::get(TextField::class);
                            $latitudeField->init([
                                'name' => 'map-latitude',
                                'id' => 'map-latitude',
                                'label' => 'Latitude',
                                'value' => $meta_values['map-latitude'],
                                'help_text' => 'e.g., 23.8103'
                            ])->render();
                            
                            $longitudeField = FieldFactory::get(TextField::class);
                            $longitudeField->init([
                                'name' => 'map-longitude',
                                'id' => 'map-longitude',
                                'label' => 'Longitude',
                                'value' => $meta_values['map-longitude'],
                                'help_text' => 'e.g., 90.4125'
                            ])->render();
                        ?>
                    </div>
                    
                </div>
            </div>
        <?php

    }

    public function get_meta_values($post_id): array 
    {
        return [
            'logo-text' => get_post_meta($post_id, 'logo-text', true) ?: '',
            'moto-text' => get_post_meta($post_id, 'moto-text', true) ?: '',            
            'mobile-number' => get_post_meta($post_id, 'mobile-number', true) ?: '',
            'email-address' => get_post_meta($post_id, 'email-address', true) ?: '',
            'physical-address' => get_post_meta($post_id, 'physical-address', true) ?: '',
            'google-map-location' => get_post_meta($post_id, 'google-map-location', true) ?: '',
            'map-latitude' => get_post_meta($post_id, 'map-latitude', true) ?: '',
            'map-longitude' => get_post_meta($post_id, 'map-longitude', true) ?: ''
            
        ];
    }

    public function save($post_id, $post, $update): void 
    {
        if (!$this->is_valid_save($post_id, $post)) 
        {
            return;
        }

        // Save text fields
        $this->save_text_field($post_id, 'logo-text', sanitize_text_field($_POST['logo-text'] ?? ''));
        $this->save_text_field($post_id, 'moto-text', sanitize_text_field($_POST['moto-text'] ?? ''));        
        $this->save_text_field($post_id, 'mobile-number', sanitize_text_field($_POST['mobile-number'] ?? ''));
        $this->save_text_field($post_id, 'email-address', sanitize_text_field($_POST['email-address'] ?? ''));
        $this->save_text_field($post_id, 'physical-address', sanitize_text_field($_POST['physical-address'] ?? ''));
        $this->save_text_field($post_id, 'google-map-location', sanitize_textarea_field($this->prepare_map_location($_POST['google-map-location'] ?? '')));
        $this->save_text_field($post_id, 'map-latitude', sanitize_text_field($_POST['map-latitude'] ?? ''));
        $this->save_text_field($post_id, 'map-longitude', sanitize_text_field($_POST['map-longitude'] ?? ''));
   
    }
}