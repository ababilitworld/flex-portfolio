<?php 
namespace Ababilithub\FlexPortfolio\Package\Plugin\Query\Posttype\V1\Concrete\Portfolio;

(defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

use Ababilithub\{
    FlexWordpress\Package\Query\Posttype\V1\Base\Query as BaseQuery
};

class Query extends BaseQuery 
{
    public function init(array $data = []): static
    {
        $this->set_custom_args($data);
        $this->set_post_type('fpfolio');
        
        return $this;
    }
    
    protected function apply_data(array $data): void
    {
        if (isset($data['service'])) 
        {
            $this->filter_by_service($data['service']);
        }
        
        if (isset($data['service_type'])) 
        {
            $this->filter_by_service_type($data['service_type']);
        }
        
        if (isset($data['status'])) 
        {
            $this->filter_by_status($data['status']);
        }
        
        if (isset($data['type'])) 
        {
            $this->filter_by_type($data['type']);
        }
    }
    
    public function filter_by_service($service): static
    {
        return $this->add_tax_query('portfolio-service', $service);
    }
    
    public function filter_by_service_type($service_type): static
    {
        return $this->add_tax_query('portfolio-service-type', $service_type);
    }
    
    public function filter_by_status($status): static
    {
        return $this->add_tax_query('portfolio-status', $status);
    }
    
    public function filter_by_type($type): static
    {
        return $this->add_tax_query('portfolio-type', $type);
    }
    
    public function featured(): static
    {
        return $this->add_meta_query('_featured', '1', '=');
    }
    
    public function with_thumbnail(): static
    {
        $this->args['meta_query'][] = [
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS'
        ];
        return $this;
    }
}