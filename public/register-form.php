<?php

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die();
}

if (isset($_POST['register'])) {
    global $wpdb;
    $fname = $wpdb->escape($_POST['user_fname']);
    $lname = $wpdb->escape($_POST['user_lname']);
    $username = $wpdb->escape($_POST['username']);
    $email = $wpdb->escape($_POST['user_email']);
    $pass = $wpdb->escape($_POST['user_pass']);
    $con_pass = $wpdb->escape($_POST['user_con_pass']);

    if ($pass ==  $con_pass) {

        //wp_insert_user() deatiled user 
        //wp_create_user() 2 main field


        $user_data = array(
            'user_login' =>  $username,
            'user_email' =>   $email,
            'first_name' =>  $fname,
            'last_name' =>   $lname,
            'display_name' =>  $fname,
            'user_pass' =>  $pass
        );
        $result = wp_insert_user($user_data);
        if (!is_wp_error($result)) {
            echo 'User craeted ID:' . $result;
            update_user_meta( $result, 'show_admin_bar_front',false );
        } else {
            echo $result->get_error_message();
        }

        // use create method wp_create_user
        // $result = wp_create_user( $username, $pass, $email);
        //     if(!is_wp_error( $result )){
        //         echo 'User craeted ID:'.$result;
        //     }else{
        //         echo $result->get_error_message();
        //     }

    } else {
        echo 'Password must match';
    }
}

?>

<div class="form-wrapper">
 
    <div class="regi-form">

        <form action="<?php echo get_the_permalink(); ?>" method="post">
            First name : <input type="text" name="user_fname" id="user-fname"><br>
            Last Name : <input type="text" name="user_lname" id="user-lname"><br>
            Username : <input type="text" name="username" id="username"><br>
            Email : <input type="text" name="user_email" id="user_email"><br>
            Password : <input type="password" name="user_pass" id="user-pass"><br>
            Confirm Password : <input type="password" name="user_con_pass" id="user-con-pass"><br>

            <input type="submit" class="button" name="register" value="Register">
        </form>
    </div>
</div>