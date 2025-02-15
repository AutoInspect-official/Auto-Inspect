<?php

/**
 * @author Bill Minozzi
 * @copyright 2016
 */

namespace cardealer\WP\Settings;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
/**
 * Base class for optons page builders.
 */
class OptionPageBuilder
{
    protected $page;
    protected $tabs;
    protected $scripts;
    protected $styles;
    public function __construct($page, $scripts = array(), $styles = array())
    {
        // Initialize page and register page action
        $this->page = $page;
        add_action('admin_menu', array($this, 'register_page'));
        // Add user supplied scripts for this page
        $this->scripts = $scripts;
        // Add user supplied stylesheets
        $this->styles = $styles;
        global $cardealer_pcs_settings_config;
        // Load PCS Settings stylesheet.

        $this->styles[] = array(
            'handle' => 'pcs-admin-settings',
            'src' => $cardealer_pcs_settings_config['base_uri'] . 'styles/admin-settings.css',
            'enqueue' => true
        );
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    }
    public function register_page()
    {
        //    	    wp_enqueue_style( 'bill-admin-styles' , CARDEALERURL.'settings/styles/admin-settings.css');
        switch ($this->page->type) {
            case 'menu':
                // TODO: Add icon url and postion configuration values
                add_menu_page($this->page->title, $this->page->menu_title, $this->page->capability, $this->page->slug, array($this, 'render'));
                $this->page->set_hook('toplevel_page_');
                break;
            case 'submenu':
                add_submenu_page($this->page->parent_slug, $this->page->title, $this->page->menu_title, $this->page->capability, $this->page->slug, array($this, 'render'));
                break;
            case 'submenu2':
                add_submenu_page(
                    'edit.php?post_type=cars',
                    'Settings',
                    $this->page->menu_title,
                    $this->page->capability,
                    $this->page->slug,
                    array($this, 'render')
                );
                break;
            case 'settings':
                add_options_page($this->page->title, $this->page->menu_title, $this->page->capability, $this->page->slug, array($this, 'render'));
                $this->page->set_hook('settings_page_');
                break;
            default:
                add_theme_page($this->page->title, $this->page->menu_title, $this->page->capability, $this->page->slug, array($this, 'render'));
                $this->page->set_hook('appearance_page_');
                break;
        }
    }
    public function admin_enqueue_scripts($page_hook)
    {


        // Only load our scripts on our page
        // $this->page->hookem vazio...
        //////	if($this->page->hook == $page_hook) {
        // Process the Scripts
        foreach ($this->scripts as $script) {

            // die($script['src']);

            $deps = (isset($script['deps'])) ? $script['deps'] : array();
            if (isset($script['enqueue']) && $script['enqueue']) {
                if (isset($script['src']) && !wp_script_is($script['handle'], 'registered')) {
                    wp_register_script($script['handle'], $script['src'], $deps, CARDEALERVERSION);
                }
                if (!wp_script_is($script['handle'], 'enqueued')) {
                    wp_enqueue_script($script['handle']);
                }
            } else {
                if (isset($script['src']) && !wp_script_is($script['handle'], 'registered')) {
                    wp_register_script($script['handle'], $script['src'], $script['deps'], CARDEALERVERSION);
                }
            }
        }
        // Process the Styles
        foreach ($this->styles as $style) {
            $deps = (isset($style['deps'])) ? $style['deps'] : array();
            if (isset($style['enqueue']) && $style['enqueue']) {
                if (isset($style['src']) && !wp_style_is($style['handle'], 'registered')) {
                    wp_register_style($style['handle'], $style['src'], $deps, CARDEALERVERSION);
                }
                if (!wp_style_is($style['handle'], 'enqueued')) {
                    wp_enqueue_style($style['handle']);
                }
            } else {
                if (isset($style['src']) && !wp_style_is($style['handle'], 'registered')) {
                    wp_register_style($style['handle'], $style['src'], $style['deps'], CARDEALERVERSION);
                }
            }
        }
        // 	} Endif
    }

    public function render()
    {
        do_action('cardealer_pcs_render_option_page');
        echo '<form method="post" action="options.php">';
        // TODO: only output errors on custom pages
        // settings_errors();
        settings_fields($this->page->slug);
        do_settings_sections($this->page->slug);
        submit_button();
        echo '</form>';
        $this->render_reset_form();
        echo esc_html($this->page->markup_bottom);

        // Add filter to sanitize textarea content
        add_filter('pre_update_option_' . $this->page->slug, array($this, 'sanitize_textarea'), 10, 2);
    }


    public function sanitize_textarea($value, $old_value)
    {
        // Sanitize textarea content using wp_kses_post()
        if (isset($value['cardealer_fieldfeatures'])) {
            $value['cardealer_fieldfeatures'] = wp_kses_post($value['cardealer_fieldfeatures']);
        }

        return $value;
    }


    public function render_reset_form($active_tab = null)
    {
        // echo reset form
        // echo '<form method="post" action="' . esc_attr(str_replace('&settings-updated=true', '',
        //     esc_url($_SERVER["REQUEST_URI"]))) . '" class="reset-form">';

        echo '<form method="post" action="' . esc_attr(esc_url(str_replace('&settings-updated=true', '', sanitize_text_field($_SERVER["REQUEST_URI"])))) . '" class="reset-form">';

        // Reset nonce
        wp_nonce_field('pcs_reset_options', 'pcs_reset_options_nonce');
        echo '<input type="hidden" name="action" value="reset" />';
        if (!is_null($active_tab)) {
            echo '<button type="submit" class="button secondary reset-settings" title="Reset ' .
                esc_html($active_tab->title) . '">Reset ' . esc_html($active_tab->title) . '</button>';
        } else {
            echo '<button type="submit" class="button secondary reset-settings" title="Reset Options">Reset Options</button>';
        }
        echo '</form>';
    }
}
/**
 * Single options page builder
 */
class OptionPageBuilderSingle extends OptionPageBuilder
{
    public function __construct($page, $section_settings = array(), $scripts = array(), $styles = array())
    {
        parent::__construct($page, $scripts, $styles);
        new SectionFactory($page, $section_settings);
    }
}
/**
 * Tabbed options page builder.
 */
class OptionPageBuilderTabbed extends OptionPageBuilder
{
    protected $tabs;
    public function __construct($page, $options_settings = array(), $scripts = array(), $styles = array())
    {
        parent::__construct($page, $scripts, $styles);
        $this->tabs = array();
        $counter = 0;
        // Runs when posting to option.php
        // Only create the active tab so the other page sections
        // Do not get overwritten
        $action = sanitize_text_field((isset($_POST['action'])) ? $_POST['action'] : false);
        $page_key = sanitize_text_field((isset($_POST['option_page'])) ? $_POST['option_page'] : false);
        if ($page_key == $page->slug && $action == 'update') {
            // Extract the tab id from the referer post
            $referrer = sanitize_text_field((isset($_POST['_wp_http_referer'])) ? $_POST['_wp_http_referer'] :
                '');
            $matches = array();
            preg_match('/tab=([^&]*)/', $referrer, $matches);
            // Build the Tab Sections for the submitted tab
            foreach ($options_settings as $title => $section_settings) {
                $id = str_replace('-', '_', sanitize_title_with_dashes($title));
                if (isset($matches[1]) && $matches[1] == $id) {
                    // Tab submitted was determined
                    $this->tabs[] = new Tab($title, $id, $this->page, $section_settings, true);
                    break;
                }
                // Cache first id for use if no tab match is found
                if ($counter == 0) {
                    $first = array(
                        'id' => $id,
                        'title' => $title,
                        'settings' => $section_settings
                    );
                }
                $counter++;
            }
            // If no tab was created
            // create the default tab with the first id
            if (empty($this->tabs)) {
                $this->tabs[] = new Tab($first['title'], $first['id'], $this->page, $first['settings'], true);
            }
        } else {
            // Runs when displaying the options page
            // Show the first tab as active by default
            foreach ($options_settings as $title => $section_settings) {
                $id = str_replace('-', '_', sanitize_title_with_dashes($title));
                // Each Key Is Tab
                // Set first one to active by default
                if ($counter == 0) {
                    $this->tabs[] = new Tab($title, $id, $this->page, $section_settings, true);
                } else {
                    $this->tabs[] = new Tab($title, $id, $this->page, $section_settings);
                }
                $counter++;
            }
        }
    }
    public function render2()
    {
        $active_tab_id = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : $this->tabs[0]->id;
        do_action('cardealer_pcs_render_option_page');
        echo esc_html($this->page->markup_top);

        //echo '<div id="containerleft">';


        echo '<form method="post" action="options.php">';
        settings_errors();
        // Output all tab headings
        echo '<h2 class="nav-tab-wrapper">';
        foreach ($this->tabs as $tab) {
            // Outbut Tabs
            if ($tab->active) {
                echo esc_html($tab->get_anchor(true));
                // Cache active tab to reneder sections later
                $active_tab = $tab;
            } else {
                echo esc_html($tab->get_anchor());
            }
        }
        echo '</h2>';
        settings_fields($this->page->slug);
        do_settings_sections($this->page->slug);

        submit_button();




        //  if ($active_tab_id <> 'startup_guide' and $active_tab_id <> 'go_premium')
        // require_once ("mybanners.inc");


        echo esc_html($this->page->markup_bottom);
    }

    public function render()
    {


        $cardealer_allowed_atts = array(
            'align'      => array(),
            'class'      => array(),
            'type'       => array(),
            'id'         => array(),
            'dir'        => array(),
            'lang'       => array(),
            'style'      => array(),
            'xml:lang'   => array(),
            'src'        => array(),
            'alt'        => array(),
            'href'       => array(),
            'rel'        => array(),
            'rev'        => array(),
            'target'     => array(),
            'novalidate' => array(),
            'type'       => array(),
            'value'      => array(),
            'name'       => array(),
            'tabindex'   => array(),
            'action'     => array(),
            'method'     => array(),
            'for'        => array(),
            'width'      => array(),
            'height'     => array(),
            'data'       => array(),
            'title'      => array(),

            'checked' => array(),
            'selected' => array(),


        );




        $my_allowed['form'] = $cardealer_allowed_atts;
        $my_allowed['select'] = $cardealer_allowed_atts;
        // select options
        $my_allowed['option'] = $cardealer_allowed_atts;
        $my_allowed['style'] = $cardealer_allowed_atts;
        $my_allowed['label'] = $cardealer_allowed_atts;
        $my_allowed['input'] = $cardealer_allowed_atts;
        $my_allowed['textarea'] = $cardealer_allowed_atts;

        //more...future...
        $my_allowed['form']     = $cardealer_allowed_atts;
        $my_allowed['label']    = $cardealer_allowed_atts;
        $my_allowed['input']    = $cardealer_allowed_atts;
        $my_allowed['textarea'] = $cardealer_allowed_atts;
        $my_allowed['iframe']   = $cardealer_allowed_atts;
        $my_allowed['script']   = $cardealer_allowed_atts;
        $my_allowed['style']    = $cardealer_allowed_atts;
        $my_allowed['strong']   = $cardealer_allowed_atts;
        $my_allowed['small']    = $cardealer_allowed_atts;
        $my_allowed['table']    = $cardealer_allowed_atts;
        $my_allowed['span']     = $cardealer_allowed_atts;
        $my_allowed['abbr']     = $cardealer_allowed_atts;
        $my_allowed['code']     = $cardealer_allowed_atts;
        $my_allowed['pre']      = $cardealer_allowed_atts;
        $my_allowed['div']      = $cardealer_allowed_atts;
        $my_allowed['img']      = $cardealer_allowed_atts;
        $my_allowed['h1']       = $cardealer_allowed_atts;
        $my_allowed['h2']       = $cardealer_allowed_atts;
        $my_allowed['h3']       = $cardealer_allowed_atts;
        $my_allowed['h4']       = $cardealer_allowed_atts;
        $my_allowed['h5']       = $cardealer_allowed_atts;
        $my_allowed['h6']       = $cardealer_allowed_atts;
        $my_allowed['ol']       = $cardealer_allowed_atts;
        $my_allowed['ul']       = $cardealer_allowed_atts;
        $my_allowed['li']       = $cardealer_allowed_atts;
        $my_allowed['em']       = $cardealer_allowed_atts;
        $my_allowed['hr']       = $cardealer_allowed_atts;
        $my_allowed['br']       = $cardealer_allowed_atts;
        $my_allowed['tr']       = $cardealer_allowed_atts;
        $my_allowed['td']       = $cardealer_allowed_atts;
        $my_allowed['p']        = $cardealer_allowed_atts;
        $my_allowed['a']        = $cardealer_allowed_atts;
        $my_allowed['b']        = $cardealer_allowed_atts;
        $my_allowed['i']        = $cardealer_allowed_atts;


        $active_tab_id = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : $this->tabs[0]->id;
        do_action('cardealer_pcs_render_option_page');
        //echo $this->page->markup_top;
        echo wp_kses($this->page->markup_top, $my_allowed);
        // echo esc_attr($this->page->markup_top);

        //echo '<div id="containerleft">';

        echo '<form method="post" action="options.php">';
        settings_errors();
        // Output all tab headings
        echo '<h2 class="nav-tab-wrapper">';
        foreach ($this->tabs as $tab) {
            // Outbut Tabs
            if ($tab->active) {
                //echo $tab->get_anchor(true);
                echo wp_kses($tab->get_anchor(true), $my_allowed);
                // Cache active tab to reneder sections later
                $active_tab = $tab;
            } else {
                echo wp_kses($tab->get_anchor(true), $my_allowed);
            }
        }
        echo '</h2>';
        settings_fields($this->page->slug);
        do_settings_sections($this->page->slug);


        /*
    if ($active_tab_id <> 'startup_guide' and $active_tab_id <> 'memory_checkup' 
	and $active_tab_id <> 'anti_hacker' and $active_tab_id <> 'recaptcha' and $active_tab_id <> 'useful_tools')
       submit_button();
	   */


        //	submit_button();


        //echo '</form>';

        //	$this->render_reset_form( $active_tab );
        //  echo esc_attr($this->page->markup_bottom);
        //	 echo wp_kses($this->page->markup_bottom, $my_allowed);

        submit_button();
        echo '</form>';
        //  $this->render_reset_form( $active_tab ); 
        //echo '</div>'; //containerleft


        //if ($active_tab_id <> 'startup_guide' and $active_tab_id <> 'go_premium')
        //  require_once ("mybanners.inc");

        echo esc_html($this->page->markup_bottom);
    }
}
