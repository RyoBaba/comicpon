<?php

$save_title_action = Router::url(array('controller'=>'SampleDatas', 'action'=>'save_title'));

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



<h2>登録タイトル一覧</h2>

<div id='vowelList'>
	<?php
		pr( Configure::read('Hiragana') );
	?>
</div>