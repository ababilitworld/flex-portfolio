<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Query\Taxonomy\V1\Concrete\Portfolio\Service;

use Ababilithub\{
    FlexWordpress\Package\Query\Taxonomy\V1\Base\Query as BaseQuery
};

class Query extends BaseQuery
{
    public function init(array $data = []): static
    {
        $this->set_custom_args($data);
        return $this;
    }
    
    protected function apply_data(array $data): void
    {
        if (isset($data['hide_empty'])) 
        {
            $this->set_hide_empty((bool) $data['hide_empty']);
        }
        
        if (isset($data['orderby'])) 
        {
            $order = $data['order'] ?? 'ASC';
            $this->set_order_by($data['orderby'], $order);
        }
        
        if (isset($data['parent'])) 
        {
            $this->set_parent((int) $data['parent']);
        }
    }
    
    /**
     * Get only featured services
     */
    public function featured(): static
    {
        return $this->add_meta_query('featured', '1', '=');
    }
    
    /**
     * Get services with specific status
     */
    public function with_status(string $status): static
    {
        return $this->add_meta_query('service_status', $status, '=');
    }
    
    /**
     * Get services with pricing information
     */
    public function with_pricing(): static
    {
        return $this->add_meta_query('price', '', 'EXISTS');
    }
}