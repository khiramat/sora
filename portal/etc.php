<!--
10 その他ご報告、総括
-->
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "subject">
	10 その他ご報告、総括
</section>
<section id = "paragraph">
	<?php
	$last_monday = date("Y-m-d", strtotime('monday previous week'));
	$etc_data = "";
	$result   = $this -> insert_form_model -> get_etc_data($last_monday);
	foreach($result as $key => $value){
		$etc_data   = $value["ETC_DETAIL"];
	}
	echo nl2br($etc_data);
	?>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
