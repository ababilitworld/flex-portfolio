<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Posttype\V1\Manager;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Manager\V1\Base\Manager as BaseManager,
    FlexWordpress\Package\Posttype\V1\Factory\Posttype as PosttypeFactory,
    FlexWordpress\Package\Posttype\V1\Contract\Posttype as PosttypeContract,
    FlexPortfolio\Package\Plugin\Posttype\V1\Concrete\Portfolio\Posttype as PortfolioPosttype,
    FlexPortfolio\Package\Plugin\Posttype\V1\Concrete\Consultancy\Posttype as ConsultancyPosttype,
    FlexPortfolio\Package\Plugin\Posttype\V1\Concrete\RealEstate\Posttype as RealEstatePosttype,
    FlexPortfolio\Package\Plugin\Posttype\V1\Concrete\PolytechnicInstitute\Posttype as PolytechnicInstitutePosttype,     
};

class Posttype extends BaseManager
{
    public function __construct()
    {
        $this->init();
    }

    protected function init(): void
    {
        $this->set_items([
            PortfolioPosttype::class,
            ConsultancyPosttype::class,
            RealEstatePosttype::class,
            PolytechnicInstitutePosttype::class,
            // Add more posttype classes here...
        ]);
    }

    public function boot(): void 
    {
        foreach ($this->get_items() as $itemClass) 
        {
            $posttype = PosttypeFactory::get($itemClass);

            if ($posttype instanceof PosttypeContract) 
            {
                $posttype->register();
            }
        }
    }
}
