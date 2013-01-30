<?php
App::uses('AppModel', 'Model');
/**
 * CptTitleMas Model
 *
 */
class CptTitleMas extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */


/**
 * データ存在チェック
 */
	public function isExists($key, $type="id"){
		
	}
	
/**
 * タイトルマスタ追加
 */
	public function saveTitle($saveData) {
		
		//[1]データ整形
		$saveData['wikiurl'] = Configure::read('wikiRootUrl') . $saveData['wikiurl'];
		
		$rtn = $this->save($saveData);
		
		if( !is_array($rtn) ){
			return false;
		}
		
		return true;
		
	}

/**
 * 同一タイトル存在チェック
 */
	public function isExistsSameTitle($title) {
		$conditions = array('title'=>$title);
		$params = array('conditions'=>$conditions);
		$rec = $this->find('all', $params);
		
		if( count($rec) > 0 ){
			return true;
		} else {
			return false;
		}
		
	}

/**
 * 指定されたタイトルID以外のレコードから、ランダムに指定された件数(デフォルト10件)を取得する
 */
	public function getTitleRecRand($title_id, $rec_cnt=10){
		
		$conditions = array();
		$conditions['NOT'] = $title_id;
		$params = array(
			'conditions' => $conditions,
			'order' => 'rand()',
			'limit' => $rec_cnt
		);
		
		$title_rec = $this->find('all', $params);
		
		return $title_rec;
	}

}
