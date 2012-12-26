<?php
App::uses('AppModel', 'Model');
/**
 * ComicRecomends service Model
 *
 */
class ComicRecomends extends AppModel {

	public $useTable = false;
	
	/**
	 * 書籍検索
	 * 1.cpt_comicsから書籍データを抽出する。
	 * 2.1でISBN検索の時のみ書籍データが取得できなかった場合、楽天APIに接続し、書籍データ取得
	 *  2-1. 2で書籍データを取得できた場合、以降同書籍のデータはcpt_comicsから取得できるようマスタ登録
	 * @param $search_key  書籍検索用キー値
	 * @param $search_ype  書籍検索の種類（ISBN/TITLE/AUTHOR)
	 */
	public function findBooks($ItemId, $IdType='ISBN'){
		
		$data = array();
		
		//[1]書籍データをcpt_comicsから検索
		$CptComic = ClassRegistry::init('CptComic');
		$params = array();
		$conditions = array();
		if( $IdType == 'ISBN' ){
			$conditions['isbn_code'] = str_replace("-", "", $ItemId);
		}
		
		$params['conditions'] = $conditions;
		
		$data = $CptComic->find('all', $params);
		
		//[2]ISBN検索の時のみ、検索結果が０件だったとき、楽天APIからデータ取得
		if( $IdType=="ISBN" && count($data) == 0 ){
			$RakutenBookSearch = ClassRegistry::init('RakutenBookSearch');
			$params = array(
				'isbn' => $ItemId
			);
			if( FALSE !== $rakuApiData = $RakutenBookSearch->getItem($params)){
				//JSONデータをデコード（PHP stdObj形式のオブジェクトに変換される）
				$rakuApiData = json_decode($rakuApiData, true);
				if( $rakuApiData['count'] > 0){
					//取得してきたデータをcpt_comicsにセーブ
					$i=0;
					foreach( $rakuApiData['Items'] as $item ){
						$item = $item['Item'];
						//セーブ用にデータ整形（形式や存在チェックでNGなら読み飛ばし）
						if(FALSE !== $saveData = $this->_set_save_data_rakuToApp($item) ){
							//save
							$CptComic->create();
							$saveData = $CptComic->save($saveData);
							//cpt_comicのレイアウトに展開する
							$data[$i] = $saveData;
							$i++;
						}
						
					}
				}
			} else {
				//FALSEが返ってきた場合ここで処理中断
			}
		}
		return $data;
			
	}
	//(SUB) 楽天APIデータ→cpt_comicsセーブ用に変換
	private function _set_save_data_rakuToApp($item){
		
		$CptComic = ClassRegistry::init('CptComic');
		
		$saveData = array();
		$item['isbn'] = str_replace("-", "", $item['isbn']);
		$item['itemPrice'] = intval(preg_replace("/[\\￥\,\-]/", "", $item['itemPrice'])); //\マークやハイフンカンマを除去

		//存在チェック（同一のISBNコードがテーブルに存在するかチェック）
		if(TRUE === $CptComic->isExists($item['isbn'])){
			return false; //既に登録済みのデータ（イレギュラーなケースだが）
		}
		
		$saveData['isbn_code'] = $item['isbn'];
		$saveData['book_title'] = $item['title'];
		$saveData['author'] = $item['author'];
		$saveData['publisher'] = $item['publisherName'];
		$saveData['price'] = $item['itemPrice'];
		$saveData['sales_date'] = $item['salesDate'];
		$saveData['afili_raku'] = $item['affiliateUrl'];
		$saveData['afili_ama'] = "";
		$saveData['item_image'] = $item['largeImageUrl'];

		return $saveData;

	}

}
