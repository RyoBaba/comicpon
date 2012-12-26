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
	 *           genreld  書籍ジャンルコード ※あまり使わないかも？
	 *           isbn     ISBNコード(JAN)
	 * @param $env アクセス環境を指定。(PC,SP)デフォルトはPC向け情報とする
	 * @return パラメタ異常、または検索結果が０件の場合FALSEを返す
	 *         正常に取得できた場合、楽天より取得したデータのフルセット（JSON形式）
	 */
	public function getItem($search_values, $env='PC'){
		
		//[0]パラメタ検査
		if( !array_key_exists('keyword', $search_values) &&
		    !array_key_exists('genreld', $search_values) &&
		    !array_key_exists('isbn', $search_values) ){
			return false;
		}
		
        //HttpSocket & Xml
        App::uses('HttpSocket', 'Network/Http');
        App::uses('Xml', 'Utility');
        $HttpSocket = new HttpSocket();
        
        $access_key_id = RAKUTEN_ACCESS_KEY_ID;  //楽天Webサービス登録時に発行されるアクセスキー
        $secret_access_key = RAKUTEN_SECRET_ACCESS_KEY;  //楽天Webサービス登録時に発行されるアクセスキー
        
        // 楽天ブックス書籍検索API2
        // パラメタの設定
        $baseurl = 'https://app.rakuten.co.jp/services/api/BooksTotal/Search/20121128';
        $params = array();
        
        //[1]必須パラメタ
        $params['applicationId']  = '1040532859624711114'; //アプリケーションID
        $params['affiliateId'] = '10839e0a.a54f997f.10839e0b.5e874c00'; //アフィリエイトID
        $params['format']        = 'json'; //受信データ形式
        
        //[2]サービス固有パラメタ
        if(isset($search_values['keyword'])) $params['keyword'] = urlencode($search_values['keyword']);  //検索キーワード（任意）
        if(isset($search_values['genreld'])) $params['booksGenreId'] = urlencode($search_values['genreld']); //書籍ジャンルコード000（任意）
        if(isset($search_values['isbn'])) {
        	$params['isbnjan'] = urlencode($search_values['isbn']); //ISBN(japan)
        	//ハイフンがあれば除去しておく
        	$params['isbnjan'] = str_replace("-", "", $params['isbnjan']);
        }
        $params['carrier'] = ($env=='PC') ? "0" : "1";
        
        // ﾂャ潟Nエストパラメタをキーの昇順にソートしておく
        ksort($params);
        
        // canonical string
        /*
        $canonical_string = '';
        foreach ($params as $k => $v) {
            $canonical_string .= '&'.$this->_urlencode_rfc3986($k).'='.$this->_urlencode_rfc3986($v);
        }
        $canonical_string = substr($canonical_string, 1);
        */
        
		//[3]パラメタをクエリ文字列に変換
		$query = "?"; $i=0;
		foreach($params as $key => $value){
			if($i>0) $query.="&";
			$query.=$key."=".$value;
			$i++;
		}

        // リクエストURL
        $url = $baseurl.$query;

        $data = $HttpSocket->get($url);
//        if(FALSE === $data = Xml::toArray( Xml::build($url) ) ){
//        	return false;
//        }
//        if(FALSE === $data = Xml::build($url)){
//       	$this->log('CANT Find Xml', LOG_DEBUG);
//        } else {
//        $this->log("chk2");
//        	$data = Xml::toArray($data);
//        }
        //$data = json_decode($res);
        return $data;
	
	}
    // RFC3986標準によるURLエンコード
    private function _urlencode_rfc3986($str)
    {
        return str_replace('%7E', '~', rawurlencode($str));
    }


}
