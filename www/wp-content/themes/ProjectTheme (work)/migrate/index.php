<?php

$action = (isset($_POST['action']))? $_POST['action'] : '';
$display_log = 'display: none;';

switch ($action) {
    case 'up':
        $success = migrate_up();
        break;
    
    case 'down':
        $success = migrate_down();
        break;

    default:
        $success = false;
        break;
}

$display_log = ($success)? 'display: done;' : 'display: none;';


?>
<div style="<?php echo $display_log?>">
    
    <span><?php echo $action ?> complited!</span>
    
</div>


<div>
<form method="post">
    <input type="hidden" name="action" value="up" />
    <input type="submit" id="up" class="btn btn-default" value="UP">
</form>    
    
<form method="post">
    <input type="hidden" name="action" value="down" />
    <input type="submit" id="up" class="btn btn-default" value="DOWN">
</form>
    
</div>


    
    
<?php 

function migrate_up() {
    
    global $wpdb;
    
    $query = 'ALTER TABLE `wp_project_bids` '
            . 'ADD `paid_user_date` bigint(20) NOT NULL AFTER `date_choosen`, ' .
            'ADD `outstanding` tinyint(4) NOT NULL AFTER `paid_user_date`, ' .
            'ADD `delivered` tinyint(4) NOT NULL AFTER `outstanding`, ' . 
            'ADD `mark_coder_delivered` tinyint(4) NOT NULL AFTER `delivered`, ' . 
            'ADD `mark_seller_accepted` tinyint(4) NOT NULL AFTER `mark_coder_delivered`, ' . 
            'ADD `mark_coder_delivered_date` bigint(20) NOT NULL AFTER `mark_seller_accepted`, ' . 
            'ADD `mark_seller_accepted_date` bigint(20) NOT NULL AFTER `mark_coder_delivered_date`, ' . 
            'ADD `expected_delivery` bigint(20) NOT NULL AFTER `mark_seller_accepted_date`' ;
    $result = $wpdb->query($query);
    
    
    
    $query = 'ALTER TABLE `wp_project_escrow` ' .
             'ADD `bid` int(11) NOT NULL AFTER `pid`';
    $result = $wpdb->query($query);
    
    return $result;
    
}

function migrate_down() {
    
    global $wpdb;
    
    $query = 'ALTER TABLE `wp_project_bids` DROP `outstanding`, '
            . 'DROP `delivered` IF EXISTS, '
            . 'DROP `paid_user_date` IF EXISTS, '
            . 'DROP `mark_coder_delivered` IF EXISTS, '
            . 'DROP `mark_seller_accepted` IF EXISTS, '
            . 'DROP `mark_coder_delivered_date` IF EXISTS, '
            . 'DROP `mark_seller_accepted_date` IF EXISTS, '
            . 'DROP `expected_delivery` IF EXISTS'
            . '';
    $result = $wpdb->query($query);
    
    $query = 'ALTER TABLE `wp_project_escrow` DROP `bid`';
    $result = $wpdb->query($query);
    
    return $result;
    
}

?>