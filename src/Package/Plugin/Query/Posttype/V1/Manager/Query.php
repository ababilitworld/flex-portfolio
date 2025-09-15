<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Query\Posttype\V1\Manager;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Manager\V1\Base\Manager as BaseManager,
    FlexWordpress\Package\Query\Posttype\V1\Factory\Query as QueryFactory,
    FlexWordpress\Package\Query\Posttype\V1\Contract\Query as QueryContract,
    FlexPortfolio\Package\Plugin\Query\Posttype\V1\Concrete\Portfolio\Query as PortfolioPosttypeQuery,
};

class Query extends BaseManager
{
    public function __construct()
    {
        $this->init();
    }

    protected function init(): void
    {
        $this->set_items([
            PortfolioPosttypeQuery::class,
            // Add more posttype classes here...
        ]);
    }

    public function boot(): void 
    {
        foreach ($this->get_items() as $itemClass) 
        {
            $itemInstance = QueryFactory::get($itemClass);

            if ($itemInstance instanceof QueryContract) 
            {
                $itemInstance->init();
            }
        }
    }
}
