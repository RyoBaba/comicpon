<?php
	//データの解析
//	$data_cnt = $item_data->count;
?>

<article>
<h1>
<?php
/*
	if( $data_cnt == 0 ){
		echo "該当するマンガが見つかりませんでした。";
	} else {
		echo $data_cnt . "件のマンガが見つかりました。";
	}
*/
?>

</h1>

<?php
	//検索結果をリスト表示
	foreach($item_data as $item){
		
		$item = $item['CptComic'];
		
		$item_title = $item['book_title'];
		$item_author = $item['author'];
		$item_sales_date = $item['sales_date'];
		$item_vol = "※取得方法検討中";
		$item_publisher = $item['publisher'];
		$item_price = $item['price'];
		$item_image_url = $this->webroot . BOOK_IMAGE_DIR_NAME . DS . $item['item_image'];
		$item_affiliate_rakuten_url = $item['afili_raku'];
		
		echo "<h3>{$item_title}</h3>";
		echo "<img src='{$item_image_url}' width='200' alt='{$item_title}表紙画像'>";
		echo "<table>";
		
		echo "<tr>";
		echo "<th>著者名</th>";
		echo "<td>{$item_author}</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<th>初版発行</th>";
		echo "<td>{$item_sales_date}</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<th>出版社</th>";
		echo "<td>{$item_publisher}</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<th>価格</th>";
		echo "<td>{$item_price}</td>";
		echo "</tr>";

		echo "</table>";
		
		echo "<a href='{$item_affiliate_rakuten_url}' target='_blank'>";
		echo "この本を楽天ブックスで購入する";
		echo "</a>";
		
	}
	
	
	
?>

</article>