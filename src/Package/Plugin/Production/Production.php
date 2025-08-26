<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Production;

(defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexPortfolio\Package\Plugin\Menu\V1\Manager\Menu as MenuManager,
    FlexPortfolio\Package\Plugin\Posttype\V1\Manager\Posttype as PosttypeManager,
    FlexPortfolio\Package\Plugin\Shortcode\V1\Manager\Shortcode as ShortcodeManager, 
    FlexPortfolio\Package\Plugin\OptionBox\V1\Manager\OptionBox as OptionBoxManager,
    FlexPortfolio\Package\Plugin\OptionBoxContent\V1\Manager\OptionBoxContent as OptionBoxContentManager,
    FlexPortfolio\Package\Plugin\Notice\V1\Manager\Notice as NoticeManager,
};

if (!class_exists(__NAMESPACE__.'\Production')) 
{
    class Production 
    {
        use StandardMixin;

        public function __construct($data = []) 
        {
            $this->init();      
        }

        public function init() 
        {
            add_action('init', function () {
                (new NoticeManager())->boot();
            });


            // add_action('init', function () {
            //     (new TaxonomyManager())->boot();
            // });

            add_action('init', function () {
                (new PosttypeManager())->boot();
            });

            add_action('init', function () {
                (new ShortcodeManager())->boot();
            });

            add_action('init', function () {
                (new OptionBoxManager())->boot();
            });

            add_action('init', function () {
                (new OptionBoxContentManager())->boot();
            });
            
            // Initialize only once on admin_menu
            add_action('init', function () {
                (new MenuManager())->boot();
            });

        }
        
    }
}