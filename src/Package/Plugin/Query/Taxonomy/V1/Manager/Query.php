<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Query\Taxonomy\V1\Manager;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Manager\V1\Base\Manager as BaseManager,
    FlexWordpress\Package\Query\Taxonomy\V1\Factory\Query as QueryFactory,
    FlexWordpress\Package\Query\Taxonomy\V1\Contract\Query as QueryContract,
    FlexPortfolio\Package\Plugin\Query\Taxonomy\V1\Concrete\Portfolio\Service\Query as PortfolioServiceTaxonomyQuery,
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
            PortfolioServiceTaxonomyQuery::class,
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
