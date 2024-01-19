<?php
global $wpdb, $table_prefix;
$wp_mytable = $table_prefix . 'mytable';
if(isset($_GET['my_search_term'])){
    $q = "SELECT * FROM `$wp_mytable` WHERE `name` LIKE '%".$_GET['my_search_term']."%';";
}else{
    $q = "SELECT * FROM `$wp_mytable`;";
}
$results = $wpdb->get_results($q);

ob_start();
?>
<div class="wrap">
    <h2>My Admin page</h2>
    <div class="my_form">
        <form action="<?php echo admin_url('admin.php'); ?>" id="my-search-form">
<input type="hidden" name="page" value="my-menu-page">
        <input type="text" name = "my_search_term" id = "my-search-term">
<input type="submit" value = "search" name="submit">
        </form>
    </div>
    <table class="wp-list-table widefat fixed striped table-view-list posts">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="my-table-result">
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
</div>
<?php
echo ob_get_clean();

?>