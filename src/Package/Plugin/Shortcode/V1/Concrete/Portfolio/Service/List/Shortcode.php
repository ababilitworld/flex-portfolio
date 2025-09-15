<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Shortcode\V1\Concrete\Portfolio\Service\List;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexWordpress\Package\Shortcode\V1\Base\Shortcode as BaseShortcode,
    FlexWordpress\Package\Notice\V1\Factory\Notice as NoticeFactory,
    FlexWordpress\Package\Notice\V1\Concrete\Transient\Notice as TransientNotice,
    FlexWordpress\Package\Query\Taxonomy\V1\Factory\Query as QueryFactory,
    FlexWordpress\Package\Template\V1\Factory\Template as TemplateFactory,
    FlexWordpress\Package\Template\V1\Concrete\List\Masonry\Template as MasonryListTemplate,
    FlexWordpress\Package\Template\V1\Concrete\List\PremiumCard\Template as PremiumCardListTemplate,
    FlexPortfolio\Package\Plugin\Query\Taxonomy\V1\Concrete\Portfolio\Service\Query as PortfolioServiceTaxonomyQuery
};

use const Ababilithub\{
    FlexPortfolio\PLUGIN_PRE_UNDS,
    FlexPortfolio\PLUGIN_PRE_HYPH,
};

class Shortcode extends BaseShortcode
{
    private $notice_board;
    private $template;
    
    public function init(): void
    {
        $this->set_tag('ababilithub-portfolio-service'); 

        $this->set_default_attributes([
            'style' => 'grid',
            'columns' => '3',
            'search_filter' => 'yes',
            'sidebar_filter' => 'yes',
            'service' => '',
            'service_type' => '',
            'debug' => 'yes',
            'featured' => 'yes',
            'hide_empty' => 'yes', // Changed from status
            'pagination' => 'yes',
            'terms_per_page' => 6,
            'orderby' => 'name', // Changed from date
            'order' => 'ASC',
            'pagination_style' => 'load_more',
            'parent' => 0,
        ]);

        $this->init_hook();
        $this->init_service();
    }

    public function init_hook(): void
    {
        add_action(PLUGIN_PRE_UNDS.'_service_list', [$this, 'service_list']);
    }

    public function init_service(): void
    {
        $this->template = TemplateFactory::get(MasonryListTemplate::class);
        $this->notice_board = NoticeFactory::get(TransientNotice::class);
    }

    public function render(array $attributes): string
    {
        $this->set_attributes($attributes);
        $params = $this->get_attributes();
        
        ob_start();
        do_action(PLUGIN_PRE_UNDS.'_service_list', $params);
        return ob_get_clean();
    }

    public function service_list(array $params): void
    {
        try 
        {
            // Use the TAXONOMY query, not post query
            $query = QueryFactory::get(PortfolioServiceTaxonomyQuery::class);
            $query->init(['taxonomy'=>'portfolio-service']);
            
            // Get the results - terms, not posts!
            $terms = $query->get_terms_with_meta(); // Get terms with their meta
            $total_terms = $query->get_count();

            if(count($terms))
            {
                foreach($terms as $term)
                {
                    if(is_object($term))
                    {
                        $term->thumbnail_id = 622;
                    }
                }

            }            

            //echo "<pre>";print_r(array($total_terms,$terms));echo "</pre>";exit;
            // Include template based on style
            $template_path = $this->get_template_path($params['style']);
            if (file_exists($template_path)) 
            {
                // Pass terms to template
                include $template_path;
            } 
            else 
            {
                // Fallback to default template with TERMS, not posts
                $this->render_default_template($terms, $params, $total_terms);
            }
        
        }
        catch (\Exception $e) 
        {
            // Handle errors gracefully
            if ($params['debug'] === 'yes') 
            {
                $this->notice_board->add([
                    'code' => 'debug_message',
                    'message' => esc_html($e->getMessage().'<br>'.$e->getTraceAsString()),
                    'data' => ['class' => 'notice notice-error is-dismissible']
                ]);
            }
            
            $this->notice_board->add([
                'code' => 'service_not_found',
                'message' => esc_html('No services found.'),
                'data' => ['class' => 'notice notice-warning is-dismissible']
            ]);
        }
    }

    /**
     * Get template path based on style
     */
    private function get_template_path(string $style): string
    {
        $template_name = "portfolio-service-{$style}.php";
        
        // Check theme directory first
        $theme_path = get_stylesheet_directory() . '/ababilithub-portfolio/' . $template_name;
        if (file_exists($theme_path)) 
        {
            return $theme_path;
        }
        
        // Fallback to plugin directory
        return plugin_dir_path(__FILE__) . 'templates/' . $template_name;
    }

    /**
     * Default template fallback - UPDATED FOR TERMS
     */
    private function render_default_template(array $terms, array $atts, int $total_terms): void
    {
        echo $this->template->render($terms);
    }
}