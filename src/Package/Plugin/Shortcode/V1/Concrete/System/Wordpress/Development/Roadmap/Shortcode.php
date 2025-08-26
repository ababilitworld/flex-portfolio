<?php

namespace Ababilithub\FlexPortfolio\Package\Plugin\Shortcode\V1\Concrete\System\Wordpress\Development\Roadmap;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexWordpress\Package\Shortcode\V1\Base\Shortcode as BaseShortcode,
};

use const Ababilithub\{
    FlexPortfolio\PLUGIN_PRE_UNDS,
    FlexPortfolio\PLUGIN_PRE_HYPH,
    FlexPortfolio\Package\Plugin\Posttype\V1\Concrete\Land\Deed\POSTTYPE
};

class Shortcode extends BaseShortcode
{
    public function init(): void
    {
        $this->set_tag('ababilithub-wordpress-development-roadmap'); 

        $this->set_default_attributes([
            'style' => 'grid',
            'columns' => '3',
            'pagination' => 'yes',
            'show' => '10',
            'sort' => 'DESC',
            'sort_by' => 'date',
            'status' => 'publish',
            'pagination_style' => 'load_more',
            'search_filter' => 'yes',
            'sidebar_filter' => 'yes',
            'deed_type' => '',
            'district' => '',
            'thana' => '',
            'debug' => 'no'
        ]);

        $this->init_hook();
        $this->init_service();
    }

    public function init_hook(): void
    {
        add_action(PLUGIN_PRE_UNDS.'_wordpress_development_roadmap', [$this, 'wordpress_development_roadmap']);
    }

    public function init_service(): void
    {
        //new PosttypeListTemplate();
    }

    public function render(array $attributes): string
    {
        $this->set_attributes($attributes);
        $params = $this->get_attributes();
        
        ob_start();
        do_action(PLUGIN_PRE_UNDS.'_wordpress_development_roadmap', $params);
        return ob_get_clean();
    }

    public function wordpress_development_roadmap(array $params): void
    {
        try {
            // Output the roadmap HTML structure
            echo '
            <div class="flex-roadmap-container">
                <div class="flex-roadmap-header">
                    <h2 class="flex-roadmap-title">' . esc_html__('WordPress Development Roadmap', 'flex-portfolio') . '</h2>
                    <p class="flex-roadmap-description">' . esc_html__('A comprehensive guide to mastering WordPress plugin development with a freemium model', 'flex-portfolio') . '</p>
                </div>
                
                <div class="flex-roadmap-phases">';
            
            // Define roadmap phases
            $phases = [
                [
                    'title' => __('WordPress Development Fundamentals ( 10% )', 'flex-portfolio'),
                    'progress' => 10,
                    'description' => __('Understand the WordPress core, theme/plugin structure, and hooks.', 'flex-portfolio'),
                    'tasks' => [
                        __('Study the WordPress file structure', 'flex-portfolio'),
                        __('Learn WordPress hooks (actions & filters)', 'flex-portfolio'),
                        __('Follow WordPress coding standards', 'flex-portfolio')
                    ]
                ],
                [
                    'title' => __('Custom Plugin Development ( 20% )', 'flex-portfolio'),
                    'progress' => 30,
                    'description' => __('Learn to create and structure a WordPress plugin professionally.', 'flex-portfolio'),
                    'tasks' => [
                        __('Set up a plugin folder with the correct structure', 'flex-portfolio'),
                        __('Register shortcodes, widgets, and custom post types', 'flex-portfolio'),
                        __('Create a "Custom Post Type Manager" plugin', 'flex-portfolio')
                    ]
                ],
                [
                    'title' => __('Database Management & Optimization  ( 10% )', 'flex-portfolio'),
                    'progress' => 40,
                    'description' => __('Learn how to interact with the WordPress database safely.', 'flex-portfolio'),
                    'tasks' => [
                        __('Understand the WordPress database structure', 'flex-portfolio'),
                        __('Use caching strategies', 'flex-portfolio'),
                        __('Build a custom report generator plugin', 'flex-portfolio')
                    ]
                ],
                [
                    'title' => __('Security & Best Practices ( 10% )', 'flex-portfolio'),
                    'progress' => 50,
                    'description' => __('Secure WordPress plugins against common vulnerabilities.', 'flex-portfolio'),
                    'tasks' => [
                        __('Learn nonce verification, data sanitization, and escaping', 'flex-portfolio'),
                        __('Prevent SQL injection, XSS, and CSRF attacks', 'flex-portfolio'),
                        __('Implement nonce verification for a custom API endpoint', 'flex-portfolio')
                    ]
                ],
                [
                    'title' => __('API Development & Integration ( 15% )', 'flex-portfolio'),
                    'progress' => 65,
                    'description' => __('Work with REST APIs and build custom API endpoints.', 'flex-portfolio'),
                    'tasks' => [
                        __('Learn REST API fundamentals', 'flex-portfolio'),
                        __('Implement authentication and security for API requests', 'flex-portfolio'),
                        __('Build a "Custom API for Posts" plugin', 'flex-portfolio')
                    ]
                ],
                [
                    'title' => __('Node.js for WordPress Plugin Enhancement ( 15% )', 'flex-portfolio'),
                    'progress' => 80,
                    'description' => __('Use Node.js to build interactive, real-time WordPress features.', 'flex-portfolio'),
                    'tasks' => [
                        __('Learn Node.js and asynchronous JavaScript', 'flex-portfolio'),
                        __('Use Express.js to create a custom API', 'flex-portfolio'),
                        __('Create a real-time notification system for WordPress', 'flex-portfolio')
                    ]
                ],
                [
                    'title' => __('Monetization & Freemium Model ( 10% )', 'flex-portfolio'),
                    'progress' => 90,
                    'description' => __('Implement a freemium business model for WordPress plugins.', 'flex-portfolio'),
                    'tasks' => [
                        __('Implement license key validation for premium features', 'flex-portfolio'),
                        __('Explore Freemius, EDD, and WooCommerce for selling plugins', 'flex-portfolio'),
                        __('Convert a free plugin into a freemium plugin', 'flex-portfolio')
                    ]
                ],
                [
                    'title' => __('Deployment, Testing & Maintenance ( 10% )', 'flex-portfolio'),
                    'progress' => 100,
                    'description' => __('Automate plugin deployment and improve testing.', 'flex-portfolio'),
                    'tasks' => [
                        __('Use Composer for dependency management', 'flex-portfolio'),
                        __('Automate plugin deployment to WordPress.org', 'flex-portfolio'),
                        __('Set up GitHub Actions for automated plugin testing', 'flex-portfolio')
                    ]
                ]
            ];
            
            // Output each phase
            foreach ($phases as $index => $phase) {
                echo '
                <div class="flex-roadmap-phase">
                    <div class="flex-phase-header" onclick="flexTogglePhaseDetails(' . $index . ')">
                        <div class="flex-phase-number">' . ($index + 1) . '</div>
                        <div class="flex-phase-content">
                            <h3 class="flex-phase-title">' . esc_html($phase['title']) . '</h3>
                            <div class="flex-phase-progress">
                                <div class="flex-progress-bar" style="width: ' . $phase['progress'] . '%;"></div>
                                <span class="flex-progress-text">' . $phase['progress'] . '%</span>
                            </div>
                        </div>
                        <div class="flex-phase-toggle">
                            <span class="flex-toggle-icon">+</span>
                        </div>
                    </div>
                    <div class="flex-phase-details" id="flex-phase-details-' . $index . '">
                        <p class="flex-phase-description">' . esc_html($phase['description']) . '</p>
                        <ul class="flex-phase-tasks">';
                
                foreach ($phase['tasks'] as $task) {
                    echo '<li>' . esc_html($task) . '</li>';
                }
                
                echo '
                        </ul>
                    </div>
                </div>';
            }
            
            echo '
                </div>
            </div>
            
            <style>
                .flex-roadmap-container {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, sans-serif;
                    max-width: 900px;
                    margin: 0 auto;
                    padding: 20px;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                }
                
                .flex-roadmap-header {
                    text-align: center;
                    margin-bottom: 30px;
                    padding-bottom: 20px;
                    border-bottom: 1px solid #eee;
                }
                
                .flex-roadmap-title {
                    color: #1d2327;
                    margin: 0 0 10px;
                    font-size: 28px;
                }
                
                .flex-roadmap-description {
                    color: #646970;
                    margin: 0;
                    font-size: 16px;
                }
                
                .flex-roadmap-phases {
                    display: flex;
                    flex-direction: column;
                    gap: 15px;
                }
                
                .flex-roadmap-phase {
                    border: 1px solid #dcdcde;
                    border-radius: 4px;
                    overflow: hidden;
                    transition: all 0.3s ease;
                }
                
                .flex-phase-header {
                    display: flex;
                    align-items: center;
                    padding: 15px 20px;
                    background: #f6f7f7;
                    cursor: pointer;
                    transition: background 0.3s ease;
                }
                
                .flex-phase-header:hover {
                    background: #f0f0f1;
                }
                
                .flex-phase-number {
                    width: 30px;
                    height: 30px;
                    background: #2271b1;
                    color: white;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    margin-right: 15px;
                    flex-shrink: 0;
                }
                
                .flex-phase-content {
                    flex-grow: 1;
                }
                
                .flex-phase-title {
                    margin: 0 0 8px;
                    color: #1d2327;
                    font-size: 18px;
                }
                
                .flex-phase-progress {
                    height: 8px;
                    background: #dcdcde;
                    border-radius: 4px;
                    position: relative;
                    overflow: hidden;
                }
                
                .flex-progress-bar {
                    height: 100%;
                    background: #2271b1;
                    border-radius: 4px;
                    transition: width 0.5s ease;
                }
                
                .flex-progress-text {
                    position: absolute;
                    right: 5px;
                    top: -20px;
                    font-size: 12px;
                    color: #646970;
                }
                
                .flex-phase-toggle {
                    margin-left: 15px;
                }
                
                .flex-toggle-icon {
                    font-size: 20px;
                    color: #646970;
                    transition: transform 0.3s ease;
                }
                
                .flex-phase-details {
                    padding: 0;
                    max-height: 0;
                    overflow: hidden;
                    transition: max-height 0.3s ease, padding 0.3s ease;
                    background: white;
                }
                
                .flex-phase-details.active {
                    padding: 20px;
                    max-height: 500px;
                }
                
                .flex-phase-description {
                    margin: 0 0 15px;
                    color: #3c434a;
                    font-size: 15px;
                    line-height: 1.5;
                }
                
                .flex-phase-tasks {
                    margin: 0;
                    padding-left: 20px;
                    color: #3c434a;
                }
                
                .flex-phase-tasks li {
                    margin-bottom: 8px;
                    line-height: 1.4;
                }
                
                @media (max-width: 600px) {
                    .flex-phase-header {
                        flex-wrap: wrap;
                    }
                    
                    .flex-phase-number {
                        margin-bottom: 10px;
                    }
                    
                    .flex-phase-content {
                        width: 100%;
                    }
                }
            </style>
            
            <script>
                function flexTogglePhaseDetails(index) {
                    const details = document.getElementById("flex-phase-details-" + index);
                    const icon = document.querySelector(`#flex-phase-details-${index}`).previousElementSibling.querySelector(".flex-toggle-icon");
                    
                    details.classList.toggle("active");
                    icon.textContent = details.classList.contains("active") ? "−" : "+";
                }
            </script>';
            
        } catch (Exception $e) {
            if ($params['debug'] === 'yes') {
                echo '<div class="flex-roadmap-error">' . esc_html__('Error: ', 'flex-portfolio') . esc_html($e->getMessage()) . '</div>';
            } else {
                echo '<div class="flex-roadmap-error">' . esc_html__('Unable to display the roadmap at this time.', 'flex-portfolio') . '</div>';
            }
        }
    }
}