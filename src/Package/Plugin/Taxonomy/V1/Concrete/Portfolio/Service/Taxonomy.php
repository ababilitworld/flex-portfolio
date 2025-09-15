<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Taxonomy\V1\Concrete\Portfolio\Service;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexWordpress\Package\Taxonomy\V1\Base\Taxonomy as BaseTaxonomy
};

use const Ababilithub\{
    FlexPortfolio\PLUGIN_PRE_UNDS
};

if (!class_exists(__NAMESPACE__.'\Taxonomy')) 
{
    class Taxonomy extends BaseTaxonomy
    {
        public const TAXONOMY = 'portfolio-service';
        public function init(): void
        {
            $this->taxonomy = self::TAXONOMY;
            $this->slug = self::TAXONOMY;

            $this->set_labels([
                'name'              => _x('Portfolio Services', 'taxonomy general name', 'flex-portfolio'),
                'singular_name'     => _x('Portfolio Service', 'taxonomy singular name', 'flex-portfolio'),
                'search_items'      => __('Search Portfolio Services', 'flex-portfolio'),
                'all_items'         => __('All Portfolio Services', 'flex-portfolio'),
                'parent_item'       => __('Parent Portfolio Service', 'flex-portfolio'),
                'parent_item_colon' => __('Parent Portfolio Service:', 'flex-portfolio'),
                'edit_item'         => __('Edit Portfolio Service', 'flex-portfolio'),
                'update_item'       => __('Update Portfolio Service', 'flex-portfolio'),
                'add_new_item'      => __('Add New Portfolio Service', 'flex-portfolio'),
                'new_item_name'     => __('New Portfolio Service Name', 'flex-portfolio'),
                'menu_name'         => __('Portfolio Services', 'flex-portfolio'),
            ]);

            $this->set_args([
                'hierarchical' => true,
                'labels' => $this->labels,
                'public' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => ['slug' => $this->slug],
                'show_in_quick_edit' => true,
                'show_in_rest' => true,
                'meta_box_cb' => 'post_categories_meta_box',
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
            ]);

            $this->set_terms([
                $this->generate_term_data(
                    'consultancy',
                    'Consultancy',
                    'Consultancy Service',
                    [
                        'legal_effect' => 'permanent_transfer',
                        'stamp_duty' => 5.0,
                        'registration_fee' => 2.0,
                        'requires_witness' => true
                    ]
                ),
                $this->generate_term_data(
                    'real_estate',
                    'Real Estate',
                    'Real Estate Service',
                    [
                        'legal_effect' => 'voluntary_transfer',
                        'stamp_duty' => 1.0,
                        'registration_fee' => 1.0,
                        'revocable' => false
                    ]
                ),
                $this->generate_term_data(
                    'polytechnic_institute',
                    'Polytechnic Institute',
                    'Polytechnic Institute Service',
                    [
                        'legal_effect' => 'temporary_possession',
                        'max_duration' => 99,
                        'renewable' => true,
                        'stamp_duty' => 'slab_rate'
                    ]
                )
            ]);

            $this->init_service();
            $this->init_hook();
            
        }

        protected function init_service(): void
        {
            //
        }

        protected function init_hook(): void
        {
            //add_action('init', [$this, 'init_taxonomy'], 97);
            //add_filter(PLUGIN_PRE_UNDS.'_admin_menu', [$this, 'add_menu_items']);
            add_filter($this->taxonomy.'_row_actions', [$this, 'row_action_view_details'], 10, 2);
            
        }

        public function add_menu_items($menu_items = [])
        {
            $menu_items[] = [
                'type' => 'submenu',
                'parent_slug' => 'parent-slug',
                'page_title' => __('Portfolio Service', 'flex-portfolio'),
                'menu_title' => __('Portfolio Service', 'flex-portfolio'),
                'capability' => 'manage_options',
                'menu_slug' => 'edit-tags.php?taxonomy='.$this->slug,
                'callback' => null,
                'position' => 9,
            ];

            return $menu_items;
        }
    }
}