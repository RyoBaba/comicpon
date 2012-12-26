<?php
	$result_action = Router::url(array('controller'=>'ComicRecomends', 'action'=>'result'));
?>

<h2>マンガレコメンダー</h2>
<div class="description">
	<h3>使い方</h3>
	<ul>
		<ol>好きなマンガのISBNコードを入力！</ol>
		<ol>「オススメマンガを探す」ボタンを押す！</ol>
	</ul>
	<br>
	<p>たったこれだけです。<br>
	さっそくためしてみよう！！
	</p>
</div>
<form action="<?php echo $result_action; ?>" method="post">
	<input type="text" name="isbn" placeholder="ISBN書籍コード(単行本裏表紙の上のバーコード番号)" class="search_text" size="13">
	<input type="submit" value="オススメマンガを探す" class="search_comic" >
</form>