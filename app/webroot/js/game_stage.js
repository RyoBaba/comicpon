//定数
 //スート定数
var HAERT = 0, SPADE = 1, CLUB = 2, DIA = 3, JOKER = 4;
//カード雛形
var CARDS = [
	[1,2,3,4,5,6,7,8,9,10,11,12,13],
	[1,2,3,4,5,6,7,8,9,10,11,12,13],
	[1,2,3,4,5,6,7,8,9,10,11,12,13],
	[1,2,3,4,5,6,7,8,9,10,11,12,13],
	[1,2]	//ジョーカースートのみ数字に意味は無し
];
//プレーヤー最小人数
var PLAYER_MIN_COUNT = 2;
//プレーヤー最大人数
var PLAYER_MAX_COUNT = 10;
//カード所持状態コード（0:未所持, 1:所持, 9:場に捨てられている)
var HAVE_STAT_NO = 0, HAVE_STAT_YES = 1, HAVE_STAT_DROP = 9;
//通信タイプ (1:初期通信, 2:手番, 9:ゲーム終了)
var REQ_TYPE_START = 1, REQ_TYPE_TURN = 2, REQ_TYPE_END = 9;


/*
 * [M]GameStage クラス
 */
//var GameStage = function(){};

var GameStage = (function(){


	//return Object
	return {

		/*
		 * Properties
		 */
		game_id : null,				//ゲームID
		player_cnt : 0,		//プレーヤー人数
		players_arr : new Array(),	//プレーヤー配列
		player_card_arr: new Array(), 	
		deck : new Array(),	//デッキ：デッキ枚数分の要素数を持つ配列（各要素は全てCardのインスタンスとする）
		card_cnt: 0,

		/*
		 * Methods
		 */	
		// 初期化（ゲームID, デッキ）
		init : function() {
			this.setGameId();
			this.player_cnt = 2;	//初期値は２
			this.initCard();
			this.shuffleCard();
		},
		initCard : function () {
			this.deck = new Array();
			//カード定義順にデッキにカードを配列する
			for( var suit=0; suit<=4; suit++ ){
				for( var _idx in CARDS[suit] ) {
					this.deck.push( new Card(suit, CARDS[suit][_idx]) );
					this.card_cnt++;
				}
			}
		},

		//(SUB)カードシャッフル
		shuffleCard :function () {
			for(i=0; i<=53; i++){
				w = this.deck[i];
				r = Math.floor(Math.random()*(13*4+2));
				this.deck[i] = this.deck[r];
				this.deck[r] = w;
			}
		},
		setGameId : function() { this.game_id = new Date().getTime(); },
		getGameId : function() { return this.game_id; },
		playerCnt : function(_cnt) { 
			if(typeof _cnt != "undefined"){
				this.player_cnt = _cnt; 
			}
			return this.player_cnt;
		},
		players : function(_players){
			if(typeof _players != "undefined"){
				this.players_arr = new Array();
				for(var i in _players){
					this.players_arr.push( new Player(this.game_id, _players[i].name, _players[i].url) );
				}
			}
			return this.players_arr;
		},
		initGame : function() {
			//[1]プレーヤーにカードを配布
			var _player_idx = 0;
			for(var i = 0; i < this.card_cnt; i++ ){
				tmp = this.deck[i];
				tmp.have = HAVE_STAT_YES;
				this.players_arr[_player_idx].cards.push( tmp );
				_player_idx = ((_player_idx + 1) == this.player_cnt) ? 0 : _player_idx + 1;
			}
			//[2]各プレーヤーのAPIにカード情報をPOST送信
			for( var i in this.players_arr ){
				this.initAjaxSend( this.players_arr[i] );
			}
			//[3]ゲーム開始待機状態へ
		},
		initAjaxSend : function( playerData ) {
			var postData = {
				type : REQ_TYPE_START,	//通信タイプ
				info : playerData,		//プレーヤーデータ
				rule : new Array()		//特殊ルールフラグ
			};
			$.ajax({
				url    : playerData.url,
				type   : "POST",
				data   : postData,
				assync : false,
				success: function( data ){
					console.log("success::init "+playerData.id);
				},
				error  : function( e ) {
					console.log("ERROR!!");
				}
			});
		},
		__DMY : null


		//---- ゲーム中処理群 ------------------------

		//---- ゲーム終了処理群-----------------------
	};

});

/*=======================================================
 	MODELS
 =======================================================*/
/*
 * Card
 */
var Card = function(suit, num, have) {
	have = have || HAVE_STAT_NO;
	this.suit = suit;
	this.num = num;
	this.have = have;
	return this;
};
/*
 * Player
 */
var Player = function(id,name,url){
	this.id = id;
	this.name = name;
	this.url = url;
	this.cards = new Array();
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



