<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "kk-like-options";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();
    
    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    // $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => 'KK I Like It 2',
        // Name that appears at the top of your panel
        'display_version'      => '',
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => 'KK I Like It 2',
        'page_title'           => 'KK I Like It 2',
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'kk-i-like-it-2',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // TODO: ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    // $args['admin_bar_links'][] = array(
    //     'id'    => 'redux-docs',
    //     'href'  => 'http://docs.reduxframework.com/',
    //     'title' => __( 'Documentation', 'kk-i-like-it' ),
    // );

    // $args['admin_bar_links'][] = array(
    //     //'id'    => 'redux-support',
    //     'href'  => 'https://github.com/ReduxFramework/redux-framework/issues',
    //     'title' => __( 'Support', 'kk-i-like-it' ),
    // );

    // $args['admin_bar_links'][] = array(
    //     'id'    => 'redux-extensions',
    //     'href'  => 'reduxframework.com/extensions',
    //     'title' => __( 'Extensions', 'kk-i-like-it' ),
    // );

    // TODO: SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    // $args['share_icons'][] = array(
    //     'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
    //     'title' => 'Visit us on GitHub',
    //     'icon'  => 'el el-github'
    //     //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    // );
    // $args['share_icons'][] = array(
    //     'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
    //     'title' => 'Like us on Facebook',
    //     'icon'  => 'el el-facebook'
    // );
    // $args['share_icons'][] = array(
    //     'url'   => 'http://twitter.com/reduxframework',
    //     'title' => 'Follow us on Twitter',
    //     'icon'  => 'el el-twitter'
    // );
    // $args['share_icons'][] = array(
    //     'url'   => 'http://www.linkedin.com/company/redux-framework',
    //     'title' => 'Find us on LinkedIn',
    //     'icon'  => 'el el-linkedin'
    // );

    // Panel Intro text -> before the form
    // if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
    //     if ( ! empty( $args['global_variable'] ) ) {
    //         $v = $args['global_variable'];
    //     } else {
    //         $v = str_replace( '-', '_', $args['opt_name'] );
    //     }
    //     $args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'kk-i-like-it' ), $v );
    // } else {
    //     $args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'kk-i-like-it' );
    // }

    // Add content after the form.
    // $args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'kk-i-like-it' );

    $args['footer_credit'] = ' ';

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'kk-i-like-it' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'kk-i-like-it' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'kk-i-like-it' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'kk-i-like-it' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'kk-i-like-it' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Button settings', 'kk-i-like-it' ),
        'id'               => 'button-settings',
        'desc'             => __( 'These are really basic fields!', 'kk-i-like-it' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-brush'
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Button design', 'kk-i-like-it' ),
        'id'               => 'button-settings-design',
        'subsection'       => true,
        'customizer_width' => '450px',
        'desc'             => '',
        'fields'           => array(
            array(
                'id'       => 'kklike-like-text',
                'type'     => 'text',
                'title'    => __( 'Like text', 'kk-i-like-it' ),
                'default'  => 'I Like It!',
            ),
            array(
                'id'       => 'kklike-unlike-text',
                'type'     => 'text',
                'title'    => __( 'Unlike text', 'kk-i-like-it' ),
                'default'  => 'Unlike',
            ),
            array(
                'id'       => 'kklike-show-like-number',
                'type'     => 'button_set',
                'title'    => __( 'Show numer of likes', 'kk-i-like-it' ),
                'options'  => array(
                    '1' => __('Always', 'kk-i-like-it'),
                    '2' => __('Never', 'kk-i-like-it'),
                    '3' => __('Hovering cursore over the button', 'kk-i-like-it')
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'kklike-own-button-style',
                'type'     => 'switch',
                'title'    => __( 'Own button style', 'kk-i-like-it' ),
                'default'  => 0,
                'off'      => __( 'No', 'kk-i-like-it' ),
                'on'       => __( 'Yes', 'kk-i-like-it' ),
            ),
            array(
                'id'       => 'kklike-button-type',
                'type'     => 'image_select',
                'required' => array( 'kklike-own-button-style', '=', '0' ),
                'title'    => __( 'Button design', 'kk-i-like-it' ),
                'options'  => array(
                    'light' => array(
                        'title' => 'Light',
                        'alt' => 'Light',
                        'img' => plugin_dir_url( __FILE__ ) . 'admin/img/light-small.png',
                    ),
                    'dark' => array(
                        'title' => 'Dark',
                        'alt' => 'Dark',
                        'img' => plugin_dir_url( __FILE__ ) . 'admin/img/dark-small.png'
                    ),
                ),
                'default'  => 'light'
            ),
            array(
                'id'       => 'kklike-button-size',
                'type'     => 'button_set',
                'title'    => __( 'Button size', 'kk-i-like-it' ),
                'options'  => array(
                    'kk-i-like-it__size-small' => __('Small', 'kk-i-like-it'),
                    'kk-i-like-it__size-default' => __('Default', 'kk-i-like-it'),
                    'kk-i-like-it__size-big' => __('Big', 'kk-i-like-it')
                ),
                'default'  => 'kklike-size-default'
            ),
            array(
                'id'       => 'kklike-own-button-bg-color',
                'type'     => 'color',
                'required' => array( 'kklike-own-button-style', '=', '1' ),
                'title'    => __('Background Color', 'kk-i-like-it'),
                'default'  => '#FFFFFF',
                'validate' => 'color',
                'compiler' => array('.kk-i-like-it__box button'),
                'mode' => 'background-color',
            ),
            array(
                'id'       => 'kklike-own-button-text-color',
                'type'     => 'color',
                'required' => array( 'kklike-own-button-style', '=', '1' ),
                'title'    => __('Text Color', 'kk-i-like-it'),
                'default'  => '#666666',
                'validate' => 'color',
                'compiler' => array('.kk-i-like-it__box button'),
                'mode' => 'color',
            ),
            array(
                'id'       => 'kklike-own-button-border-color',
                'type'     => 'color',
                'required' => array( 'kklike-own-button-style', '=', '1' ),
                'title'    => __('Border Color', 'kk-i-like-it'),
                'default'  => '#666666',
                'validate' => 'color',
                'compiler' => array('.kk-i-like-it__box button'),
                'mode' => 'border-color',
            ),
            array(
                'id'        => 'kklike-own-button-border-size',
                'type'      => 'slider',
                'required' => array( 'kklike-own-button-style', '=', '1' ),
                'title'     => __('Border size', 'kk-i-like-it'),
                "default"   => 1,
                "min"       => 1,
                "step"      => 1,
                "max"       => 5,
                'display_value' => 'label',
                'compiler' => array('.kk-i-like-it__box button'),
                'mode' => 'border-width',
            ),
            array(
                'id'        => 'kklike-own-button-font-size',
                'type'      => 'slider',
                'required' => array( 'kklike-own-button-style', '=', '1' ),
                'title'     => __('Font size', 'kk-i-like-it'),
                "default"   => 14,
                "min"       => 10,
                "step"      => 1,
                "max"       => 20,
                'display_value' => 'label',
                'compiler' => array('.kk-i-like-it__box button'),
                'mode' => 'font-size',
            ),
            array(
                'id'        => 'kklike-own-button-round-corners',
                'type'      => 'slider',
                'required' => array( 'kklike-own-button-style', '=', '1' ),
                'title'     => __('Round corners', 'kk-i-like-it'),
                "default"   => 4,
                "min"       => 0,
                "step"      => 1,
                "max"       => 30,
                'display_value' => 'label',
                'compiler' => array('.kk-i-like-it__box button'),
                'mode' => 'border-radius',
            ),
            array(
                'id'       => 'kklike-own-button-icon',
                'type'     => 'radio',
                'required' => array( 'kklike-own-button-style', '=', '1' ),
                'title'    => __('Button icon', 'kk-i-like-it'), 
                //Must provide key => value pairs for radio options
                'options'  => array(
                    '1' => '<svg class="icon icon-heart2" viewBox="0 0 28 28" width="28" height="28">
                                <path d="M14 26c-0.25 0-0.5-0.094-0.688-0.281l-9.75-9.406c-0.125-0.109-3.563-3.25-3.563-7 0-4.578 2.797-7.313 7.469-7.313 2.734 0 5.297 2.156 6.531 3.375 1.234-1.219 3.797-3.375 6.531-3.375 4.672 0 7.469 2.734 7.469 7.313 0 3.75-3.437 6.891-3.578 7.031l-9.734 9.375c-0.187 0.187-0.438 0.281-0.688 0.281z"></path>
                            </svg>',
                ),
                'default' => '1'
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Display settings', 'kk-i-like-it' ),
        'id'               => 'button-settings-display',
        'subsection'       => true,
        'customizer_width' => '450px',
        'desc'             => '',
        'fields'           => array(
            array(
                'id'       => 'kklike-where-display',
                'type'     => 'button_set',
                'title'    => __( 'Where display button', 'kk-i-like-it' ),
                'options'  => array(
                    '1' => __('Post', 'kk-i-like-it'),
                    '2' => __('Page', 'kk-i-like-it'),
                    '3' => __('Post & Page', 'kk-i-like-it')
                ),
                'default'  => '3'
            ),
            array(
                'id'       => 'kklike-button-position',
                'type'     => 'image_select',
                'title'    => __( 'Button position', 'kk-i-like-it' ),
                'options'  => array(
                    '1' => array(
                        'title' => 'Top Left',
                        'alt' => 'Top Left',
                        'img' => plugin_dir_url( __FILE__ ) . 'admin/img/positions/top-left.jpg'
                    ),
                    '2' => array(
                        'title' => 'Top Right',
                        'alt' => 'Top Right',
                        'img' => plugin_dir_url( __FILE__ ) . 'admin/img/positions/top-right.jpg'
                    ),
                    '3' => array(
                        'title' => 'Bottom Left',
                        'alt' => 'Bottom Left',
                        'img' => plugin_dir_url( __FILE__ ) . 'admin/img/positions/bottom-left.jpg'
                    ),
                    '4' => array(
                        'title' => 'Bottom Right',
                        'alt' => 'Bottom Right',
                        'img' => plugin_dir_url( __FILE__ ) . 'admin/img/positions/bottom-right.jpg'
                    ),
                    '5' => array(
                        'title' => 'Own Position',
                        'alt' => 'Own Position',
                        'img' => plugin_dir_url( __FILE__ ) . 'admin/img/positions/own-position.jpg'
                    ),
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'kklike-show-on-post-list',
                'type'     => 'button_set',
                'title'    => __( 'Show button on post list', 'kk-i-like-it' ),
                'options'  => array(
                    '1' => __('No'),
                    '2' => __('Yes'),
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'kklike-only-users',
                'type'     => 'button_set',
                'title'    => __( 'Only users can vote', 'kk-i-like-it' ),
                'options'  => array(
                    '1' => __('No'),
                    '2' => __('Yes'),
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'kklike-show-button-guest',
                'type'     => 'button_set',
                'title'    => __( 'Should a button be shown to guests', 'kk-i-like-it' ),
                'options'  => array(
                    '1' => __('No'),
                    '2' => __('Yes'),
                ),
                'default'  => '1'
            ),
        )
    ) );

    
    Redux::setSection( $opt_name, array(
        'title'            => __( 'WP Dashboard', 'kk-i-like-it' ),
        'id'               => 'wp-dashboard',
        // 'desc'             => __( 'These are really basic fields!', 'kk-i-like-it' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-screen',
        'fields'           => array(
            array(
                'id'       => 'kklike-show-recent-liked',
                'type'     => 'button_set',
                'title'    => __( 'Show Recent Liked widget', 'kk-i-like-it' ),
                'options'  => array(
                    '1' => __('No'),
                    '2' => __('Yes'),
                ),
                'default'  => '2'
            ),
            array(
                'id'       => 'kklike-show-top-liked',
                'type'     => 'button_set',
                'title'    => __( 'Show Top Liked widget', 'kk-i-like-it' ),
                'options'  => array(
                    '1' => __('No'),
                    '2' => __('Yes'),
                ),
                'default'  => '2'
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Voters preview', 'kk-i-like-it' ),
        'id'               => 'voters-preview',
        'customizer_width' => '400px',
        'icon'             => 'el el-list-alt',
        'fields'           => array(
            array(
                'id'       => 'kklike-show-voters-section',
                'type'     => 'button_set',
                'title'    => __( 'Show voters section', 'kk-i-like-it' ),
                // 'desc'     => __( 'Sekcja z listą głosujących pojawi się za treścią wpisu lub strony', 'kk-i-like-it' ),
                'options'  => array(
                    '1' => __('No'),
                    '2' => __('Yes'),
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'kklike-voters-header',
                'type'     => 'text',
                'title'    => __( 'Voters Section Header Text', 'kk-i-like-it' ),
                'default'  => '',
            ),
            array(
                'id'       => 'kklike-show-voters-names',
                'type'     => 'button_set',
                'title'    => __( 'Show voters names', 'kk-i-like-it' ),
                'options'  => array(
                    '1' => __('No'),
                    '2' => __('Yes'),
                ),
                'default'  => '1'
            ),
            array(
                'id'            => 'kklike-avatar-size',
                'type'          => 'slider',
                'title'         => __( 'Avatar size (in pixels)', 'kk-i-like-it' ),
                'default'       => 50,
                'min'           => 40,
                'step'          => 5,
                'max'           => 150,
                'display_value' => 'text'
            ),
        )
    ) );

    if ( file_exists( dirname( __FILE__ ) . '/README.md' ) ) {
        $section = array(
            'icon'   => 'el el-list-alt',
            'title'  => __( 'Documentation', 'kk-i-like-it' ),
            'fields' => array(
                array(
                    'id'       => '17',
                    'type'     => 'raw',
                    'markdown' => true,
                    'content_path' => dirname( __FILE__ ) . '/../README.md', // FULL PATH, not relative please
                    //'content' => 'Raw content here',
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            global $wp_filesystem;

            // echo '<h1>The compiler hook has run!</h1>';
     
            // print_r ($options);
            // print_r ($css);
            // print_r ($changed_values);

            $filename = dirname(__FILE__) . '/public/css/generate-style.css';
        
            if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
                WP_Filesystem();
            }
        
            if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
            }
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'kk-i-like-it' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'kk-i-like-it' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

