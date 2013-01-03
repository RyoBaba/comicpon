<?php
	//pr($item_datas);
	$book_list_action = Router::url(array('controller'=>'ComicRecomends', 'action'=>'book_list'));

	$this->Html->css("parts_set", null, array('inline'=>false));

$script = <<<SCRIPT
	
	$(document).ready(function(){
		$("#page_change").change(function(){
			location.href = "{$book_list_action}?page=" + $(this).val();
		});
		$(".sort_change").change(function(){
			location.href = "{$book_list_action}?srt=" + $(this).val();
		});
	});
	
SCRIPT;
	
	$this->start('script');
	echo $this->Cp->scriptBlock($script);
	$this->end();


?>

<h2>該当した書籍リスト</h2>

<article>
	<header>
		<h3>全体情報</h3>
		<div>
			<?php
				echo "該当件数：" . number_format($item_datas['count']) . "件<br>";
				echo "現在ページ：";
				echo "<select id='page_change'>";
				for($i=1; $i<=$item_datas['pageCount']; $i++){
					$_sel = ($i==$item_datas['page']) ? " selected" : "";
					echo "<option value='{$i}' {$_sel}>{$i}</option>";
				}
				echo "<select>";
				echo "／" . $item_datas['pageCount'];
			?>
		</div>
	</header>
</article>

<?php
	echo $this->element('ComicRecomends_book_list_sort_change');
?>

<table>
<tr>
	<th># </th>
	<th>書籍名</th>
	<th>著者名</th>
	<th>出版社名</th>
	<th>選択</th>
</tr>
<?php
	foreach( $item_datas['Items'] as $idx => $item ){
		$_no = $idx + 1;
		
		echo "<tr>";
		echo "<td>{$_no}</td>";
		
		echo "<td>" . $item['Item']['title'] . "</td>";
		echo "<td>" . $item['Item']['author'] . "</td>";
		echo "<td>" . $item['Item']['publisherName'] . "</td>";
		echo "<td>" . "<input type='checkbox' name='addItem' value='" 
			.$item['Item']['isbn'] . "'>" 
			."</td>";
		echo "</tr>";
	}
?>
</table>