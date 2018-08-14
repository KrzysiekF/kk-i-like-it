<?php
    require_once KKILIKEIT2_PATH . 'includes/class-kk-i-like-it-db.php';
?>
<div class="kk-i-like-it__list-box">
    <?php
        $db = new Kk_I_Like_It_DB;
        $dane = $db->getTopPosts('5');
        $numberLikes = $db->getLikesNumber();


        if(!empty($dane) && $numberLikes > 0){
            $i = 1;
            foreach($dane as $row):
                $perc = floor(($row->meta_value / $numberLikes) * 100);
            ?>
            <div class="kk-i-like-it__list-element kk-i-like-it__stat">
                <div class="kk-i-like-it__list-text" style="width: 100%;">
                    <strong><span class=""><?php echo $i; ?>.</span> <a href="<?php echo get_permalink($row->ID); ?>" target="_blank"><?php echo $row->post_title; ?></a></strong>.
                </div>
                <div class="kk-i-like-it__likes"><?php echo $row->meta_value . ' ' . __('likes','kk-i-like-it__langs'); ?></div>
                <div class="kk-i-like-it__stat-bg" style="width: <?php echo $perc; ?>%;"></div>
            </div>
            <?php
                $i++;
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
