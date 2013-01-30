<?php

$save_title_action = Router::url(array('controller'=>'TitleViews', 'action'=>'search'));

/*
$script = <<<SCRIPT
	
	$(document).ready(function(){
		$('#inputData').click(function(){
		
		
		//alert("<!DOCTYPE html>aafjsdfjk;sldkflsdkf<bodyここここここここここ</body></html>".replace(/DOCTYPE.+\\<body/, ""))
		alert("<!DOCTYPE html>aafjsdfjk;sldkflsdkf<bodyここここここここここ</body></html>".replace(/\\/body.*$/, ""))
		
			_baseTxt = $('#base_html').val();
			_baseTxt = _baseTxt.replace(/[\\\\n\\\\r]/g, "");
			_baseTxt = _baseTxt.replace(/DOCTYPE.+\\<body/, "");
			_baseTxt = _baseTxt.replace(/\\/body.*$/, "");
			$('#outArea2').val(_baseTxt);
			
		});
	});
	
SCRIPT;
	
	$this->start('script');
	echo $this->Cp->scriptBlock($script);
	$this->end();
*/

	$this->Html->script('htmltextparse.js', array('inline' => false));	
?>

<style>
.vowel_list{
	background-color: #FCFCFC;
	padding: 6px;
	margin: 12px 0;
}

.vowel_list a {
	padding: 6px;
	border-radius: 8px;
	text-decoration: none;
}
.vowel_list a:hover{
	color: #FCFCFC;
}
.vowel_list a.cat {
	background-color: #CCCCFF;
}
.vowel_list a.cat:hover {
	background-color: #9999FF;
}
.vowel_list a.vowel {
	background-color: #FFCCCC;
}
.vowel_list a.vowel:hover {
	background-color: #FF9999;
}
span.number {
	display: inline-block;
	margin-right: 4px;
	border: solid 1px #CCCCCC;
	padding: 4px;
}
</style>

<h2>タイトル</h2>

<div id='titleList'>
	<?php
		echo "<span class='number'>" .$this->Paginator->prev("前へ") . "</span>";
		echo "<span class='number'>". $this->Paginator->numbers(array('separator'=>'</span><span class=\'number\'>')) . "</span>";
		echo "<span class='number'>" .$this->Paginator->next("次へ") . "</span>";
	?>
	<table>
		<tr>
			<th>頭文字</th>
			<th>タイトル</th>
			<th>説明</th>
			<th>Wikipediaリンク</th>
		</tr>
		<?php //description
			foreach( $title_data as $title ){
				echo "<tr>";
				echo "<td>" . $title['CptTitleMas']['vowel'] . "</td>";
				echo "<td>" . $title['CptTitleMas']['title'] . "</td>";
				echo "<td>" . $title['CptTitleMas']['description'] . "</td>";
				echo "<td><a href='" . h($title['CptTitleMas']['wikiurl']) . "' target='_blank'>Wiki</a></td>";
				echo "</tr>";
			}
		?>
	</table>
</div>


