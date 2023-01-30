<!-- title page -->
<article class = "sheet">
	<div class="top_page">
		<section id = "atesaki">
			株式会社LogicLinks御中
		</section>
		<section id = "main">
			LinksMate モバイルネットワーク<br>
			週次運用報告書
		</section>
		<section id = "period">
			データ取得期間：<?=get_report_last_monday()?> 〜 <?=get_report_last_sunday()?><br>
			報告⽇：<?=get_report_submission_day()?>
		</section>
		<section id = "logo">
			<img src = "<?=base_url()?>assets/images/ranger_newlogo-big.png">
		</section>
	</div>
</article>

<?php $this -> load -> view('layout/page_break'); ?>
<section class = "subject">
	本書の目的<br>
	品質維持と向上のために本書を用い、適切な帯域運用を行うことを目的としております。
</section>
<section class = "paragraph">
	■ 原則
</section>
<section class = "paragraph">
	<ul>
		<li>契約帯域を十分に活用できている状態であること</li>
		<li>ゲーム通信において、一切のストレスが無く利用できること</li>
		<li>それ以外の通信においても、他社事業者よりも高い品質を維持すること</li>
	</ul>
</section>
<section class = "paragraph">
■ 土管ごとの品質基準（仮）
</section>
<section class = "paragraph">
	<ul>
		<li>カウントフリー土管に十分な帯域が割り当てできていて、トラフィックグラフ上でバーストしていないこと</li>
<li>それ以外の高速ルール用土管が輻輳していないこと</li>
<li>低速ルール用土管が著しく輻輳していないこと</li>
	</ul>
</section>
<section class = "paragraph">
上記が基準を満たしていない、あるいは直近で満たさなくなることが予見できる場合は、以下2点の対策を検討する。
</section>
<section class = "paragraph">
	<ul>
		<li>①全体帯域の増速を計画する</li>
		<li>②土管ごとの帯域割り当て比率の変更を計画する</li>
	</ul>
</section>
<section class = "paragraph">
※場合によっては、アプリケーションごとのスループット制御も検討
</section>

<?php $this -> load -> view('layout/page_footer'); ?>
