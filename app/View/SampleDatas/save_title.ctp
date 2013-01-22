<?php
	$head_text = ($rtn['flag']) ? "<h1>タイトル情報を保存しました</h1>" : "<h1>タイトル情報更新中に異常が発生しました。</h1>";
?>

<div>
	<?php
		if( $rtn['flag'] ){
			echo "新しく追加したタイトル件数は" . number_format($rtn['ins_cnt']) . "件です。";
		}
	?>
</div>