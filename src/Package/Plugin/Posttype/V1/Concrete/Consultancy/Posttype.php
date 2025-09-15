<?php
namespace Ababilithub\FlexPortfolio\Package\Plugin\Posttype\V1\Concrete\Consultancy;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexWordpress\Package\Posttype\V1\Mixin\Posttype as WpPosttypeMixin,
    FlexWordpress\Package\Posttype\V1\Base\Posttype as BasePosttype,
    FlexPortfolio\Package\Plugin\Posttype\V1\Concrete\Consultancy\Presentation\Template\Single\Template as PosttypeTemplate,
    FlexPortfolio\Package\Plugin\Posttype\V1\Concrete\Consultancy\PostMeta\PostMetaBox\Manager\PostMetaBox as ConsultancyPostMetaBoxManager,
    FlexPortfolio\Package\Plugin\Posttype\V1\Concrete\Consultancy\PostMeta\PostMetaBoxContent\Manager\PostMetaBoxContent as ConsultancyPostMetaBoxContentManager,
    
};

use const Ababilithub\{
    FlexPortfolio\PLUGIN_PRE_UNDS,
    FlexPortfolio\PLUGIN_DIR,
};

class Posttype extends BasePosttype 
{ 
    use WpPosttypeMixin;

    public const POSTTYPE = 'fconsul';

    private $template_service;
    
    public function init() : void
    {
        $this->posttype = self::POSTTYPE;
        $this->slug = self::POSTTYPE;

        $this->set_labels([
            'name' => esc_html__('Consultancys', 'flex-portfolio'),
            'singular_name' => esc_html__('Consultancy', 'flex-portfolio'),
            'menu_name' => esc_html__('Consultancys', 'flex-portfolio'),
            'name_admin_bar' => esc_html__('Consultancys', 'flex-portfolio'),
            'archives' => esc_html__('Consultancy List', 'flex-portfolio'),
            'attributes' => esc_html__('Consultancy List', 'flex-portfolio'),
            'parent_item_colon' => esc_html__('Consultancy Item : ', 'flex-portfolio'),
            'all_items' => esc_html__('All Consultancy', 'flex-portfolio'),
            'add_new_item' => esc_html__('Add new Consultancy', 'flex-portfolio'),
            'add_new' => esc_html__('Add new Consultancy', 'flex-portfolio'),
            'new_item' => esc_html__('New Consultancy', 'flex-portfolio'),
            'edit_item' => esc_html__('Edit Consultancy', 'flex-portfolio'),
            'update_item' => esc_html__('Update Consultancy', 'flex-portfolio'),
            'view_item' => esc_html__('View Consultancy', 'flex-portfolio'),
            'view_items' => esc_html__('View Consultancys', 'flex-portfolio'),
            'search_items' => esc_html__('Search Consultancys', 'flex-portfolio'),
            'not_found' => esc_html__('Consultancy Not found', 'flex-portfolio'),
            'not_found_in_trash' => esc_html__('Consultancy Not found in Trash', 'flex-portfolio'),
            'featured_image' => esc_html__('Consultancy Feature Image', 'flex-portfolio'),
            'set_featured_image' => esc_html__('Set Consultancy Feature Image', 'flex-portfolio'),
            'remove_featured_image' => esc_html__('Remove Feature Image', 'flex-portfolio'),
            'use_featured_image' => esc_html__('Use as Consultancy featured image', 'flex-portfolio'),
            'insert_into_item' => esc_html__('Insert into Consultancy', 'flex-portfolio'),
            'uploaded_to_this_item' => esc_html__('Uploaded to this ', 'flex-portfolio'),
            'items_list' => esc_html__('Consultancy list', 'flex-portfolio'),
            'items_list_navigation' => esc_html__('Consultancy list navigation', 'flex-portfolio'),
            'filter_items_list' => esc_html__('Filter Consultancy List', 'flex-portfolio')
        ]);

        $this->set_posttype_supports(
            array('title', 'thumbnail', 'editor')
        );

        $this->set_taxonomies([]);

        $this->set_args([
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => false, // Don't show in menu by default
            'labels' => $this->labels,
            'menu_icon' => "dashicons-admin-post",
            'rewrite' => array('slug' => $this->slug,'with_front' => false),
            'has_archive' => true,        // If you want archive pages
            'supports' => $this->posttype_supports,
            'taxonomies' => $this->taxonomies,
        ]);

        $this->init_service();
        $this->init_hook();

    }

    public function init_service(): void
    {
       $this->template_service = new PosttypeTemplate();
    }

    public function init_hook(): void
    {
        add_action('after_setup_theme', [$this, 'init_theme_supports'],0);

        add_action('add_meta_boxes', function () {
            (new ConsultancyPostMetaBoxManager())->boot();
        });

        add_action('add_meta_boxes', function () {
            (new ConsultancyPostMetaBoxContentManager())->boot();
        });

        add_action('save_post', function ($post_id, $post, $update) {
            (new ConsultancyPostMetaBoxContentManager())->save_post($post_id, $post, $update);
        }, 10, 3);

        add_filter('the_content', [$this, 'single_post']);
        
        add_filter('post_row_actions', [$this, 'row_action_view_details'], 10, 2);
        add_filter('page_row_actions', [$this, 'row_action_view_details'], 10, 2);


    }

    public function init_theme_supports()
    {
        add_theme_support('post-thumbnails', [$this->posttype]);
        add_theme_support('editor-color-palette', [
            [
                'name'  => 'Primary Blue',
                'slug'  => 'primary-blue',
                'color' => '#3366FF',
            ],
        ]);
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
    }

    public function single_post($content)
    {
        // Only modify content on single post pages of specific post types
        if (!is_singular() || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        global $post;
        
        // First check if $post exists and is a valid post object
        if (!$post || !is_object($post)) {
            return $content;
        }
        
        // Then check the post type
        if ($post->post_type !== self::POSTTYPE) {
            return $content;
        }
        
        // Prevent infinite recursion
        remove_filter('the_content', [$this, 'single_post']);
        
        // Get template content - use the class directly like in LandDeed version
        $template_content = $this->template_service->single_post($post);
        
        // Re-add our filter
        add_filter('the_content', [$this, 'single_post']);
        
        // Combine with original content
        return $template_content;
    }

}