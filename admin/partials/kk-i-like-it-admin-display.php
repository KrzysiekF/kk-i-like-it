<?php
    $db = new Kk_I_Like_It_DB();
?>

<div id="kk-i-like-it__dashboard">
    <div class="kk-i-like-it__dashboard--container">
        <header>
            <h3><?php echo __('Welcome to KK I Like It statistics panel!') ?></h3>
        </header>

        <div class="kk-i-like-it__dashboard--widget kk-i-like-it__dashboard--widget-likes-count">
            <header><?php echo __('Total Likes'); ?></header>
            <div class="kk-i-like-it__big-number">
                <?php echo $db->getLikesNumber(); ?>
            </div>
        </div>

        <div class="kk-i-like-it__dashboard--widget kk-i-like-it__dashboard--widget-recent-likes">
            <header><?php echo __('Recently Liked'); ?></header>
            <?php
                $likes = $db->getInformation(5);
                if(!empty($likes)){
                    foreach($likes as $row):
                    
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

        <div class="kk-i-like-it__dashboard--widget kk-i-like-it__dashboard--widget-top-liked">
        <header>TOP 5</header>
        <?php
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

        <div class="kk-i-like-it__dashboard--widget kk-i-like-it__dashboard--widget-likes">
            <header><?php echo __('Number of likes in last 30 days (by day)'); ?></header>
            <?php
                $chartData = $db->getTopLikesFrom(null, 30);
            ?>
            <div id="kk-i-like-it__chart"></div>
        </div>

        <footer>
            Krzysztof Furtak &copy; Copyright 2018
        </footer>
    </div>
</div>

<script>
(function ($) {
    $(function () {
        const allDataToJS = {};
        const labels = [];
        const series = [];
        const startDay = moment();
        const daysLimit = 30;

        for (var index = 0; index < daysLimit; index++) {
            allDataToJS[startDay.format('DD-MM-YYYY')] = 0;

            startDay.subtract(1, 'd');
        }

        <?php foreach ($chartData as $key => $value): ?>
            allDataToJS['<?php echo date('d-m-Y', strtotime($value->date)); ?>'] = <?php echo $value->count; ?>;
        <?php endforeach; ?>

        for (const key in allDataToJS) {
            if (allDataToJS.hasOwnProperty(key)) {
                const element = allDataToJS[key];
                labels.push(key);
                series.push(element);
            }
        }

        var options = {
            height: 300,
            low: 0,
            showArea: true
        };

        var data = {
            labels: labels.reverse(),
            series: [series.reverse()]
        };

        new Chartist.Line('#kk-i-like-it__chart', data, options);
    });
})(jQuery);
</script>
