<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\OptionBoxContent\V1\Manager;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Manager\V1\Base\Manager as BaseManager,
    FlexWordpress\Package\OptionBoxContent\V1\Factory\OptionBoxContent as OptionBoxContentFactory,
    FlexWordpress\Package\OptionBoxContent\V1\Contract\OptionBoxContent as OptionBoxContentContract, 
    FlexPortfolio\Package\Plugin\OptionBoxContent\V1\Concrete\Section\CompanyInfo\OptionBoxContent as CompanyInfoOptionBoxContent,
    FlexPortfolio\Package\Plugin\OptionBoxContent\V1\Concrete\Section\ColorScheme\OptionBoxContent as ColorSchemeOptionBoxContent,
    FlexPortfolio\Package\Plugin\OptionBoxContent\V1\Concrete\Section\SocialPlatform\OptionBoxContent as SocialPlatformOptionBoxContent,
    FlexPortfolio\Package\Plugin\OptionBoxContent\V1\Concrete\Section\ImportantLink\OptionBoxContent as ImportantLinkOptionBoxContent,      
};

class OptionBoxContent extends BaseManager
{
    public function __construct()
    {
        $this->init();
    }

    protected function init(): void
    {
        $this->set_items([
            CompanyInfoOptionBoxContent::class,
            ColorSchemeOptionBoxContent::class,
            SocialPlatformOptionBoxContent::class,
            ImportantLinkOptionBoxContent::class
            // Add more posttype classes here...
        ]);
    }

    public function boot(): void 
    {
        foreach ($this->get_items() as $itemClass) 
        {
            $itemObject = OptionBoxContentFactory::get($itemClass);

            if ($itemObject instanceof OptionBoxContentContract) 
            {
                $itemObject->init();
            }
        }
    }
}
