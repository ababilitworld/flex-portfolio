<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Taxonomy\V1\Manager;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Manager\V1\Base\Manager as BaseManager,
    FlexWordpress\Package\Taxonomy\V1\Factory\Taxonomy as TaxonomyFactory,
    FlexWordpress\Package\Taxonomy\V1\Contract\Taxonomy as TaxonomyContract,
    FlexPortfolio\Package\Plugin\Taxonomy\V1\Concrete\Portfolio\Status\Taxonomy as PortfolioStatusTaxonomy,
    FlexPortfolio\Package\Plugin\Taxonomy\V1\Concrete\Portfolio\Type\Taxonomy as PortfolioTypeTaxonomy,
    FlexPortfolio\Package\Plugin\Taxonomy\V1\Concrete\Portfolio\Service\Taxonomy as PortfolioServiceTaxonomy,
    FlexPortfolio\Package\Plugin\Taxonomy\V1\Concrete\Portfolio\Service\Type\Taxonomy as PortfolioServiceTypeTaxonomy,
};

class Taxonomy extends BaseManager
{
    public function __construct()
    {
        $this->init();
    }

    protected function init(): void
    {
        $this->set_items([
            PortfolioServiceTaxonomy::class,
            PortfolioServiceTypeTaxonomy::class,
            PortfolioTypeTaxonomy::class,
            PortfolioStatusTaxonomy::class,
            // Add more taxonomy classes here...
        ]);
    }

    public function boot(): void 
    {
        foreach ($this->get_items() as $itemClass) 
        {
            $taxonomy = TaxonomyFactory::get($itemClass);

            if ($taxonomy instanceof TaxonomyContract) 
            {
                $taxonomy->register();
                $taxonomy->process_terms();
            }
        }
    }
}
