<?php
	$genre_search_action = Router::url(array('controller'=>'ComicRecomends', 'action'=>'book_search_by_genre'));

	//外部スクリプトファイルの場合
	//$this->Html->script('jquery.1.8.3', array('inline'=>false));

	$this->start('script');
	echo $this->element('ComicRecomends_genre_search');
	$this->end();


?>
<h2>ジャンル検索</h2>

<table>
<tr>
	<th>#</th>
	<th>ジャンル名</th>
	<th>検索</th>
</tr>
<?php
	
	//pr($genre_data['current']);
	//pr($genre_data['children']);

	foreach($genre_data['children'] as $idx => $data ){
		$_no = $idx + 1;
		echo "<tr>";
		echo "<td>{$_no}</td>";
		echo "<td>"
		    ."<a href='" . $genre_search_action . "/" . $data['child']['booksGenreId'] . "'>" . $data['child']['booksGenreName'] . "</a>"
		    ."　<span style='font-size:66%'>["
		    ."<a href='" . $genre_search_action . "/" . $data['child']['booksGenreId'] . "'>詳しい分類</a>"
		    ."]</span>"
		    ."</td>";
		echo "<td>" 
			. "<input data-genre-id='" . $data['child']['booksGenreId'] . "' type='button' value='検索' class='bookSearchByGenre'>" 
			. "</td>";
		echo "</tr>";
	}
?>
</table>