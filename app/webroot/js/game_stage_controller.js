/*
 * [C]GameStageConroller
 */
var GameStageController = (function(){

	/*
	 * Local
	 */
	var jQs = {
		GameStage_config_box: null
		, mainBox: null
	};
	var gameStage = null, stageView = null;

	/*
	 * Mthods
	 */
	this.openBox = function(selector){
		$('.stageParts').each(function(){
			var thisId = selector.attr('id');
			if($(this).attr('id')==thisId){
				$(this).slideDown();
			} else {
				$(this).slidUp();
			}
		});
	};

	/*
		画面読み込み時初期処理
		-- GameStageオブジェクトを生成し、ゲームID発行／デッキの初期化
		-- Playerエントリーフォーム(configBox)をオープン
	*/
	this.init = function(){

		console.log("GameStageController start!!");
		
		//セレクタキャッシュ一括取得
		for(var strId in jQs){
			jQs.strId = $('#'+strId);
		}

		//GameStage インスタンス生成
		gameStage = new GameStage();
		gameStage.init();


		//configBoxオープン
		return;

	};

	this.setPlayerCnt = function(){
		return gameStage.playerCnt(_cnt);
	}
	this.playerInfoArea = function(){
		_html = "";
		for(var i=1; i<=gameStage.playerCnt(); i++){
			_html += "<fieldset><legend>プレーヤー" + i + "</legend>" 
				+ "NAME:<input type='text' id='playerName"+i+"' value=''>"
				+ "　　　URL:<input type='text' id='playerUrl"+i+"' value=''><br>"
				+ "</fieldset>"
		}
		_html += "<input type='button' id='submitPlayerInfo' value='プレーヤー情報入力完了'>";
		$('#playerSetArea').append(_html);
		
	}
	this.setPlayerInfo = function() {
		_players = new Array();
		for(var i=1; i<=gameStage.playerCnt(); i++ ){

			_players.push( {
				name: $('#playerName'+i).val(),
				url: $('#playerUrl'+i).val()
			} );
		}
		gameStage.players(_players);
	};

	return this;

})();


$(document).ready(function(){

	//ページ読み込み時初期処理
	GameStageController.init();
	GameStageView.init();

	//設定ウィンドウ周り
	$('#submitConfig').click(function(){
		_cnt = ~~$('#player_cnt').val();
		if(_cnt > 1 && _cnt < 10) {
			GameStageController.setPlayerCnt(_cnt);
			GameStageController.playerInfoArea();
		} else {
			alert("人数は２人以上10人未満です");
		}
	});
	$('#submitPlayerInfo').live('click', function(){
		GameStageController.setPlayerInfo();
	});


});