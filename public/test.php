<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die();
}


if(isset($_POST['update'])){
    $user_id = esc_url( $_POST['user_id'] );
    $fname = esc_url( $_POST['user_fname'] );
    $lname = esc_url( $_POST['user_lname'] );
    $pass = sanitize_text_field( $_POST['user_pass'] );

    $userdata = array(
      
        'ID' => $user_id,
        'first_name' => $fname,
       'last_name' => $lname,
    );
    $user = wp_update_user( $userdata );
    if(is_wp_error( $user)){
        echo 'Can not Update : '.$user->get_error_message();
    }else {
        if(!empty($pass)){
            wp_set_password($pass, $user_id );
        }
    }

}

$user_id = get_current_user_id();
$user = get_userdata($user_id);
if ($user != false) :

    echo '<pre>';
    // print_r($user);
    // $user_type = get_user_meta( $user_id, 'type' )
    $fname = get_user_meta($user_id, 'first_name', true);
    $lname = get_user_meta($user_id, 'last_name', true);
    $pass = get_user_meta($user_id,'user_pass',true);
    
?>

    <h1>hiii <br><?php echo " $fname $lname "; ?></h1>
    <h1>Update from below</h1>
    <form action="<?php echo get_the_permalink(); ?>" method="post">
    First name : <input type="text" name="user_fname" id="user-fname" value="<?php echo $fname;?>"><br>
    Last Name : <input type="text" name="user_lname" id="user-lname" value="<?php echo $lname;?>"><br>
    Password : <input type="text" name="user_pass" id="user-pass" value="<?php echo $pass;?>"><br>

    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input type="submit" name="update" value="Update">
</form>
<?php
endif;
?>

