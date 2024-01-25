<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die();
}

if (isset($_POST['update'])) {
    $user_id = absint($_POST['user_id']);
    $fname = sanitize_text_field($_POST['user_fname']);
    $lname = sanitize_text_field($_POST['user_lname']);
    $pass = sanitize_text_field($_POST['user_pass']);

    if($_FILES['user_img']['error'] ==0){
    $file = $_FILES['user_img'];
    $ext = explode('/', $file['type'])[1];
    $file_name = "$user_id.$ext"; //5.png
    // print_r($image);
    // echo '<pre>';
    // print_r($file);

    if (!metadata_exists('user', $user_id, 'user_profile_img_url')) {
        $image = wp_upload_bits($file_name, null, file_get_contents($file['tmp_name']));
        add_user_meta($user_id, 'user_profile_img_url',   $image['url']);
        add_user_meta($user_id, 'user_profile_img_path', esc_sql($image['file']));
    } else {
        $profile_img_path = get_user_meta($user_id, 'user_profile_img_path', true);
        wp_delete_file($profile_img_path );
        $image = wp_upload_bits($file_name, null, file_get_contents($file['tmp_name']));
        update_user_meta($user_id, 'user_profile_img_url',   $image['url']);
        update_user_meta($user_id, 'user_profile_img_path',  esc_sql($image['file']));
    }
}
    $userdata = array(
        'ID'          => $user_id,
        'first_name'  => $fname,
        'last_name'   => $lname,
    );

    $user = wp_update_user($userdata);

    if (is_wp_error($user)) {
        echo 'Can not Update: ' . $user->get_error_message();
    } elseif (!empty($pass)) {
        wp_set_password($pass, $user_id);
    }
}

$user_id = get_current_user_id();
$user = get_userdata($user_id);
// print_r($user);

if ($user != false) :

    // echo wp_logout_url(  );

    // echo '<pre>';
    // print_r($user);
    $fname = get_user_meta($user_id, 'first_name', true);
    $lname = get_user_meta($user_id, 'last_name', true);
   $profile_img = get_user_meta($user_id, 'user_profile_img_url', true);
//    echo $profile_img = get_user_meta($user_id, 'user_profile_img_path', true);
   // $pass = get_user_meta($user_id,'user_pass',true);
    // $pass = $user->user_pass; // Retrieve the user password

?>
    <?php 
    if($profile_img != ''){
        ?>
        <img src="<?php echo $profile_img;?>" >
        <?php
    }
    ?>
    <h1>hiii <br><?php echo " $fname $lname "; ?></h1>
    <p>Not <?php echo " $fname $lname "; ?>? <a href="<?php echo wp_logout_url(); ?>"> Logout </a></p>
    <h1>Update from below</h1>
    <form action="<?php echo get_the_permalink(); ?>" method="post" enctype="multipart/form-data">
        Profile : <input type="file" name="user_img" id="user-img"><br>
        First name: <input type="text" name="user_fname" id="user-fname" value="<?php echo esc_attr($fname); ?>"><br>
        Last Name: <input type="text" name="user_lname" id="user-lname" value="<?php echo esc_attr($lname); ?>"><br>
        Password: <input type="text" name="user_pass" id="user-pass" value=""><br>

        <input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>">
        <input type="submit" name="update" value="Update">
    </form>

<?php
endif;
?>