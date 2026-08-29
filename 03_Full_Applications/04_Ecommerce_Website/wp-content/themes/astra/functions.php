<?php
/**
 * Astra functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Define Constants
 */
define( 'ASTRA_THEME_VERSION', '3.9.4' );
define( 'ASTRA_THEME_SETTINGS', 'astra-settings' );
define( 'ASTRA_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'ASTRA_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );
define( 'ASTRA_PRO_UPGRADE_URL', 'https://wpastra.com/pro/' );

/**
 * Minimum Version requirement of the Astra Pro addon.
 * This constant will be used to display the notice asking user to update the Astra addon to the version defined below.
 */
define( 'ASTRA_EXT_MIN_VER', '3.9.2' );

/**
 * Setup helper functions of Astra.
 */
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-theme-options.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-theme-strings.php';
require_once ASTRA_THEME_DIR . 'inc/core/common-functions.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-icons.php';

/**
 * Update theme
 */
require_once ASTRA_THEME_DIR . 'inc/theme-update/astra-update-functions.php';
require_once ASTRA_THEME_DIR . 'inc/theme-update/class-astra-theme-background-updater.php';

/**
 * Fonts Files
 */
require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-font-families.php';
if ( is_admin() ) {
	require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-fonts-data.php';
}

require_once ASTRA_THEME_DIR . 'inc/lib/webfont/class-astra-webfont-loader.php';
require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-fonts.php';

require_once ASTRA_THEME_DIR . 'inc/dynamic-css/custom-menu-old-header.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/container-layouts.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/astra-icons.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-walker-page.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-enqueue-scripts.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-gutenberg-editor-css.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-wp-editor-css.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/block-editor-compatibility.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/inline-on-mobile.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/content-background.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-dynamic-css.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-global-palette.php';

/**
 * Custom template tags for this theme.
 */
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-attr.php';
require_once ASTRA_THEME_DIR . 'inc/template-tags.php';

require_once ASTRA_THEME_DIR . 'inc/widgets.php';
require_once ASTRA_THEME_DIR . 'inc/core/theme-hooks.php';
require_once ASTRA_THEME_DIR . 'inc/admin-functions.php';
require_once ASTRA_THEME_DIR . 'inc/core/sidebar-manager.php';

/**
 * Markup Functions
 */
require_once ASTRA_THEME_DIR . 'inc/markup-extras.php';
require_once ASTRA_THEME_DIR . 'inc/extras.php';
require_once ASTRA_THEME_DIR . 'inc/blog/blog-config.php';
require_once ASTRA_THEME_DIR . 'inc/blog/blog.php';
require_once ASTRA_THEME_DIR . 'inc/blog/single-blog.php';

/**
 * Markup Files
 */
require_once ASTRA_THEME_DIR . 'inc/template-parts.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-loop.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-mobile-header.php';

/**
 * Functions and definitions.
 */
require_once ASTRA_THEME_DIR . 'inc/class-astra-after-setup-theme.php';

// Required files.
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-admin-helper.php';

require_once ASTRA_THEME_DIR . 'inc/schema/class-astra-schema.php';

if ( is_admin() ) {
	/**
	 * Admin Menu Settings
	 */
	require_once ASTRA_THEME_DIR . 'inc/core/class-astra-admin-settings.php';
	require_once ASTRA_THEME_DIR . 'inc/lib/astra-notices/class-astra-notices.php';
}

/**
 * Metabox additions.
 */
require_once ASTRA_THEME_DIR . 'inc/metabox/class-astra-meta-boxes.php';

require_once ASTRA_THEME_DIR . 'inc/metabox/class-astra-meta-box-operations.php';

/**
 * Customizer additions.
 */
require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-customizer.php';

/**
 * Astra Modules.
 */
require_once ASTRA_THEME_DIR . 'inc/modules/related-posts/class-astra-related-posts.php';

/**
 * Compatibility
 */
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-gutenberg.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-jetpack.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/woocommerce/class-astra-woocommerce.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/edd/class-astra-edd.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/lifterlms/class-astra-lifterlms.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/learndash/class-astra-learndash.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-beaver-builder.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-bb-ultimate-addon.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-contact-form-7.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-visual-composer.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-site-origin.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-gravity-forms.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-bne-flyout.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-ubermeu.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-divi-builder.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-amp.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-yoast-seo.php';
require_once ASTRA_THEME_DIR . 'inc/addons/transparent-header/class-astra-ext-transparent-header.php';
require_once ASTRA_THEME_DIR . 'inc/addons/breadcrumbs/class-astra-breadcrumbs.php';
require_once ASTRA_THEME_DIR . 'inc/addons/heading-colors/class-astra-heading-colors.php';
require_once ASTRA_THEME_DIR . 'inc/builder/class-astra-builder-loader.php';

// Elementor Compatibility requires PHP 5.4 for namespaces.
if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-elementor.php';
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-elementor-pro.php';
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-web-stories.php';
}

// Beaver Themer compatibility requires PHP 5.3 for anonymus functions.
if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-beaver-themer.php';
}

require_once ASTRA_THEME_DIR . 'inc/core/markup/class-astra-markup.php';

/**
 * Load deprecated functions
 */
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-filters.php';
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-hooks.php';
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-functions.php';


function wooc_extra_register_fields() {?>
	<p class="form-row form-row-wide">
		<label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
		<input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" />
	</p>
	<p class="form-row form-row-first">
		<label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
	</p>
	<p class="form-row form-row-last">
		<label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
	</p>
	<p class="form-row form-row-wide">
		<label for="reg_account_age"><?php _e( 'Age', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="number" class="input-text" name="account_age" id="reg_account_age" value="<?php if ( ! empty( $_POST['account_age'] ) ) esc_attr_e( $_POST['account_age'] ); ?>" />
	</p>
	<div class="clear"></div>


	<?php

	woocommerce_form_field('the_country_field', array(
	'type'       => 'select',
	'name'       => 'billing_country',
	'class'      => array('njengah-dropdown'),
	'label'      => __('Country'),
	'placeholder'    => __('Enter something'),
	'options'     => array(
			'JO' => 'الأردن',
			'KW' => 'الكويت',
			'SA'   => 'السعودية',
			'AE' => 'الإمارات',
			'BH' => 'البحرين',
	),
	'required' => true,
	)
	);

	woocommerce_form_field('the_gender_field', array(
		'type'       => 'select',
		'name'       => 'the_gender_field',
		'class'      => array('njengah-dropdown'),
		'label'      => __('Gender'),
		'placeholder'    => __('Enter something'),
		'options'     => array(
				'ذكر' => 'ذكر',
				'أنثى' => 'أنثى',
		),
		'required' => true,
		)
		);
}
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );

/**
* register fields Validating.
*/
function wooc_validate_extra_register_fields($username, $email, $validation_errors) {
	if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
		   $validation_errors->add( 'billing_first_name_error', __( 'First name is required!', 'woocommerce' ) );
	}
	if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
		   $validation_errors->add( 'billing_last_name_error', __( 'Last name is required!.', 'woocommerce' ) );
	}
	if ( isset( $_POST['account_age'] ) && empty( $_POST['account_age'] ) ) {
		$validation_errors->add( 'account_age_error', __( 'Age is required!.', 'woocommerce' ) );
 	}
	 if ( isset( $_POST['billing_country'] ) ) {
        $domain = 'woocommerce';
        $my_field_name = $_POST['billing_country'];
        
        // Empty
        if ( empty ( $my_field_name ) ) {
			$validation_errors->add( 'country_error', __( 'Country is required!.', 'woocommerce' ) );
        }
		
    }

	
	   return $validation_errors;
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );

/**
* Below code save extra fields.
*/
function wooc_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['billing_phone'] ) ) {
		// Phone input filed which is used in WooCommerce
		update_user_meta( $customer_id, 'phone', sanitize_text_field( $_POST['billing_phone'] ) );
    }
	if ( isset( $_POST['billing_first_name'] ) ) {
		//First name field which is by default
		update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
		// First name field which is used in WooCommerce
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	}
	if ( isset( $_POST['billing_last_name'] ) ) {
		// Last name field which is by default
		update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
		// Last name field which is used in WooCommerce
		update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
	}
	if ( isset( $_POST['account_age'] ) ) {
		// Phone input filed which is used in WooCommerce
		update_user_meta( $customer_id, 'age', sanitize_text_field( $_POST['account_age'] ) );
    }
	if ( isset( $_POST['the_country_field'] ) ) {
		// Phone input filed which is used in WooCommerce
		update_user_meta( $customer_id, 'country', sanitize_text_field( $_POST['the_country_field'] ) );
    }
	if ( isset( $_POST['the_gender_field'] ) ) {
		// Phone input filed which is used in WooCommerce
		update_user_meta( $customer_id, 'gender', sanitize_text_field( $_POST['the_gender_field'] ) );
    }
	# add data to table
	
	// global $wpdb;

	// $phone = $_POST['billing_phone'];
	// $first_name = $_POST['billing_first_name'];
	// $last_name = $_POST['billing_last_name'];
	// $age = $_POST['account_age'];
	// $country = $_POST['the_country_field'];
	// $gender = $_POST['the_gender_field'];

	// $table_name = $wpdb->prefix . 'user_information';

	// $wpdb->insert( 
	// 	$table_name, 
	// 	array( 
	// 		'phone' => $phone,
	// 		'first_name' => $first_name, 
	// 		'last_name' => $last_name,
	// 		'age' => $age,
	// 		'country' => $country,
	// 		'user_id' => $customer_id,
	// 		'gender' => $gender,
	// 	) 
	// );
	
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

// Find a randomDate between $start_date and $end_date

function randomDate($start_date, $end_date)
{
	// Convert to timetamps
	$min = strtotime($start_date);
	$max = strtotime($end_date);

	// Generate random number using above bounds
	$val = rand($min, $max);

	// Convert back to desired date format
	return date('Y-m-d H:i:s', $val);
}

# add users to users table --------------------------------------------------------------------------------------------------------

// add user firstname, lastname, email ...
function first_name() {
	$firstname = array(
		'Johnathon', 'Anthony', 'Erasmo', 'Raleigh', 'Nancie', 'Tama', 'Camellia', 'Augustine', 'Christeen', 'Luz', 'Diego',
		'Lyndia', 'Thomas', 'Georgianna', 'Leigha', 'Alejandro', 'Marquis', 'Joan', 'Stephania', 'Elroy', 'Zonia', 'Buffy',
		'Sharie', 'Blythe', 'Gaylene', 'Elida', 'Randy', 'Margarete', 'Margarett', 'Dion', 'Tomi', 'Arden', 'Clora', 'Laine',
		'Becki', 'Margherita', 'Bong', 'Jeanice', 'Qiana', 'Lawanda', 'Rebecka', 'Maribel', 'Tami', 'Yuri', 'Michele', 'Rubi',
		'Larisa', 'Lloyd', 'Tyisha', 'Samatha',
	);

	$name = $firstname[rand ( 0 , count($firstname) -1)];

	return $name;
}
function last_name() {
	$lastname = array(
		'Mischke', 'Serna', 'Pingree', 'Mcnaught', 'Pepper', 'Schildgen', 'Mongold', 'Wrona', 'Geddes', 'Lanz', 'Fetzer',
		'Schroeder', 'Block', 'Mayoral', 'Fleishman', 'Roberie', 'Latson', 'Lupo', 'Motsinger', 'Drews', 'Coby', 'Redner',
		'Culton', 'Howe', 'Stoval', 'Michaud', 'Mote', 'Menjivar', 'Wiers', 'Paris', 'Grisby', 'Noren', 'Damron', 'Kazmierczak',
		'Haslett', 'Guillemette', 'Buresh', 'Center', 'Kucera', 'Catt', 'Badon', 'Grumbles', 'Antes', 'Byron', 'Volkman', 'Klemp',
		'Pekar', 'Pecora', 'Schewe', 'Ramage',
	);

	$name = $lastname[rand ( 0 , count($lastname) -1)];

	return $name;
}

function add_users_data() {
	$user_pass = array();
	$user_login = array();
	$user_nicename = array();
	$user_email = array();
	$display_name = array();
	$nickname = array();
	$first_name = array();
	$last_name = array();
	$rich_editing = array();
	$syntax_highlighting = array();
	$comment_shortcuts = array();
	$admin_color = array();
	$use_ssl = array();
	$user_registered = array();
	$show_admin_bar_front = array();
	$country = array();
	$age = array();
	$gender = array();


	// add user passwords
	for ($x = 0; $x < 1500; $x++) {
		array_push($user_pass, "password");
	}

	for ($x = 0; $x < 1500; $x++) {
		$random_first_name = last_name(). strval($x);
		array_push($first_name, $random_first_name);
		array_push($last_name, first_name());
		array_push($user_login, $random_first_name);
		array_push($user_nicename, $random_first_name);
		array_push($display_name, $random_first_name);
		array_push($nickname, $random_first_name);
		array_push($user_email, $random_first_name . '@gmail.com');
	}

	// add rich_editing, syntax_highlighting, comment_shortcuts, admin_color, use_ssl, show_admin_bar_front
	for ($x = 0; $x < 1500; $x++) {
		array_push($rich_editing, 'true');
		array_push($syntax_highlighting, 'true');
		array_push($comment_shortcuts, 'false');
		array_push($admin_color, 'fresh');
		array_push($use_ssl, '0');
		array_push($show_admin_bar_front, 'true');
	}

	// add user_registered


	$start_date = '1/1/2018 1:30:45';
	$end_date = '1/12/2022 4:50:50';
	for ($x = 0; $x < 1500; $x++) {
		array_push($user_registered, randomDate($start_date, $end_date));
	}

	// add countries
	$countries = array('JO', 'BH', 'SA', 'AE', 'KW');
	for ($x = 0; $x < 1500; $x++) {
		$random_country = $countries[rand ( 0 , count($countries) -1)];
		array_push($country, $random_country);
	}

	// add gender
	$genders = array('ذكر', 'انثى');
	for ($x = 0; $x < 1500; $x++) {
		$random_gender = $genders[rand ( 0 , count($genders) -1)];
		array_push($gender, $random_gender);
	}

	// add age
	for ($x = 0; $x < 1500; $x++) {
		array_push($age, rand(18, 55));
	}


	for ($x = 0; $x < 140; $x++) {
		// add to database
		$userdata = array(
			'user_pass'				=> $user_pass[$x], 	//(string) The plain-text user password.
			'user_login' 			=> $user_login[$x], 	//(string) The user's login username.
			'user_nicename' 		=> $user_nicename[$x], 	//(string) The URL-friendly user name.
			'user_email' 			=> $user_email[$x], 	//(string) The user email address.
			'display_name' 			=> $display_name[$x], 	//(string) The user's display name. Default is the user's username.
			'nickname' 				=> $nickname[$x], 	//(string) The user's nickname. Default is the user's username.
			'first_name' 			=> $first_name[$x], 	//(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
			'last_name' 			=> $last_name[$x], 	//(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
			'rich_editing' 			=> $rich_editing[$x], 	//(string|bool) Whether to enable the rich-editor for the user. False if not empty.
			'syntax_highlighting' 	=> $syntax_highlighting[$x], 	//(string|bool) Whether to enable the rich code editor for the user. False if not empty.
			'comment_shortcuts' 	=> $comment_shortcuts[$x], 	//(string|bool) Whether to enable comment moderation keyboard shortcuts for the user. Default false.
			'admin_color' 			=> $admin_color[$x], 	//(string) Admin color scheme for the user. Default 'fresh'.
			'use_ssl' 				=> $use_ssl[$x], 	//(bool) Whether the user should always access the admin over https. Default false.
			'user_registered' 		=> $user_registered[$x], 	//(string) Date the user registered. Format is 'Y-m-d H:i:s'.
			'show_admin_bar_front' 	=> $show_admin_bar_front[$x], 	//(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
			'locale' 				=> '', 	//(string) User's locale. Default empty.
			'country'				=> $country[$x],
			'age'					=> $age[$x],
			'gender'				=> $gender[$x],
		);
		$user = wp_insert_user($userdata);
		#var_dump($userdata);
		#var_dump(count($userdata));
	}
}
add_action( 'init', 'my_run_only_once_user' );
function my_run_only_once_user() {
    if ( did_action( 'init' ) >= 2 )
        return;

    if( ! get_option('run_add_products_once_user72') ) {
		add_option( 'run_add_products_once_user72', true );
        add_users_data(); // Run the function
    }
}


#unnecessary -----------------------------------
require_once( ABSPATH . '/wp-admin/includes/taxonomy.php');
function add_categories() { 
	//Define the category
	$wpdocs_cat = array('cat_name' => 'أحذية', 'category_description' => 'جميع أنواع الأحذية النسائية والرجالية', 'category_nicename' => 'shoes', 'category_parent' => '');

	// Create the category
	$wpdocs_cat_id = wp_insert_category($wpdocs_cat);

}
#unnecessary -----------------------------------

#category = wp_term + `wp_term_taxonomy`

function add_term() {
	$category = wp_insert_term(
		'أحذية', // the term 
		'product_cat', // the taxonomy
		array(
		  'description'=> 'جميع أنواع الأحذية',
		  'slug' => 'shoes'
		)
	  );
	  var_dump($category);
}
// add_action('admin_init','add_term');


# delete from wp_posts where post_title like '%بنطال%'
// add products-----------------------------------------------------------------------------------------------------------------
function add_products() {

	$clothes_women = array("بنطال جينز نسائي", "بنطال قماش نسائي", "كنزة نصف كم", "كنزة كم نسائي", "جاكيت شتوي طويل نسائي", "جاكيت شتوي قصير نسائي", "شورت نسائي", "بلوزة نسائي", "كنزة صوف نسائي", "كنزة داخلية نسائي");
	$clothes_men = array("بنطال جينز رجالي", "بنطال قماش رجالي", "كنزة نصف كم", "كنزة كم رجالي", "جاكيت شتوي طويل رجالي", "جاكيت شتوي قصير رجالي", "بلوزة رجالي", "كنزة صوف رجالي", "كنزة داخلية رجالي");
	$colors = array("أبيض", "أسود", "أزرق", "بني", "فضي", "أزرق داكن", "بني داكن", "أسود داكن");
	$brand = array("Nike", "Louis Vuitton", "GUCCI", "Chanel", "Adidas", "ZARA", "Dior", "COACH", "Burberry", "Puma", "H&M", "Cartier", "UNIQLO", "Levi's", "Omega", "Victoria's Secret", "Ralph Lauren", "Lululemon");

	$start_date = '1/1/2018 1:30:45';
	$end_date = '1/1/2021 4:50:50';
	
	//add women clothes
	for ($x = 0; $x < 70; $x++) {
		$random_name = $clothes_women[rand ( 0 , count($clothes_women) -1)] . "-" . $colors[rand ( 0 , count($colors) -1)] . "-" . $brand[rand ( 0 , count($brand) -1)];
		// that's CRUD object
		$product = new WC_Product_Simple();

		$product->set_name($random_name); // product title

		$product->set_slug('women-clothes');

		$product->set_regular_price( rand(50,150) ); // in current shop currency

		$product->set_short_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.');
		
		$product->set_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق."
		"إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع');

		$product->set_image_id( 7608 );

		$product->set_category_ids( array( 75 ) );

		$product->set_date_created(randomDate($start_date, $end_date));
		// add attributes
		$attributes = array();

		// size
		$attribute = new WC_Product_Attribute();
		$attribute->set_id( wc_attribute_taxonomy_id_by_name( 'pa_size' ) );
		$attribute->set_name( 'pa_size' );
		$attribute->set_options( array( 38, 39, 50 ) );
		$attribute->set_position( 0 );
		$attribute->set_visible( true );
		$attribute->set_variation( false );
		$attributes[] = $attribute;

		$product->set_attributes( $attributes );

		$product->save();
	 }
	
	//add men clothes
	for ($x = 0; $x < 70; $x++) {
		$random_name1 = $clothes_men[rand ( 0 , count($clothes_men) -1)] . "-" . $colors[rand ( 0 , count($colors) -1)] . "-" . $brand[rand ( 0 , count($brand) -1)];
		// that's CRUD object
		$product1 = new WC_Product_Simple();

		$product1->set_name($random_name1); // product title

		$product1->set_slug('men-clothes');

		$product1->set_regular_price( rand(50,150) ); // in current shop currency

		$product1->set_short_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.');
		
		$product1->set_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق."
		"إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع');

		$product1->set_image_id( 7608 );

		$product1->set_category_ids( array( 74 ) );

		$product1->set_date_created(randomDate($start_date, $end_date));
		// add attributes
		$attributes1 = array();

		// size
		$attribute1 = new WC_Product_Attribute();
		$attribute1->set_id( wc_attribute_taxonomy_id_by_name( 'pa_size' ) );
		$attribute1->set_name( 'pa_size' );
		$attribute1->set_options( array( 38, 39, 50 ) );
		$attribute1->set_position( 1 );
		$attribute1->set_visible( true );
		$attribute1->set_variation( false );
		$attributes1[] = $attribute1;

		$product1->set_attributes( $attributes1 );

		$product1->save();
	 }

	 $women_shoes = array("حذاء رسمي نسائي", "بوط رياضي نسائي", "حذاء ساق عالي نسائي", "كندرة نسائي", "حذاء منزلي مغلق نسائي");
	// add women shoes
	for ($x = 0; $x < 90; $x++) {
		$random_name2 = $women_shoes[rand ( 0 , count($women_shoes) -1)] . "-" . $colors[rand ( 0 , count($colors) -1)] . "-" . $brand[rand ( 0 , count($brand) -1)];
		// that's CRUD object
		$product2 = new WC_Product_Simple();

		$product2->set_name($random_name2); // product title

		$product2->set_slug('women-shoes');

		$product2->set_regular_price( rand(80,200) ); // in current shop currency

		$product2->set_short_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.');
		
		$product2->set_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق."
		"إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع');

		$product2->set_image_id( 7610 );

		$product2->set_category_ids( array( 77 ) );

		$product2->set_date_created(randomDate($start_date, $end_date));
		// add attributes
		$attributes2 = array();

		// size
		$attribute2 = new WC_Product_Attribute();
		$attribute2->set_id( wc_attribute_taxonomy_id_by_name( 'pa_size' ) );
		$attribute2->set_name( 'pa_size' );
		$attribute2->set_options( array( 26, 27, 28 ) );
		$attribute2->set_position( 2 );
		$attribute2->set_visible( true );
		$attribute2->set_variation( false );
		$attributes2[] = $attribute2;

		$product2->set_attributes( $attributes2 );

		$product2->save();
	 }

	 $men_shoes = array("حذاء رسمي رجالي", "بوط رياضي رجالي", "حذاء ساق عالي رجالي", "كندرة رجالي", "حذاء منزلي مغلق رجالي");
	 // add men shoes
	 for ($x = 0; $x < 80; $x++) {
		 $random_name3 = $men_shoes[rand ( 0 , count($men_shoes) -1)] . "-" . $colors[rand ( 0 , count($colors) -1)] . "-" . $brand[rand ( 0 , count($brand) -1)];
		 // that's CRUD object
		 $product3 = new WC_Product_Simple();
 
		 $product3->set_name($random_name3); // product title
 
		 $product3->set_slug('men-shoes');
 
		 $product3->set_regular_price( rand(80,200) ); // in current shop currency
 
		 $product3->set_short_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.');
		 
		 $product3->set_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق."
		 "إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع');
 
		 $product3->set_image_id( 7610 );
 
		 $product3->set_category_ids( array( 76 ) );
 
		 $product3->set_date_created(randomDate($start_date, $end_date));
		 // add attributes
		 $attributes3 = array();
 
		 // size
		 $attribute3 = new WC_Product_Attribute();
		 $attribute3->set_id( wc_attribute_taxonomy_id_by_name( 'pa_size' ) );
		 $attribute3->set_name( 'pa_size' );
		 $attribute3->set_options( array( 68, 69, 70, 71, 72 ) );
		 $attribute3->set_position( 3 );
		 $attribute3->set_visible( true );
		 $attribute3->set_variation( false );
		 $attribute3[] = $attribute3;
 
		$product3->set_attributes( $attributes3 );
 
		$product3->save();
	}
//     # delete from wp_posts where post_title like '%PANASONIC%'
 	$electronics = array("غسالة", "براد", "خلاط", "فرن", "حاسوب مكتبي", "لابتوب", "تلفاز", "مصفف شعر");
 	$electronics_colors = array("أبيض", "أسود", "بني", "فضي", "أسود داكن");
	$electronics_brand = array("SONY", "SAMSUNG", "HP", "LG", "PANASONIC");

	for ($x = 0; $x < 70; $x++) {
		$random_name4 = $electronics[rand ( 0 , count($electronics) -1)] . "-" . $electronics_colors[rand ( 0 , count($electronics_colors) -1)] . "-" . $electronics_brand[rand ( 0 , count($electronics_brand) -1)];
		// that's CRUD object
		$product4 = new WC_Product_Simple();

		$product4->set_name($random_name4); // product title

		$product4->set_slug('electronics');

		$product4->set_regular_price( rand(200,300) ); // in current shop currency

		$product4->set_short_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.');
		
		$product4->set_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق."
		"إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع');

		$product4->set_image_id( 7609 );

		$product4->set_category_ids( array( 78 ) );

		$product4->set_date_created(randomDate($start_date, $end_date));

	   $product4->save();
   }
   # delete from wp_posts where post_title like '%URBN Glow%'
   # delete from wp_posts where post_title like '%NOIR%' OR 'Sunflower' OR 'Waverly' OR 'BLVD 13' OR 'Wild Child' OR 'SHADE' OR 'URBN Glow' OR 'Chic & Humble' OR 'Boho Bunny' OR 'Allora' OR 'Auguri' OR 'Dolce' OR 'Flor & Luz' OR 'Culture' OR 'Moonlight' OR 'Luna & Clover'
   	$access = array("خاتم نسائي فضة", "سنسال نسائي للزينة", "جزدان يد نسائي", "أساور نسائية للزينة", "ساعة حائط على شكل فراشة", "أحجار ملونة", "حلق فضة", "حلق لون ذهبي");
	$access_brand = array("NOIR", "Sunflower", "Waverly", "BLVD 13", "Wild Child", "SHADE", "URBN Glow", "Boho Bunny", "Allora", "Auguri", "Dolce", "Flor & Luz", "Culture", "Moonlight");

	for ($x = 0; $x < 50; $x++) {
		$random_name5 = $access[rand ( 0 , count($access) -1)]  . "-" . $access_brand[rand ( 0 , count($access_brand) -1)];
		// that's CRUD object
		$product5 = new WC_Product_Simple();

		$product5->set_name($random_name5); // product title

		$product5->set_slug('access');

		$product5->set_regular_price( rand(50,90) ); // in current shop currency

		$product5->set_short_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.');
		
		$product5->set_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق."
		"إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع');

		$product5->set_image_id( 53194 );

		$product5->set_category_ids( array( 82 ) );

		$product5->set_date_created(randomDate($start_date, $end_date));

	   $product5->save();
   }

   $cosmetics = array("شامبو مغزي للشعر", "زيت تصفيف للشعر", "ميكاب", "مجموعة العناية بالبشرة", "حمرة", "مسكرة");
   $Accessories_brand = array("NOIR", "Sunflower", "Waverly", "BLVD 13", "Wild Child", "SHADE", "URBN Glow", "Chic & Humble", "Boho Bunny", "Allora", "Auguri", "Dolce", "Flor & Luz", "Culture", "Moonlight","Luna & Clover");
   	for ($x = 0; $x < 70; $x++) {
		$random_name6 = $cosmetics[rand ( 0 , count($cosmetics) -1)]  . "-" . $Accessories_brand[rand ( 0 , count($Accessories_brand) -1)];
		// that's CRUD object
		$product6 = new WC_Product_Simple();

		$product6->set_name($random_name6); // product title

		$product6->set_slug('cosmetics');

		$product6->set_regular_price( rand(50,90) ); // in current shop currency

		$product6->set_short_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.');
		
		$product6->set_description('هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق."
		"إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع');

		$product6->set_image_id( 48733 );

		$product6->set_category_ids( array( 79 ) );

		$product6->set_date_created(randomDate($start_date, $end_date));

	   $product6->save();
  }
}

# delete from wp_options where option_name like '%add_products%'
// Triggered once
add_action( 'init', 'my_run_only_once' );
function my_run_only_once() {
    if ( did_action( 'init' ) >= 2 )
        return;

    if( ! get_option('run_add_products_once_630') ) {
		add_option( 'run_add_products_once_630', true );
        add_products(); // Run the function
    }
}
# delete the duplicated products4
// DELETE FROM wp_posts
// WHERE ID NOT IN
// (
// SELECT MIN(ID)
// FROM wp_posts
// GROUP BY post_title
// )


// SELECT * FROM `wp_posts` WHERE post_type = 'shop_order'
function add_order() {
	global $wpdb;

	$start_date = '1/1/2018 1:30:45';
	$end_date = '1/1/2022 4:50:50';

	$product_info = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish'
	AND post_type='product' ");

	$men_products = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE (post_status = 'publish' AND post_type='product') 
	AND (post_title like '%رجالي%' OR post_title like '%خاتم%' OR post_title like '%حلق%' OR post_title like '%ميكاب%') ");

	$men_pant = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	 		AND post_title like '%رجالي%' AND post_title like '%بنطال%' ");

	$men_sweat = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	 		AND post_title like '%رجالي%' AND post_title like '%كنزة%' ");

	$men_jacket = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
			AND post_title like '%رجالي%' AND post_title like '%جاكيت%' ");

	$men_shoes = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	AND post_title like '%رجالي%' AND (post_title like '%حذاء%' OR post_title like '%بوط%' OR post_title like '%كندرة%') ");

	$electronics = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE (post_status = 'publish' AND post_type='product') 
									AND (post_title like '%SONY%' OR post_title like '%SAMSUNG%' OR post_title like '%HP%' 
									OR post_title like '%LG%' OR post_title like '%PANASONIC%' OR post_title like '%وصلة%') ");

	// $women_products = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish'
	// AND post_type='product'
	// AND post_title like '%نسائي%' OR post_title like '%شامبو%' OR post_title like '%زيت%' OR post_title like '%شعر%'
	// 	OR post_title like '%ميكاب%' OR post_title like '%عناية%' OR post_title like '%أحجار%' OR post_title like '%هاتف%'
	// 	OR post_title like '%سماعات%' OR post_title like '%شعر%' ");

	$women_pant = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	AND post_title like '%نسائي%' AND post_title like '%بنطال%' ");

	$women_sweat = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
		AND post_title like '%نسائي%' AND post_title like '%كنزة%' ");

	$women_shoes = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	AND post_title like '%نسائي%' AND (post_title like '%حذاء%' OR post_title like '%بوط%' OR post_title like '%كندرة%') ");
	
	$women_jacket = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	AND post_title like '%نسائي%' AND post_title like '%جاكيت%' ");

	$access = $wpdb->get_results("SELECT ID, post_date, post_title FROM $wpdb->posts WHERE (post_status = 'publish' AND post_type='product') 
								AND (post_title like '%خاتم%' OR post_title like '%سنسال%' OR post_title like '%جزدان%' OR post_title like '%أساور%' 
								OR post_title like '%أحجار%' OR post_title like '%حلق%') ");

	$cosme = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE (post_status = 'publish' AND post_type='product') 
								AND (post_title like '%شامبو%' OR post_title like '%زيت%' OR post_title like '%شعر%' OR post_title like '%ميكاب%' OR post_title like '%عناية%' 
								OR post_title like '%حمرة%' OR post_title like '%مسكرة%'); ");

	// --------------------------------------------------------------------------------------------------------------------------------------------------
	$refrigerator = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
					AND post_title like '%براد%' ");

	$Washer = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
					AND post_title like '%غسالة%' ");
	
	$oven = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
					AND post_title like '%فرن%' ");

	$television = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	AND post_title like '%تلفاز%' ");

	$hairdresser = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	AND post_title like '%مصفف شعر%' ");

	$computer = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	AND post_title like '%حاسوب%' ");

	// --------------------------------------------------------------------------------------------------------------------------------------------------

	$shampoo = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	AND post_title like '%شامبو%' ");

	$oil = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	AND post_title like '%زيت%' ");

	$care = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	AND post_title like '%العناية%' ");

	$makeup = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='product' 
	AND post_title like '%ميكاب%' ");

	// --------------------------------------------------------------------------------------------------------------------------------------------------
	$user_info = $wpdb->get_results("SELECT u.ID, u.user_email, u.user_registered, firstname.meta_value as first_name,
							lastname.meta_value as last_name, country.meta_value as country, gender.meta_value as gender, age.meta_value as 
							age FROM $wpdb->users u 
							INNER JOIN (SELECT user_id, meta_value FROM $wpdb->usermeta WHERE meta_key = 'first_name') as firstname ON u.ID = firstname.user_id 
							INNER JOIN (SELECT user_id, meta_value FROM $wpdb->usermeta WHERE meta_key = 'last_name') as lastname ON u.ID = lastname.user_id 
							INNER JOIN (SELECT user_id, meta_value FROM $wpdb->usermeta WHERE meta_key = 'country') as country ON u.ID = country.user_id 
							INNER JOIN (SELECT user_id, meta_value FROM $wpdb->usermeta WHERE meta_key = 'gender') as gender ON u.ID = gender.user_id 
							INNER JOIN (SELECT user_id, meta_value FROM $wpdb->usermeta WHERE meta_key = 'age') as age ON u.ID = age.user_id 
							WHERE u.ID < 1000;");

	$payment_methods = array('stripe', 'paypal');

	$status = array('wc-completed', 'wc-completed', 'wc-refunded', 'wc-completed', 'wc-completed','wc-completed','wc-completed','wc-completed', 'wc-cancelled', 'wc-completed',);
	
	for ($x = 0; $x < 1000; $x++) {
		$order = wc_create_order();

		//$product_categories = wc_get_product_category_list($product_id); // array

		$random_user = rand ( 0 , count($user_info) -1);

		$user_id = $user_info[$random_user]->ID;
		$user_registered_date = $user_info[$random_user]->user_registered;
		$user_email =$user_info[$random_user]->user_email;
		$first_name =$user_info[$random_user]->first_name;
		$last_name =$user_info[$random_user]->last_name;
		$country =$user_info[$random_user]->country;
		$user_gender = $user_info[$random_user]->gender;
		$user_age = $user_info[$random_user]->age;

		$order->set_customer_id( $user_id );

		$random_product = rand ( 0 , count($men_products) -1);
		$product_id = $men_products[$random_product]->ID;
		$product_date = $men_products[$random_product]->post_date;
		$order->add_product( wc_get_product( $product_id ), 1);

		//$biggest_product_date = randomDate($start_date, $end_date);
		//$random_j = rand(2, 4);
		
		// if ($user_gender == 'ذكر' && (int)$user_age >= 30) {
		// 	for($j = 0; $j < $random_j ; $j++) {
		// 		if($j == 0) {
		// 			$random_product = rand ( 0 , count($refrigerator) -1);
		// 			$product_id = $refrigerator[$random_product]->ID;
		// 			$product_date = $refrigerator[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 1) {
		// 			$random_product = rand ( 0 , count($Washer) -1);
		// 			$product_id = $Washer[$random_product]->ID;
		// 			$product_date = $Washer[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 2) {
		// 			$random_product = rand ( 0 , count($oven) -1);
		// 			$product_id = $oven[$random_product]->ID;
		// 			$product_date = $oven[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 3) {
		// 			$random_product = rand ( 0 , count($hairdresser) -1);
		// 			$product_id = $hairdresser[$random_product]->ID;
		// 			$product_date = $hairdresser[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		$order->add_product( wc_get_product( $product_id ), 1);
		// 	}
		// } elseif ($user_gender == 'ذكر' && (int)$user_age <= 30) {
		// 	for($j = 0; $j < $random_j ; $j++) {
		// 		if($j == 0) {
		// 			$random_product = rand ( 0 , count($men_pant) -1);
		// 			$product_id = $men_pant[$random_product]->ID;
		// 			$product_date = $men_pant[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 1) {
		// 			$random_product = rand ( 0 , count($men_sweat) -1);
		// 			$product_id = $men_sweat[$random_product]->ID;
		// 			$product_date = $men_sweat[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 2) {
		// 			$random_product = rand ( 0 , count($men_shoes) -1);
		// 			$product_id = $men_shoes[$random_product]->ID;
		// 			$product_date = $men_shoes[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 3) {
		// 			$random_product = rand ( 0 , count($men_jacket) -1);
		// 			$product_id = $men_jacket[$random_product]->ID;
		// 			$product_date = $men_jacket[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		$order->add_product( wc_get_product( $product_id ), 1);
		// 	}
		// }
		// elseif($user_gender == 'انثى' && (int)$user_age <= 30) {
		// 	for($j = 0; $j < $random_j ; $j++) {
		// 		if($j == 0) {
		// 			$random_product = rand ( 0 , count($makeup) -1);
		// 			$product_id = $makeup[$random_product]->ID;
		// 			$product_date = $makeup[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 1) {
		// 			$random_product = rand ( 0 , count($care) -1);
		// 			$product_id = $care[$random_product]->ID;
		// 			$product_date = $care[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 2) {
		// 			$random_product = rand ( 0 , count($oil) -1);
		// 			$product_id = $oil[$random_product]->ID;
		// 			$product_date = $oil[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 3) {
		// 			$random_product = rand ( 0 , count($shampoo) -1);
		// 			$product_id = $shampoo[$random_product]->ID;
		// 			$product_date = $shampoo[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		$order->add_product( wc_get_product( $product_id ), 1);
		// 	}
		// } else{
		// 	for($j = 0; $j < $random_j ; $j++) {
		// 		if($j == 0) {
		// 			$random_product = rand ( 0 , count($women_pant) -1);
		// 			$product_id = $women_pant[$random_product]->ID;
		// 			$product_date = $women_pant[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 1) {
		// 			$random_product = rand ( 0 , count($women_sweat) -1);
		// 			$product_id = $women_sweat[$random_product]->ID;
		// 			$product_date = $women_sweat[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 2) {
		// 			$random_product = rand ( 0 , count($women_shoes) -1);
		// 			$product_id = $women_shoes[$random_product]->ID;
		// 			$product_date = $women_shoes[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		if($j == 3) {
		// 			$random_product = rand ( 0 , count($access) -1);
		// 			$product_id = $access[$random_product]->ID;
		// 			$product_date = $access[$random_product]->post_date;
		// 			if ($product_date > $biggest_product_date) {
		// 				$biggest_product_date = $product_date;
		// 			}
		// 		}
		// 		$order->add_product( wc_get_product( $product_id ), 1);
		// 	}
		// }
		


		//guset ----------------------------------------------------------------------
		// $random_product = rand ( 0 , count($product_info) -1);
		// $product_id = $product_info[$random_product]->ID;
		// $product_date = $product_info[$random_product]->post_date;
		//guset ----------------------------------------------------------------------

		// add date
		$order_date = randomDate($start_date, $end_date);
		if ($product_date > $order_date) {
			$start_date = $product_date;
			$new_product_date = randomDate($start_date, $end_date);
			$order->set_date_created( $new_product_date );
		}	
		else{
			$order->set_date_created( $order_date );
		}

		// create shipping object
		$shipping = new WC_Order_Item_Shipping();
		$shipping->set_method_title( 'Free shipping' );
		$shipping->set_method_id( 'free_shipping:1' ); // set an existing Shipping method ID
		$shipping->set_total( 0 ); // optional

		// add to order
		$order->add_item( $shipping );

		// add address
		$address = array(
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'company'    => '',
			'email'      => $user_email,
			'phone'      => '',
			'address_1'  => $country,
			'address_2'  => '', 
			'city'       => $country,
			'state'      => '',
			'postcode'   => '',
			'country'    => $country
		);


		//guset ----------------------------------------------------------------------
		// $random_first_name = last_name(). strval($x);
		// $random_last_name = first_name();
		// $random_user_email = $random_first_name . "@gmail.com";

		// $countries = array('JO', 'BH', 'SA', 'AE', 'KW');
		// $random_country = $countries[rand ( 0 , count($countries) -1)];

		// $address = array(
		// 	'first_name' => $random_first_name,
		// 	'last_name'  => $random_last_name,
		// 	'company'    => '',
		// 	'email'      => $random_user_email,
		// 	'phone'      => '',
		// 	'address_1'  => $random_country,
		// 	'address_2'  => '', 
		// 	'city'       => $random_country,
		// 	'state'      => '',
		// 	'postcode'   => '',
		// 	'country'    => $random_country
		// );
		//guset ----------------------------------------------------------------------
		
		$order->set_address( $address, 'billing' );
		$order->set_address( $address, 'shipping' );

		// add payment method
		$order->set_payment_method( $payment_methods[rand ( 0 , count($payment_methods) -1)] );
		$order->set_payment_method_title( 'Credit/Debit card' );

		// add status
		$order->update_status( $status[rand ( 0 , count($status) -1)] );

		// calculate and save
		$order->calculate_totals();
		$order->save();
	}
}

add_action( 'init', 'my_run_only_once_order' );
function my_run_only_once_order() {
    if ( did_action( 'init' ) >= 2 )
        return;

    if( ! get_option('run_add_products_once_order600') ) {
		add_option( 'run_add_products_once_order600', true );
        add_order(); // Run the function
    }
}

// تخصيص دالة المنتجات المشابهة
add_filter( 'woocommerce_related_products', 'custom_related_products', 10, 3 );

function custom_related_products( $related_posts, $product_id, $args ) {
	global $wpdb;

    // استعلام لجلب العناصر المترابط بالمنتج
	$custom_data = $wpdb->get_results( $wpdb->prepare(
        "SELECT product_id_out FROM custom_products_association WHERE product_id_in = %d", $product_id
    ) );
	    // قائمة لتخزين product_id المسترجعة من قاعدة البيانات
		$associated_product_ids = array();

		// استخراج القيم المسترجعة إلى قائمة المنتجات المرتبطة
		foreach ( $custom_data as $data ) {
			$associated_product_ids[] = $data->product_id_out;
		}

    return $associated_product_ids;
}

// اعداد مسار خادم flask api
function get_flask_api_url($path) {
	$base_url = "http://localhost:5000";
	
	return $base_url . '/' . $path ;
}

// short code
include("custom_shortcodes/gen_custom_products_button.php");
include("custom_shortcodes/classificationWP.php");
include("custom_shortcodes/find_products_for_customer.php");
include("custom_shortcodes/time_seriesWP.php");