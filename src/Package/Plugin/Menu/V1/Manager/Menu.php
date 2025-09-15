<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Menu\V1\Manager;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Manager\V1\Base\Manager as BaseManager,
    FlexWordpress\Package\Menu\V1\Contract\Menu as MenuContract, 
    FlexWordpress\Package\Menu\V1\Factory\Menu as MenuFactory,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Main\Menu as MainMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Taxonomy\Portfolio\Service\Menu as PortfolioServiceMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Taxonomy\Portfolio\Service\Type\Menu as PortfolioServiceTypeMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Taxonomy\Portfolio\Type\Menu as PortfolioTypeMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Taxonomy\Portfolio\Status\Menu as PortfolioStatusMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Posttype\Portfolio\Menu as PortfolioMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Posttype\Consultancy\Menu as ConsultencyMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Posttype\RealEstate\Menu as RealEstateMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Posttype\PolytechnicInstitute\Menu as PolytechnicInstituteMenu,
    FlexPortfolio\Package\Plugin\Menu\V1\Concrete\Shortcode\Portfolio\Service\Menu as PortfolioServiceShortcodeMenu,
      
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
                PortfolioServiceMenu::class,
                PortfolioServiceTypeMenu::class,
                PortfolioTypeMenu::class,
                PortfolioStatusMenu::class,
                PortfolioMenu::class,
                //ConsultencyMenu::class,
                //RealEstateMenu::class,
                //PolytechnicInstituteMenu::class,
                PortfolioServiceShortcodeMenu::class                    
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