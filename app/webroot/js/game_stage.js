
/*
 * [M]GameStage クラス
 */
//var GameStage = function(){};

var GameStage = (function(){

	/* 
	 * Const
	 */
	var HAERT = 0, SPADE = 1, CLUB = 2, DIA = 3, JOKER = 4;
	var CARDS = [
		[1,2,3,4,5,6,7,8,9,10,11,12,13],
		[1,2,3,4,5,6,7,8,9,10,11,12,13],
		[1,2,3,4,5,6,7,8,9,10,11,12,13],
		[1,2,3,4,5,6,7,8,9,10,11,12,13],
		[1,2]	//ジョーカースートのみ数字に意味は無し
	];
	var PLAYER_MIN_COUNT = 2;
	var PLAYER_MAX_COUNT = 10;

	/*
	 * Properties
	 */
	var game_id = null;				//ゲームID
	var player_cnt = 0;		//プレーヤー人数
	var players = new Array();	//プレーヤー配列
	var deck = new Array();	//デッキ：デッキ枚数分の要素数を持つ配列（各要素は全てCardのインスタンスとする）

	function initCard () {
		this.deck = new Array();
		//カード定義順にデッキにカードを配列する
		for( var suit=0; suit<=4; suit++ ){
			for( var _idx in CARDS[suit] ) {
				this.deck.push( new Card(suit, CARDS[suit][_idx]) );
			}
		}
	};

	//(SUB)カードシャッフル
	function shuffleCard () {
		for(i=0; i<=53; i++){
			w = deck[i];
			r = Math.floor(Math.random()*(13*4+2));
			this.deck[i] = deck[r];
			this.deck[r] = w;
		}
	};

	/*
	 * Methods
	 */	
	// 初期化（ゲームID, デッキ）
	this.init = function() {
		this.setGameId();
		player_cnt = 2;	//初期値は２
		initCard();
		shuffleCard();
	}
	this.setGameId = function() { game_id = new Date().getTime(); };
	this.getGameId = function() { return game_id; };
	this.playerCnt = function(_cnt) { 
		if(typeof _cnt != "undefined"){
			player_cnt = _cnt; return player_cnt;
		}
		return player_cnt;
	};
	this.players = function(_players){
		if(typeof _players == "undefined"){
			return players;
		} else {
			players = new Array();
			for(var i in _players){
				players.push( new Player(game_id, _players[i].name, _players[i].url) );
			}
		}
	}


	//---- ゲーム中処理群 ------------------------

	//---- ゲーム終了処理群-----------------------

	return this;

});

/*=======================================================
 	MODELS
 =======================================================*/
/*
 * Card
 */
var Card = function(suit, num) {
	this.suit = suit;
	this.num = num;
};
/*
 * Player
 */
var Player = function(id,name,url){
	this.id = id;
	this.name = name;
	this.url = url;
	return this;
}
/*
 * Flow
 */
var Flow = function() {
	this.ACTION_HAND = "hand";
	this.ACTION_PASS = "pass";
	this.player_id = null;
	this.action = null;
	this.card = null;
	this.init = function() {

	}
}



