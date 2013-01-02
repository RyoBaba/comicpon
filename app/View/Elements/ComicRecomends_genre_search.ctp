<?php

$book_list_by_genre_action = Router::url(array('controller'=>'ComicRecomends','action'=>'book_list_by_genre'));

$str = <<<SCRIPT
		
	$(document).ready(function(){
		
		$('.bookSearchByGenre').click(function(){
			location.href = '{$book_list_by_genre_action}/' + $(this).data('genreId');
		});
		
	});
		
SCRIPT;
	
	echo "<script type='text/javascript'><!--" . $str . "--></script>";
?>