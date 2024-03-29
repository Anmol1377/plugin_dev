<?php

/**
 *
 * @link              https://test.com
 * @since             1.0.0
 * @package           Test_plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Test_plugin
 * Plugin URI:        https://test.com
 * Description:       local
 * Version:           1.0.0
 * Author:            Local
 * Author URI:        https://test.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       test_plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die();
}


// activation hook 
function plugin_activation()
{
    global $wpdb, $table_prefix;
    $wp_mytable = $table_prefix . 'mytable';
    $q = "CREATE TABLE IF NOT EXISTS `$wp_mytable` (
        `ID` INT NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(50) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `status` BOOLEAN NOT NULL,
        PRIMARY KEY (`ID`)
    ) ENGINE = InnoDB;";

    $wpdb->query($q);
    // $insert_query = "INSERT INTO `$wp_mytable` (`name`, `email`, `status`) VALUES ('anmol', 'anmol@demo.com', 1)";
    // $wpdb->query($insert_query);

    $data = array(
        array(
            'name' => 'akash',
            'email' => 'akash@demo.com',
            'status' => '1'
        ),
        array(
            'name' => 'anmol',
            'email' => 'anmol@demo.com',
            'status' => '1'
        ),
        array(
            'name' => 'akash',
            'email' => 'akash@demo.com',
            'status' => '1'
        ),
        array(
            'name' => 'anuj',
            'email' => 'anuj@demo.com',
            'status' => '1'
        )

    );

    //insert single data
    // $wpdb->insert($wp_mytable, $data);

    //add more data
    foreach ($data as $single_data) {
        $wpdb->insert($wp_mytable, $single_data);
    }
}
register_activation_hook(__FILE__, 'plugin_activation');

// deactivation hook
function plugin_deactivate()
{
    global $wpdb, $table_prefix;
    $wp_mytable = $table_prefix . 'mytable';

    // $q = "DROP TABLE  `$wp_mytable`";
    $q = " TRUNCATE  `$wp_mytable`";

    $wpdb->query($q);
}
register_deactivation_hook(__FILE__, 'plugin_deactivate');


// Shortcode 

// ------=-=-=-=-=-=-=-=-=-=-
// comment code not working fine and in below code return coming 2 time

// function MyShortcode($atts){
// echo 'using echo';
// return 'using return'. $atts['message'];
// }

// add_shortcode( 'my_shortcode', 'MyShortcode' );



// $message = isset($atts['msg']) ? $atts['msg'] : 'Default Message';
// isset($atts['msg']) checks if the 'msg' attribute exists within the $atts array. The isset() function returns true if the attribute is set and false otherwise.

// The ternary operator ? : functions like an inline if-else statement. It evaluates the condition (isset($atts['msg'])). If the condition is true, the value before the colon ($atts['msg']) is assigned to $message. If the condition is false, the value after the colon ('Default Message') is assigned to $message.

// In simpler terms, this line of code does the following:

// If the 'msg' attribute exists in the $atts array, $message is assigned the value of that attribute ($atts['msg']).
// If the 'msg' attribute doesn't exist or is not set, $message is assigned the value 'Default Message'.

function MyShortcode($atts)
{
    $message = isset($atts['msg']) ? $atts['msg'] : 'Default Message';
    echo 'using echo'; // This line echoes content
    return 'using return ' . $message; // This line also adds content to the output

}
add_shortcode('my_shortcode', 'MyShortcode');


// [my_shortcode]  use shortcode
// by using attributes [my_shortcode msg="hello i'm using atytributes"] 





function my_custom_scripts()
{

    // adding file js file to plugin 
    $path_js = plugins_url('js/main.js', __FILE__);
    $path_css = plugins_url('css/style.css', __FILE__);

    // dependeciy
    $dep = array('jquery');
    $ver_js = filemtime(plugin_dir_path(__FILE__) . 'js/main.js');
    $ver_css = filemtime(plugin_dir_path(__FILE__) . 'css/style.css');

    wp_enqueue_script('my_custom-javascript', $path_js, $dep, $ver_js, true);

    // wp_enqueue_style( 'my_custom-css', $path_css, '', $ver_css, '' );



    // for iuncling in one page 
    // test is my page slug
    if (is_page('test')) {
        wp_enqueue_style('my_custom-css', $path_css, '', $ver_css, '');
    }


    // ? is ternary opertor
    $is_login = is_user_logged_in() ? 1 : 0;
    // wp_add_inline_script('my_custom-javascript', 'var is_login =' . $is_login . ';', 'before');
    wp_add_inline_script('my_custom-javascript', 'var ajaxUrl="' . admin_url('admin-ajax.php') . '";', 'before');
};


add_action('wp_enqueue_scripts', 'my_custom_scripts');

// this will add scripts to admin panel
add_action('admin_enqueue_scripts', 'my_custom_scripts');




// database fectch 

function my_db_work()
{
    global $wpdb, $table_prefix;
    $wp_mytable = $table_prefix . 'mytable';
    $q = "SELECT * FROM `$wp_mytable`;";
    $results = $wpdb->get_results($q);

    // print normal
    // print_r($results);


    // output buffere start (captured using the output buffering functions ) 
    // An output buffer is a memory or cache location where data is held until an output device or file is ready to receive it.

    // ob can be use one time 
    // below code is for ob show of result 
    // echo '<pre>'
    // ob_start();
    //     print_r($results);
    //     $output = ob_get_clean();

    //     return  $output;
    //     echo '</pre>'

    // prinitn in table


    ob_start();
?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($results as $row) :
            ?>
                <tr>
                    <td><?php echo $row->ID; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->email; ?></td>
                    <td><?php echo $row->status; ?></td>
                </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
    <?php
    $html = ob_get_clean();

    return $html;
}
add_shortcode('db_print', 'my_db_work');



// post fetch
function my_posts()
{
    $args = array(
        'post_type' => 'post',
        //search = s which searching blog 5 and printing
        // 's' => 'blog 5'
        //category wise print
        // 'category_name' => 'cat1'
        'posts_per_page' => 10,
        'orderby' => 'ID',
        'order' => 'ASC',

        'meta_query' => array(
            array(
                'key' => 'views',
                // 'value' => '2',
                // 'compare' => '>='
            )
        )

        // 'tag' => 'any tag name here' 
    );

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) :
    ?>
        <ul>
            <?php
            while ($query->have_posts()) {
                $query->the_post();
                echo '<li> <a href="' . get_the_permalink() . '">' . get_the_post_thumbnail() . '<br>' . get_the_title() . '</a> (' . get_post_meta(get_the_ID(), 'views', true) . ') -> <br>' . get_the_content() . '</li>';
            }
            ?>
        </ul>
    <?php
    endif;
    wp_reset_postdata();
    $html = ob_get_clean();
    return $html;
}
add_shortcode('my-posts', 'my_posts');


//views count and use it in the home page with post_meta keyword and so on 
function my_head_function()
{

    //is_sigle is for posts & is_sigular is for page sigle page
    if (is_single()) {
        global $post;
        $views = get_post_meta($post->ID, 'views', true);

        // echo '<h1>hihih</h1>';
        // echo $post->ID;

        if ($views == '') {
            add_post_meta($post->ID, 'views', 1);
        } else {
            $views++;
            update_post_meta($post->ID, 'views', $views);
        }

        // echo get_post_meta(  $post->ID , 'views' , true );
    }
}

add_action('wp_head', 'my_head_function');

function views_count()
{
    global $post;
    return '<h3>Total views on site : ' . get_post_meta($post->ID, 'views', true) . '</h3>';
}
add_shortcode('views-counter', 'views_count');




// add menu page

function my_plugin_page_func()
{
    echo 'hihi from admin page';
    include 'admin/my-admin-page.php';
}

function my_sub_menu_page_func()
{
    echo 'hihi from sub admin page';
    include 'admin/my-sub-admin-page.php';
}


function my_admin_menu_page()
{

    // add_menu_page( $page_title:string, $menu_title:string, $capability:string, $menu_slug:string, $callback:callable, $icon_url:string, $position:integer|float|null )
    add_menu_page('My Custom menu', 'My Menu Page', 'manage_options', 'my-menu-page', 'my_plugin_page_func', '', 6);
    // add_submenu_page( $parent_slug:string, $page_title:string, $menu_title:string, $capability:string, $menu_slug:string, $callback:callable, $position:integer|float|null )
    add_submenu_page('my-menu-page', 'My main menu page title', 'My main menu page', 'manage_options', 'my-menu-page', 'my_plugin_page_func');

    add_submenu_page('my-menu-page', 'My sub menu page title', 'My sub menu', 'manage_options', 'my-sub-menu', 'my_sub_menu_page_func');
}

add_action('admin_menu', 'my_admin_menu_page');


// ajax form function
add_action('wp_ajax_my_search_func', 'my_search_func');
function my_search_func()
{
    // echo 'hi ajax';
    global $wpdb, $table_prefix;
    $wp_mytable = $table_prefix . 'mytable';
    $search_term = $_POST['search_term'];

    // if (isset($_GET['my_search_term'])) {
    if (!empty($search_term)) {
        $q = "SELECT * FROM `$wp_mytable` WHERE `name` LIKE '%" . $search_term . "%'
        OR `email` LIKE '%" . $search_term . "%';";
    } else {
        $q = "SELECT * FROM `$wp_mytable`;";
    }
    $results = $wpdb->get_results($q);
    // echo  $search_term;
    // echo '<pre>';
    // print_r($results);
    // echo '</pre>';
    ob_start();
    foreach ($results as $row) :
    ?>
        <tr>
            <td><?php echo $row->ID; ?></td>
            <td><?php echo $row->name; ?></td>
            <td><?php echo $row->email; ?></td>
            <td><?php echo $row->status; ?></td>
        </tr>
<?php
    endforeach;
    echo ob_get_clean();
    wp_die();
}


// disply this in frontend
add_shortcode('my-dbdb-data-show', 'my_db_data');
// include 'admin/my-admin-page.php';


// custom post types code 
function register_my_cpt()
{
    $labels = array(
        'name' => 'All Cars',
        'singular_name' => 'Car',
        // 'menu_name' => 'add new Cars' 
    );
    $supports = array(
        'title', 'editor', 'thumbnail', 'comments', 'excerpts'
    );
    $options = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'cars',
        ),
        'show_in_rest' => true,
        'supports' => $supports,
        'taxonomies' => array(
            // 'category'
            'car_type'
        )
    );
    register_post_type('cars', $options);
}

// init is used here becoz after core files loaded my_cpt will start working 
// Fires after WordPress has finished loading but before any headers are sent.
add_action('init', 'register_my_cpt');

// register category 
function register_car_types()
{
    $labels = array(
        'name' => 'Car Types',
        'singular_name' => 'Car Types'
    );
    $options = array(
        'labels' => $labels,
        'hierarchical' => true,
        'rewrite' => array(
            'slug' => 'car-type',
        ),
        'show_in_rest' => true,
    );
    register_taxonomy('car-type', array('cars'), $options);
}

add_action('init', 'register_car_types');


// register form 
function my_register_form(){
    ob_start();
    include 'public/register-form.php';
    return ob_get_clean();
}
add_shortcode( 'my-register-form', 'my_register_form');



// custom restapi

add_action('rest_api_init', 'my_custom_endpoint');

function my_custom_endpoint() {
    register_rest_route('Test_plugin/v1', '/data/', array(
        'methods'  => 'GET',
        'callback' => 'get_custom_data',
    ));
}

function get_custom_data() {
    // Your custom logic to fetch and return data
    $data = array('key' => 'valuee');
    return rest_ensure_response($data);
}


// Register shortcode
add_shortcode('custom_data_shortcode', 'custom_data_shortcode_function');

// Shortcode callback function
function custom_data_shortcode_function($atts) {
    // Make a request to your custom REST API endpoint
    $response = wp_remote_get('http://plugin-dev.local/wp-json/Test_plugin/v1/data/');
    
    // Check if the request was successful
    if (is_wp_error($response)) {
        return 'Error fetching data'; // Display error message if request fails
    }
    
    // Get the response body
    $body = wp_remote_retrieve_body($response);
    
    // Decode the JSON response
    $data = json_decode($body, true);
    
    // Check if data exists
    if ($data && isset($data['key'])) {
        // Output the data
        return 'Data: ' . $data['key'];
    } else {
        return 'No data available';
    }
}


?>