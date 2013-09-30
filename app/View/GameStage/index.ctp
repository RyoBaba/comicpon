<?php
	//ゲームオブジェクトに対する処理はこちらに（外部からコールするメソッドはパブリックなメソッドとして定義する）
	$this->Html->script("game_stage",array("inline"=>false));

	//表示周り制御
	$this->Html->script("game_stage_view",array("inline"=>false));

	$this->Html->script("game_stage_controller",array("inline"=>false));
?>


<!-- #content -->
<div id="content">

	<!-- GameStage_config_box -->
	<div id="GameStage_config_box" class="stageParts" style="display:none;" >
		<?php echo $this->element('GameStage_config_box'); ?>
	</div>

</div>
