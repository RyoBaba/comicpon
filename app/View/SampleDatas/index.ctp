<?php
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

?>
<script>
	$(document).ready(function(){
		$('#inputData').click(function(){
		
			_baseTxt = $('#base_html').val();
			_baseTxt = _baseTxt.replace(/[\n\r]/g, "");
			_baseTxt = _baseTxt.replace(/DOCTYPE.+\<body/, "");
			_baseTxt = _baseTxt.replace(/\/body.*$/, "");
			_baseTxt = _baseTxt.replace(/script/g, "div");
			//$('#outArea2').val(_baseTxt);
			$('#outArea1').append( _baseTxt );
			
		});
	});
</script>


<style type="text/css">
#inArea {
	padding: 12px;
	border-bottom: solid 1px #CCC;
}

#outArea1 {
	#height: 20px;
	overflow: hidden;
}

</style>


<h1>テスト</h1>

<div id="inArea">
	<textarea id="base_html" rows="5" cols="80" ></textarea><br>
	<input type="button" id="inputData" value="ベースHTML取り込み">
</div>

<div id="outArea1"></div>
