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


}
