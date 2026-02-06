<?php 
/***************************************
* Abort if called outside of WordPress
***************************************/
defined('ABSPATH') or die("Access Denied.");

if ( is_admin() ) {

    /******************************
    * Load backend functionality
    *******************************/
    function yada_wiki_admin() {  
    
	    // Only add buttons if editing a Yada Wiki post
	    if ( current_user_can('edit_posts') ) {  

	        // Snippet adapted from Ross McKay - http://snippets.webaware.com.au/snippets/wordpress-admin_init-hook-and-the-elusive-typenow/
	        global $typenow;

	        if ( empty($typenow) ) {
	            // try to pick it up from the query string
	            if ( !empty($_GET['post']) ) {
	                $post = get_post($_GET['post']);
	                $typenow = $post->post_type;
	                $typenow = sanitize_text_field( $typenow );
	            }
	            // try to pick it up from the quick edit AJAX post
	            elseif ( !empty($_POST['post_ID']) ) {
	                $post = get_post($_POST['post_ID']);
	                $typenow = $post->post_type;
	                $typenow = sanitize_text_field( $typenow );
	            }
	            // added by David McCan
	            elseif ( yada_wiki_is_edit_page('new') ) {
	                if(empty($_GET['post_type'])) {
	                    $typenow = "post";	
	                }
	                else {
	                    $type_test = sanitize_text_field( $_GET['post_type'] );
	                    $typenow = $type_test;
	                }
	            }
	        }		

	        $options = get_option( 'yada_wiki_settings' );
	        $yadaWikiEditorButtons = false;
	        
	        if ( isset($options['yada_wiki_checkbox_editor_buttons_setting']) ) {
	            $yadaWikiEditorButtons = true;
	        }    
			
			if (yada_wiki_is_edit_page() && ("yada_wiki" == $typenow || $yadaWikiEditorButtons == true)){
	            foreach ( array('post.php','post-new.php') as $hook ) {
	                add_action( "admin_footer-$hook", 'yw_admin_footer' );
	            }

	            wp_enqueue_style( "wp-jquery-ui-dialog" );
	            wp_enqueue_script( 'jquery' );
	            wp_enqueue_script( 'jquery-ui-core' );
	            wp_enqueue_script( 'jquery-ui-dialog' );
	            wp_enqueue_script( 'jquery-ui-button' );
	            wp_enqueue_script( 'jquery-ui-widget' );
	            wp_enqueue_script( 'jquery-ui-position' );
	            wp_enqueue_script( 'jquery-ui-autocomplete' );
	            
	            wp_enqueue_script( 'yadawiki-dialog', plugin_dir_url( __FILE__ ) . '../js/yadawiki-dialog.js', array( 'wpdialogs' ), '20150815' );
			    wp_localize_script('yadawiki-dialog', 'yw_ajax_object', array(
			        'ajax_url' => admin_url('admin-ajax.php'),
			        'security' => wp_create_nonce('ywcheck')
			    ));

	            add_filter( 'mce_external_plugins', 'yada_wiki_link_add_plugin' );  
	            add_filter( 'mce_external_plugins', 'yada_wiki_toc_add_plugin' );  
	            add_filter( 'mce_buttons', 'yada_wiki_link_register_button' );  
	            add_filter( 'mce_buttons', 'yada_wiki_toc_register_button' );  
	            
	            add_filter('wp_terms_checklist_args','yada_wiki_fix_cat_order');	        		
	        }
	    }
	} 

    /*****************************************************
    * Preserve the order of category terms in the editor
    *****************************************************/
    function yada_wiki_fix_cat_order($args) {
        $args['checked_ontop'] = false;
        return $args;
    }

    /******************************
    * Register buttons
    *******************************/
    function yada_wiki_link_register_button($buttons) {  
        array_push($buttons, "yada_wiki_link");  
        return $buttons;  
    } 
    function yada_wiki_toc_register_button($buttons) {  
        array_push($buttons, "yada_wiki_toc");  
        return $buttons;  
    } 

    /******************************
    * Load editor buttons
    *******************************/
    function yada_wiki_link_add_plugin($plugin_array) {  
        $plugin_array['yada_wiki_link'] = plugins_url( '../js/yadawiki-button-link.js', __FILE__ );
        return $plugin_array;     
    }  
        
    function yada_wiki_toc_add_plugin($plugin_array) {  
        $plugin_array['yada_wiki_toc'] = plugins_url( '../js/yadawiki-button-toc.js', __FILE__ );
        return $plugin_array;  	
    }  

    /***********************************************************************************************
    * Add the popup dialogs - Handling timyMCE popup using JQ-UI from:
    * http://jtmorris.net/2014/07/using-jquery-and-jquery-ui-in-tinymce-dialog-iframe/#comment-6290
    ************************************************************************************************/
    function yw_admin_footer() {
        include('yadawiki-dialog-link.php'); 
        include('yadawiki-dialog-toc.php'); 
    }
        
    function yada_wiki_suggest_callback() {
		check_ajax_referer( 'ywcheck', 'security' );		
    	
        global $wpdb;
        $sql = "";
        $searchInput = "";
        $thisPostType = "yada_wiki";
        $thisPostStatus = "publish";
        $reponse = array();
            
        if(!empty($_REQUEST['term'])){
            $searchInput =$_REQUEST['term'];
            // wpdb->prepare sanitizes strings
            $searchInput = "%".$searchInput."%";
            
            $sql = $wpdb->prepare(
                "
                    SELECT post_title
                    FROM $wpdb->posts
                    WHERE post_type = %s and
                        post_title like %s and
                        post_status = %s
                    ORDER BY post_title ASC
                ",
                array(
                    $thisPostType,
                    $searchInput,
                    $thisPostStatus
                )
            );
            $results = $wpdb->get_results($sql, ARRAY_A);
        }
        if($results) {
            foreach($results as $row) {
                $response[] = $row['post_title'];
            }
            header( "Content-Type: application/json" );
            echo json_encode($response);
        }
        wp_die();
    }
    
    /******************************
    * Sanitize shortcode input on save
    *******************************/
	function yada_wiki_process_shortcodes_on_save($post_id, $post, $update) {
	
		// Only run on standard post saves, not autosave or revision
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
		if ( wp_is_post_revision($post_id) ) return;
		
		// Do we need to filter the saving of posts and pages also?
		$options = get_option( 'yada_wiki_settings' );
		if ( isset($options['yada_wiki_checkbox_editor_buttons_setting']) ) {
			$allowShortcodeOnPostsAndPages = true;
		}
		else {
			$allowShortcodeOnPostsAndPages = false;
		}
		
		if ( $allowShortcodeOnPostsAndPages === true ) {
			if ( $post->post_type !== 'yada_wiki' && $post->post_type !== 'post'  && $post->post_type !== 'page' ) return;
		} else {
			if ( $post->post_type !== 'yada_wiki') return;
		}	
	
		// Prevent infinite loop
		remove_action('save_post', 'yada_wiki_process_shortcodes_on_save', 10);
	
		$content = $post->post_content;
		$content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5);
		$regex = get_shortcode_regex();
		$has_changes = false;
		$allowed_html = array(
			'em' => array(), // Allow <em> with no attributes
		);						
	
		if (preg_match_all('/' . $regex . '/s', $content, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				if (isset($match[2]) && $match[2] === 'yadawiki') {
					if (isset($match[3])) {
						$atts = shortcode_parse_atts($match[3]);
						// Proceed to process $atts
					} else {
						$atts = array();
						// Proceed, but there will be no matches
					}
					
					// Sanitize attributes
					$atts['link'] = isset($atts['link']) ? wp_kses($atts['link'], $allowed_html) : '';		
					$atts['show']   = isset($atts['show']) ? wp_kses($atts['show'], $allowed_html) : '';
					$atts['anchor'] = isset($atts['anchor']) ? sanitize_text_field($atts['anchor']) : '';
	
					// Rebuild the sanitized shortcode, always with double quotes for safety
					$sanitized = '[yadawiki';
					foreach ($atts as $key => $value) {
						if ($value !== '') {
							$sanitized .= " {$key}=\"" . esc_attr($value) . "\"";
						}
					}
					$sanitized .= ']';
	
					// Replace the original shortcode with sanitized version
					$content = str_replace($match[0], $sanitized, $content);
					$has_changes = true;
				} elseif (isset($match[2]) && $match[2] === 'yadawikitoc') {
					if (isset($match[3])) {
						$atts = shortcode_parse_atts($match[3]);
						// Proceed to process $atts
					} else {
						$atts = array();
						// Proceed, but there will be no matches
					}
	
					// Sanitize attributes
					$atts['show_toc'] = isset($atts['show_toc']) ? sanitize_text_field($atts['show_toc']) : '';
					$atts['category']   = isset($atts['category']) ? sanitize_text_field($atts['category']) : '';
					$atts['order'] = isset($atts['order']) ? sanitize_text_field($atts['order']) : '';
	
					// Rebuild the sanitized shortcode, always with double quotes for safety
					$sanitized = '[yadawikitoc';
					foreach ($atts as $key => $value) {
						if ($value !== '') {
							$sanitized .= " {$key}=\"" . esc_attr($value) . "\"";
						}
					}
					$sanitized .= ']';
	
					// Replace the original shortcode with sanitized version
					$content = str_replace($match[0], $sanitized, $content);
					$has_changes = true;
				}  elseif (isset($match[2]) && $match[2] === 'yadawiki-index') {
					if (isset($match[3])) {
						$atts = shortcode_parse_atts($match[3]);
						// Proceed to process $atts
					} else {
						$atts = array();
						// Proceed, but there will be no matches
					}
	
					// Sanitize attributes
					$atts['type'] = isset($atts['type']) ? sanitize_text_field($atts['type']) : '';
					$atts['columns'] = isset($atts['columns']) ? sanitize_text_field($atts['columns']) : '';
	
					// Rebuild the sanitized shortcode, always with double quotes for safety
					$sanitized = '[yadawiki-index';
					foreach ($atts as $key => $value) {
						if ($value !== '') {
							$sanitized .= " {$key}=\"" . esc_attr($value) . "\"";
						}
					}
					$sanitized .= ']';
	
					// Replace the original shortcode with sanitized version
					$content = str_replace($match[0], $sanitized, $content);
					$has_changes = true;
				}
			}
		}
	
		if ($has_changes) {
			wp_update_post([
				'ID' => $post_id,
				'post_content' => $content
			]);
		}
	
		// Re-add the hook
		add_action('save_post', 'yada_wiki_process_shortcodes_on_save', 10, 3);
	}

    /********************************************************
    * Funciton from Ohad Raz - https://en.bainternet.info/
    ********************************************************/
    function yada_wiki_is_edit_page($new_edit = null){
        global $pagenow;
        
        if (!is_admin()) return false;

        if($new_edit == "edit")
            return in_array( $pagenow, array( 'post.php',  ) );
        elseif($new_edit == "new") //check for new post page
            return in_array( $pagenow, array( 'post-new.php' ) );
        else //check for either new or edit
            return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
    }
}

