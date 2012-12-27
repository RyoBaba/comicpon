<?php
App::uses('AppModel', 'Model');
/**
 * CptComic Model
 *
 */
class CptComic extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */


/**
 * データ存在チェック
 */
	public function isExists($key, $type="isbn_code"){
		$params = array();
		$conditions = array($type=>$key);
		$fields = array('id');
		$params['conditions'] = $conditions;
		$params['fields'] = $fields;
		$rec = $this->find('all', $params);
		if( count($rec) > 0 ) {
			return true;
		} else {
			return false;
		}
	}

}
