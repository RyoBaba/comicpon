<div class='sort_list_box'>
<?php
	$sort_list = Configure::read('Raku.sort');
	echo "並び替え：　<select class='sort_change'>";
	foreach($sort_list as $key=> $name){
		echo "<option value='{$key}'>{$name}</option>";
	}
	echo "</select>";
?>
</div>
