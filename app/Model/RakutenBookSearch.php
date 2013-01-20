<?php
App::uses('AppModel', 'Model');
/**
 * RakutenBookSearch Model
 *
 */
class RakutenBookSearch extends AppModel {

	public $useTable = false;
	
	public $genre_chk_stats = array(
		'no_child' => 'no_child',   //子カテゴリを持たないジャンルＩＤ
		'has_child' => 'has_child', //子カテゴリを持つジャンルＩＤ
	);
	
	/**
	 * 楽天ブックス書籍検索API２サービスで単品アイテム情報取得
	 * [API仕様]https://webservice.rakuten.co.jp/api/bookstotalsearch2/
	 * @param $search_values  検索キーワード（キー名と値のセット　連想配列）
	 *          *現在有効としているキー
	 *           keyword  検索キーワード
	 *           genreid  書籍ジャンルコード ※あまり使わないかも？
	 *           isbn     ISBNコード(JAN)
	 * @param $env アクセス環境を指定。(PC,SP)デフォルトはPC向け情報とする
	 * @param $first 第１巻限定フラグ（タイトルに「１巻」等のキーワードを含むもののみ取得する　デフォルトはtrue）//※完全ではない
	 * @return パラメタ異常、または検索結果が０件の場合FALSEを返す
	 *         正常に取得できた場合、楽天より取得したデータのフルセット（JSON形式）
	 */
	public function getItem($search_values, $env='PC', $first=false){

		//[0]パラメタ検査
		if( !array_key_exists('keyword', $search_values) &&
		    !array_key_exists('genreid', $search_values) &&
		    !array_key_exists('isbnjan', $search_values) ){
			return false;
		}


		//HttpSocket & Xml
		App::uses('HttpSocket', 'Network/Http');
		//App::uses('Xml', 'Utility');
		$HttpSocket = new HttpSocket();
		
		// 楽天ブックス書籍検索API2
		// パラメタの設定
		$baseurl = 'https://app.rakuten.co.jp/services/api/BooksTotal/Search/20121128';
		$params = array();
		
		//[1]必須パラメタ
		$params = $this->_getCommonParam();
		
		//[2]サービス固有パラメタ
		$params['keyword'] = "";
		if(isset($search_values['keyword'])) $params['keyword'] .= $search_values['keyword'];
		if($first) $params['keyword'] .= " " . $this->_get_str_like_first();
		if($params['keyword']!=""){
			$params['keyword'] = urlencode($params['keyword']);
		} else {
			unset($params['keyword']);
		}
		if(isset($search_values['genreid'])) {
			$params['booksGenreId'] = urlencode($search_values['genreid']);
		} else {
			$params['booksGenreId'] = urlencode("001001");
		}
		if(isset($search_values['isbnjan'])) {
			$params['isbnjan'] = str_replace("-", "", $search_values['isbnjan']);
			$params['isbnjan'] = urlencode($params['isbnjan']); //ISBN(japan)
		}
		if(isset($search_values['page'])){
			$params['page'] = $search_values['page'];
		}
		if(isset($search_values['sort'])){
			$params['sort'] = urlencode($search_values['sort']);
		}
		$params['carrier'] = ($env=='PC') ? "0" : "1";
		$params['size'] = 9; //comic

		ksort($params);
		
		//[3]パラメタをクエリ文字列に変換
		$query = "?"; $i=0;
		foreach($params as $key => $value){
			if($i>0) $query.="&";
			$query.=$key."=".$value;
			$i++;
		}

		$url = $baseurl.$query;
		$data = $HttpSocket->get($url);

		$chk_data = json_decode($data, true);
		if( array_key_exists("error", $chk_data) ){
			return false;
		}

		return $data;
	
	}
	// RFC3986標準によるURLエンコード
	private function _urlencode_rfc3986($str)
	{
		return str_replace('%7E', '~', rawurlencode($str));
	}
	// 第１巻に類する文字列を半角空白区切りで取得する
	private function _get_str_like_first(){
		
		$strings = array();
		$fp = fopen(ROOT . DS . APP_DIR . DS . 'Model/Datasource/first_str.txt', "r"); 	
		if ($fp) {
			while (($buffer = fgets($fp, 4096)) !== false) {
				$strings[] = $buffer;
			}
			if (!feof($fp)) {
				echo "Error: unexpected fgets() fail\n";
			}
			fclose($fp);
		}
		$string = implode(" ", $strings);
		return $string;
	}
	
	//楽天API共通パラメタ取得
	private function _getCommonParam(){
		$params = array();
		$params['applicationId'] = RAKUTEN_APP_ID; //アプリケーションID
		$params['affiliateId']   = RAKUTEN_AFFILI_ID; //アフィリエイトID
		$params['format']        = 'json'; //受信データ形式
		return $params;
	}
	
	/**
	 * 楽天ジャンル検索
	 */
	public function getGenreData($genre_id){
		
		$baseurl = 'https://app.rakuten.co.jp/services/api/BooksGenre/Search/20121128';
		$params = array();
		$params = $this->_getCommonParam();
		$params['booksGenreId'] = $genre_id; //ジャンルルートID
		$query = "?"; $i=0;
		foreach($params as $key => $value){
			if($i>0) $query.="&";
			$query.=$key."=".$value;
			$i++;
		}
		App::uses('HttpSocket', 'Network/Http');
		//App::uses('Xml', 'Utility');
		$HttpSocket = new HttpSocket();
		$url = $baseurl.$query;
		$data = $HttpSocket->get($url);
		return json_decode($data, true);
		
	}
	
	/**
	 * 楽天API検索条件の妥当性をチェックする
	 *  
	 */
	public function chk_params($params) {
		
		$result = array(
			'flag' => true,
			'msg' => ""
		);
		
		// params['genre_id']
		if( empty($params['genre_id']) ){
			//$result['msg'] = "ジャンルIDは必須です";
		} else {
			if( strlen($params['genre_id']) < 6 ){
				$result['msg'] = "ジャンルIDが不正な値です";
			} else {
				if( strlen($params['genre_id'])==6 && $params['genre_id']!='001001' ){
					$result['msg'] = "書籍以外のジャンルIDが指定されています";
				}
			}
		}
		
		//all empty flag
		$all_emp = true;
		foreach($params as $v){
			if($v!=""){
				$all_emp = false;
				break;
			}
		}
		if($all_emp){
			$result['msg'] = "一つ以上の条件を入力してください";
		}
		
		if( $result['msg'] != "" ){
			$result['flag'] = false;
		}
		return $result;
	}
	
	/**
	 * ジャンルIDの形式チェック
	 * [暫定版ルール]
	 *    ジャンルIDは必ず、３の倍数の桁数(上限12桁)
	 *    12桁の場合、子カテゴリは存在しない
	 *
	 * @param $genre_id  ジャンルＩＤ
	 * @return 'has_child'  正しいジャンルコードで、子カテゴリを持つ(形式的には)
	 *         'no_child'   正しいジャンルコードだが、子カテゴリは持たない
	 *         false        ジャンルコード形式不正
	 *
	 */
	public function chkGenreId ($genre_id) {
		
		//[1]桁数チェック
		$_len = strlen($genre_id);
		if( $_len < 3 || $_len > 12 || ($_len % 3) != 0 ){
			return false;
		}
		
		//[2]12桁なら最下層カテゴリ
		if( $_len == 12 ){
			return $this->genre_chk_stats['no_child'];
		}
		
		return $this->genre_chk_stats['has_child'];
		
	}

}
