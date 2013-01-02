<?php
App::uses('AppModel', 'Model');
/**
 * RakutenBookSearch Model
 *
 */
class RakutenBookSearch extends AppModel {

	public $useTable = false;
	
	/**
	 * 楽天ブックス書籍検索API２サービスでアイテム情報取得
	 * [API仕様]https://webservice.rakuten.co.jp/api/bookstotalsearch2/
	 * @param $search_values  検索キーワード（キー名と値のセット　連想配列）
	 *          *現在有効としているキー
	 *           keyword  検索キーワード
	 *           genreid  書籍ジャンルコード ※あまり使わないかも？
	 *           isbn     ISBNコード(JAN)
	 * @param $env アクセス環境を指定。(PC,SP)デフォルトはPC向け情報とする
	 * @param $first 第１巻限定フラグ（タイトルに「１巻」等のキーワードを含むもののみ取得する　デフォルトはtrue）
	 * @return パラメタ異常、または検索結果が０件の場合FALSEを返す
	 *         正常に取得できた場合、楽天より取得したデータのフルセット（JSON形式）
	 */
	public function getItem($search_values, $env='PC', $first=true){
		
		//[0]パラメタ検査
		if( !array_key_exists('keyword', $search_values) &&
		    !array_key_exists('genreid', $search_values) &&
		    !array_key_exists('isbn', $search_values) ){
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
        if(isset($search_values['keyword'])) $params['keyword'] = urlencode($search_values['keyword']);  //検索キーワード（任意）
        if(isset($search_values['genreid'])) $params['booksGenreId'] = urlencode($search_values['genreid']);
        if(isset($search_values['isbn'])) {
        	$params['isbnjan'] = urlencode($search_values['isbn']); //ISBN(japan)
        	$params['isbnjan'] = str_replace("-", "", $params['isbnjan']);
        }
        $params['carrier'] = ($env=='PC') ? "0" : "1";
        $params['title'] = urlencode($this->_get_str_like_first());
        $params['sort'] = urlencode("reviewCount");
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
        $params['applicationId']  = RAKUTEN_APP_ID; //アプリケーションID
        $params['affiliateId'] = RAKUTEN_AFFILI_ID; //アフィリエイトID
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
	 * ジャンルIDの妥当性をチェックする
	 *  [1] ジャンルIDが６桁未満はNG（書籍以外の可能性がある）
	 *  [2] ジャンルIDが６桁の場合「001001＝ブック／漫画（コミック）」以外はエラー
	 *  
	 */
	public function chk_genre_id($genre_id) {
		
		if( empty($genre_id) ){
			return false;
		} else {
			if( strlen($genre_id) < 6 ){
				return false;
			} else {
				if( strlen($genre_id)==6 && $genre_id!='001001' ){
					return false;
				}
			}
		}
		return true;
	}

}
