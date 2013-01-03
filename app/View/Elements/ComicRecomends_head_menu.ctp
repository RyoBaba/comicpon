<?php
	$isbn_search_action = Router::url(array('action'=>'search'));
	$genre_search_action = Router::url(array('action'=>'book_search_by_genre'));
	$keyword_search_action = Router::url(array('action'=>'book_search'));
?>

<header style="background-color: #CCCCCC; padding: 12px;width:100%;color:#EFEFEF;">
<a href="<?php echo $isbn_search_action; ?>">ISBN検索</a>｜
<a href="<?php echo $genre_search_action; ?>">ジャンル検索</a>｜
<a href="<?php echo $keyword_search_action; ?>">キーワード検索</a>
</header>