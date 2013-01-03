<?php
	$isbn_search_action = Router::url(array('action'=>'search'));
	$genre_search_action = Router::url(array('action'=>'book_search_by_genre'));
	$keyword_search_action = Router::url(array('action'=>'book_search'));
?>

<h2>書籍検索メニュー</h2>
<ul>
	<li>
		<a href="<?php echo $isbn_search_action; ?>">ISBNダイレクト検索</a>
	</li>
	<li>
		<a href="<?php echo $genre_search_action; ?>">ジャンル検索</a>
	</li>
	<li>
		<a href="<?php echo $keyword_search_action; ?>">キーワード検索</a>
	</li>
</ul>