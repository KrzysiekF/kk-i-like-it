<?php
    require_once PLUGIN_PATH . 'includes/class-kk-i-like-it-db.php';
?>

<div class="kk-i-like-it__list-box">
    <?php
        $db = new Kk_I_Like_It_DB;
        $dane = $db->getInformation('10');
        if(!empty($dane)){
        foreach($dane as $row):
        
    ?>
        <div class="kk-i-like-it__list-element">
            <div class="kk-i-like-it__list-text" style="width: 100%;">
                At <strong><?php echo date('H:i', strtotime($row['date'])); ?></strong> on <strong><?php echo date('d-m-Y', strtotime($row['date'])); ?></strong>, user <strong><?php echo $row['user']; ?></strong> liked article "<strong><?php echo $row['post_name']; ?></strong>".
                <div class="kk-i-like-it__ip">IP: <?php echo $row['ip']; ?></div>
            </div>
        </div>
    <?php
        endforeach;
        }else{
    ?>
        <div class="kk-i-like-it__list-element">
            <div class="kk-i-like-it__list-text">
                <?php echo __('I\'m sorry, at this moment there are no data to display','kk-i-like-it__langs'); ?>
            </div>
        </div>
    <?php
        }
    ?>
</div>