<?php
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
<div class="wrap">
 <table class="wp-list-table widefat fixed striped table-view-list posts">
     <thead>
         <tr>
             <th>ID</th>
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