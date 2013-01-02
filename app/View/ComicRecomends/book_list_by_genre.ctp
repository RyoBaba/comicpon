<?php
	//pr($item_datas);
?>

<h2>該当した書籍リスト</h2>

<article>
	<header>
		<h3>全体情報</h3>
		<div>
			<?php
				echo "該当件数：" . number_format($item_datas['count']) . "件<br>";
				echo "現在ページ：" . $item_datas['page'] . "/" . $item_datas['pageCount'] . "<br>";
			?>
		</div>
	</header>
</article>

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