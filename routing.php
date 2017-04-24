<?php

if (!class_exists('csm_permalink')) {
    class csm_permalink {

        function __construct(){
            // demo shortcode
            add_shortcode('csmpermalink', array(&$this,'csm_permalink_demo_shortcode'));

            // permalink hooks:
            add_filter('generate_rewrite_rules', array(&$this,'csm_permalink_rewrite_rule'));
            add_filter('query_vars', array(&$this,'csm_permalink_query_vars'));
            add_filter('admin_init', array(&$this, 'csm_permalink_flush_rewrite_rules'));
            add_action("parse_request", array(&$this,"csm_permalink_parse_request"));
        }

        /**************************************************************************
         * Demo shortcode
         * A simple shortcode used to demonstrate the plugin.
         *
         * @see http://codex.wordpress.org/Shortcode_API
         * @param array $atts shortcode parameters
         * @return string URL to demonstrate custom permalink
         **************************************************************************/
        function csm_permalink_demo_shortcode($atts) {
            extract(shortcode_atts(array(
                // default values
                'csm'       =>   'login'
            ), $atts));
            return sprintf('<a href="%s">My permalink</a>',$this->csm_permalink_url($val));
        }

        /**************************************************************************
         * Create your URL
         * If the blog has a permalink structure, a permalink is returned. Otherwise
         * a standard URL with param=val.
         *
         * @param sting $val Parameter to custom url
         * @return string URL
         **************************************************************************/
        function csm_permalink_url($val) {
            if ( get_option('permalink_structure')) { // check if the blog has a permalink structure
                return sprintf("%s/csm/%s",home_url(),$val);
            } else {
                return sprintf("%s/index.php?csm=%s",home_url(),$val);
            }
        }

        /**************************************************************************
         * Add your rewrite rule.
         * The rewrite rules array is an associative array with permalink URLs as regular
         * expressions (regex) keys, and the corresponding non-permalink-style URLs as values
         * For the rule to take effect, For the rule to take effect, flush the rewrite cache,
         * either by re-saving permalinks in Settings->Permalinks, or running the
         * csm_permalink_flush_rewrite_rules() method below.
         *
         * @see http://codex.wordpress.org/Custom_Queries#Permalinks_for_Custom_Archives
         * @param object $wp_rewrite
         * @return array New permalink structure
         **************************************************************************/
        function csm_permalink_rewrite_rule( $wp_rewrite ) {
            $new_rules = array(
                'csm/(.*)$' => sprintf("index.php?csm=%s",$wp_rewrite->preg_index(1))
                /*
                // a more complex permalink:
                'csm/([^/]+)/([^.]+).html$' => sprintf("index.php?csm_permalink_variable_01=%s&csm_permalink_variable_02=%s",$wp_rewrite->preg_index(1),$wp_rewrite->preg_index(2))
                */
            );

            $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
            return $wp_rewrite->rules;
        }

        /**************************************************************************
         * Add your custom query variables.
         * To make sure that our parameter value(s) gets saved,when WordPress parse the URL,
         * we have to add our variable(s) to the list of query variables WordPress
         * understands (query_vars filter)
         *
         * @see http://codex.wordpress.org/Custom_Queries
         * @param array $query_vars
         * @return array $query_vars with custom query variables
         **************************************************************************/
        function csm_permalink_query_vars( $query_vars ) {
            $query_vars[] = 'csm';
            /*
            // need more variables?:
            $query_vars[] = 'csm_permalink_variable_02';
            $query_vars[] = 'csm_permalink_variable_03';
            */
            return $query_vars;
        }

        /**************************************************************************
         * Parses a URL into a query specification
         * This is where you should add your code.
         *
         * @see http://codex.wordpress.org/Query_Overview
         * @param array $atts shortcode parameters
         * @return string URL to demonstrate custom permalink
         **************************************************************************/
        function csm_permalink_parse_request($wp_query) {
            if (isset($wp_query->query_vars['csm'])) { // same as the first custom variable in csm_permalink_query_vars( $query_vars )
                // add your code here, code below is for this demo

                $page_value = $wp_query->query_vars['csm'];

                if ($page_value && $page_value == "login") {
                    include(plugin_dir_path(__FILE__).'app/frontend/login.php');
                }
                if ($page_value && $page_value == "member") {
                    include(plugin_dir_path(__FILE__).'app/frontend/member.php');
                }
                if ($page_value && $page_value == "memberships") {
                    include(plugin_dir_path(__FILE__).'app/frontend/memberships.php');
                }
                if ($page_value && $page_value == "membership-add") {
                    include(plugin_dir_path(__FILE__).'app/frontend/membership-add.php');
                }

//                printf("<pre>%s</pre>",print_r($wp_query->query_vars,true));
                exit(0);
            }
        }

        /**************************************************************************
         * Flushes the permalink structure.
         * flush_rules is an extremely costly function in terms of performance, and
         * should only be run when changing the rule.
         *
         * @see http://codex.wordpress.org/Rewrite_API/flush_rules
         **************************************************************************/
        function csm_permalink_flush_rewrite_rules() {
            $rules = $GLOBALS['wp_rewrite']->wp_rewrite_rules();
            if ( ! isset( $rules['csm/(.*)$'] ) ) { // must be the same rule as in csm_permalink_rewrite_rule($wp_rewrite)
                global $wp_rewrite;
                $wp_rewrite->flush_rules();
            }
        }
    } //End Class
} //End if class exists statement

if (class_exists('csm_permalink')) {
    $csm_permalink_var = new csm_permalink();
}
?>