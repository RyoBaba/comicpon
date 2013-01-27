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

</style>

<h2>登録タイトル一覧</h2>

<div id='vowelList'>
	<?php
		//pr( Configure::read('Hiragana') );
		$vowel_list = Configure::read('Hiragana');
		foreach($vowel_list as $cat_name => $list){
			echo "<div id='Vowel{$i}' class='vowel_list'>";
			echo "<a href='{$save_title_action}?vcat={$cat_name}' class='cat'>" . $cat_name 
				. "のタイトルを探す</a>｜";
			foreach($list as $idx => $vowel){
				echo "<a href='{$save_title_action}?vowel={$i}' class='vowel'>" . $vowel 
					. "</a>｜";
			}
			echo "</div>";
		}
	?>
</div>


