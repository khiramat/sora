<div class="container pb-1">
    <?php $current_url = uri_string(); ?>
    <div id="nav-menu">
        <ul>
            <li class="<?php if (stripos($current_url, 'home/index') === 0)
            ?>">
                <a href="/report_sora/setup/base_value">Home</a>
            </li>
            <li class="<?php if (stripos($current_url, 'throughput/') === 0)
                echo 'active'; ?>">
                <a href="<?php echo site_url('/traffic_analytics/line'); ?>" target="_blank">月次報告書</a>
            </li>
            <li class="<?php if (stripos($current_url, 'setup/') === 0)
                echo 'active'; ?>">
                <a href="<?php echo site_url('/setup/base_value'); ?>">設定・データ登録</a>
                <div class="sub-menu">
                    <a href="<?= site_url('setup/base_value/index') ?>"
                       class="<?php if (stripos($current_url, 'setup/base_value') === 0)
                           echo 'active'; ?>">帯域基準値設定</a>
                    <a href="<?= site_url('setup/bandwidth/index') ?>"
                       class="<?php if (stripos($current_url, 'setup/bandwidth') === 0)
                           echo 'active'; ?>">帯域設定</a>
                    <a href="<?= site_url('setup/work') ?>" class="<?php if (stripos($current_url, 'setup/work') === 0)
                        echo 'active'; ?>">作業報告情報</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="ui divider"></div>
</div>
