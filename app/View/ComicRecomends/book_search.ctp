<?php
	$book_list_action = Router::url( array('controller'=>'ComicRecomends', 'action'=>'book_list') );
	$this->Html->css("parts_set", null, array('inline'=>false));
	
$script = <<<SCRIPT
	
	$(document).ready(function(){
		$("#clear").click(function(){
			$('#search_in input').each(function(){
				$(this).val('');
			});
		});
	});
	
SCRIPT;
	
	$this->start('script');
	echo $this->Cp->scriptBlock($script);
	$this->end();
?>

<h2>書籍検索</h2>

<form action="<?php echo $book_list_action; ?>" method="get" id="book_search">
<table id="search_in" class="search_in">
<tr>
	<th>検索キーワード</th>
	<td>
		<input type="text" name="keyword" placeholder="検索キーワード（複数指定は半角スペース区切り）">
	</td>
</tr>
<tr>
	<th>ISBNコード</th>
	<td>
		<input type="text" name="isbn" placeholder="ISBNコード"><br>
		<small>※ISBNダイレクト検索もお試し下さい</small>
	</td>
</tr>
</table>
<input type="button" value="条件クリア" id="clear">
<input type="submit" value="検索">
</form>
