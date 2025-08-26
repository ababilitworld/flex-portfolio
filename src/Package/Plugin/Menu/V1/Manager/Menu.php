<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Menu\V1\Manager;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Manager\V1\Base\Manager as BaseManager,
    FlexWordpress\Package\Menu\V1\Contract\Menu as MenuContract, 
    FlexWordpress\Package\Menu\V1\Factory\Menu as MenuFactory,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Main\Menu as MainMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Posttype\Portfolio\Menu as PortfolioMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Posttype\ImportantLink\Menu as ImportantLinkMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Posttype\Typography\Menu as TypographyMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Posttype\ColorScheme\Menu as ColorSchemeMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Option\Menu as OptionBoxMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\System\Wordpress\Development\Roadmap\Menu as WordpressDevelopmentRoadmapMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\System\Status\Menu as SystemStatusMenu, 
};

class  Menu extends BaseManager
{
    public function __construct()
    {
        $this->init();
    }
    
    public function init()
    {
        $this->set_items(
            [
                MainMenu::class,
                PortfolioMenu::class,
                // ImportantLinkMenu::class,
                ColorSchemeMenu::class,
                // TypographyMenu::class,
                OptionBoxMenu::class,
                WordpressDevelopmentRoadmapMenu::class,
                SystemStatusMenu::class,                    
            ]
        );
    }

    public function boot(): void 
    {
        foreach ($this->get_items() as $item) 
        {
            $item_instance = MenuFactory::get($item);

            if ($item_instance instanceof MenuContract) 
            {
                $item_instance->register();
            }
        }
    }
}