<?php
/**
 * Created by PhpStorm.
 * User: khiramat
 * Date: 2018/08/03
 * Time: 20:31
 */
ini_set('display_errors', "Off");
?>
<article class = "sheet">
    <?php
    $h1 = "SORAシム株式会社 御中";
    ?>
    <header>
        <h1><?=$h1?></h1>
        <div class = "header"></div>
    </header>
    <section>
        月次報告書
    </section>
    <section>2018年 8月 日

    </section>
    <footer>
    </footer>
</article>

<article class = "sheet">
    <?php
    $h1 = "目次";
    ?>
    <header>
        <h1><?=$h1?></h1>
        <div class = "header"></div>
    </header>
    <section>
        <ol>
            <li>帯域状況について</li>
            <li>ハードウェアメンテナンス結果について</li>
            <li>帯域運用について</li>
            <ol>
                <li>トラフィック量の推移(全体/時間別)</li>
                <li>接続者数の推移</li>
                <li>主要サービスについて</li>
            </ol>
            <li>速度測定結果について(LTE/3G)</li>
            <ol>
                <li>LTE RBB</li>
                <li>3G RBB</li>
            </ol>
            <li>アラート報告</li>
            <li>作業報告
            </li>
        </ol>
    </section>
    <footer>
        <address>(c) 2007 - <?php echo date("Y"); ?> Ranger Systems Co., Ltd. all rights reserved.</address>
    </footer>
</article>


<article class = "sheet">
    <?php
    $h1 = "帯域状況について";
    ?>
    <header>
        <h1><?=$h1?></h1>
        <div class = "header"></div>
    </header>
    <section>今月の結果をもとに、帯域の未来予測をご報告致します。</section>
    <section>
        <div id = "line1"
             style = "width: 90%; height: 100mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <section>先月の予測の通り、前月と比較すると緑ゾーンが減少していき、黄～赤ゾーンへ結果が推移しておりました。<br>
        <?=$this_month?>月に関しまして、赤ゾーンの結果が出始めてきており、このままの状態ですと8月には割合が逆転することが予測されます。<br><br>

    </section>
    <footer>
        <address>(c) 2007 - <?php echo date("Y"); ?> Ranger Systems Co., Ltd. all rights reserved.</address>
    </footer>
</article>


<article class = "sheet">
    <?php
    $h1 = "ハードウェアメンテナンス結果について";
    ?>
    <header>
        <h1><?=$h1?></h1>
        <div class = "header"></div>
    </header>
    <section><?=$this_month?>月中のハードウェアメンテナンスについてご報告致します。</section>
    <section>
        <div id = "line1"
             style = "width: 90%; height: 100mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <section>なお、詳細のステータス確認結果は、以下ファイルをご参照ください。<br><br>

        ▼ファイル名<br>
        SORAシム株式会社御中_MNOダイレクトプロジェクト_月次報告書（2018年<?=$this_month?>月).pdf

    </section>
    <footer>
        <address>(c) 2007 - <?php echo date("Y"); ?> Ranger Systems Co., Ltd. all rights reserved.</address>
    </footer>
</article></article>
