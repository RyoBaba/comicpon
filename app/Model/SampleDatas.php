<?php
App::uses('AppModel', 'Model');
/**
 * SampleDatas service Model
 *
 */
class SampleDatas extends AppModel {

	public $useTable = false;
	
	public function getWikiDatas($vowelcode) {
	
		$urllist = array(
			"http://ja.wikipedia.org/wiki/%E6%97%A5%E6%9C%AC%E3%81%AE%E6%BC%AB%E7%94%BB%E4%BD%9C%E5%93%81%E4%B8%80%E8%A6%A7_%E3%81%82%E8%A1%8C", //[0]:ア行
			"http://ja.wikipedia.org/wiki/%E6%97%A5%E6%9C%AC%E3%81%AE%E6%BC%AB%E7%94%BB%E4%BD%9C%E5%93%81%E4%B8%80%E8%A6%A7_%E3%81%8B%E8%A1%8C", //[1]:カ行
			"http://ja.wikipedia.org/wiki/%E6%97%A5%E6%9C%AC%E3%81%AE%E6%BC%AB%E7%94%BB%E4%BD%9C%E5%93%81%E4%B8%80%E8%A6%A7_%E3%81%95%E8%A1%8C", //[2]:サ行
			"http://ja.wikipedia.org/wiki/%E6%97%A5%E6%9C%AC%E3%81%AE%E6%BC%AB%E7%94%BB%E4%BD%9C%E5%93%81%E4%B8%80%E8%A6%A7_%E3%81%9F%E8%A1%8C", //[3]:タ行
			"http://ja.wikipedia.org/wiki/%E6%97%A5%E6%9C%AC%E3%81%AE%E6%BC%AB%E7%94%BB%E4%BD%9C%E5%93%81%E4%B8%80%E8%A6%A7_%E3%81%AA%E8%A1%8C", //[4]:ナ行
			"http://ja.wikipedia.org/wiki/%E6%97%A5%E6%9C%AC%E3%81%AE%E6%BC%AB%E7%94%BB%E4%BD%9C%E5%93%81%E4%B8%80%E8%A6%A7_%E3%81%AF%E8%A1%8C", //[5]:ハ行
			"http://ja.wikipedia.org/wiki/%E6%97%A5%E6%9C%AC%E3%81%AE%E6%BC%AB%E7%94%BB%E4%BD%9C%E5%93%81%E4%B8%80%E8%A6%A7_%E3%81%BE%E8%A1%8C", //[6]:マ行
			"http://ja.wikipedia.org/wiki/%E6%97%A5%E6%9C%AC%E3%81%AE%E6%BC%AB%E7%94%BB%E4%BD%9C%E5%93%81%E4%B8%80%E8%A6%A7_%E3%82%84%E8%A1%8C", //[7]:ヤ行
			"http://ja.wikipedia.org/wiki/%E6%97%A5%E6%9C%AC%E3%81%AE%E6%BC%AB%E7%94%BB%E4%BD%9C%E5%93%81%E4%B8%80%E8%A6%A7_%E3%82%89%E8%A1%8C", //[8]:ラ行
			"http://ja.wikipedia.org/wiki/%E6%97%A5%E6%9C%AC%E3%81%AE%E6%BC%AB%E7%94%BB%E4%BD%9C%E5%93%81%E4%B8%80%E8%A6%A7_%E3%82%8F%E8%A1%8C", //[9]:ワ行
		);
	
		//HttpSocket & Xml
		App::uses('HttpSocket', 'Network/Http');
		//App::uses('Xml', 'Utility');
		$HttpSocket = new HttpSocket();
		$url = $urllist[$vowelcode];
		
		$data = $HttpSocket->get($url);
		
		return $data;
	
	}
	
	/**
	 * タイトルマスタにタイトル情報レコードを追加
	 */
	public function saveTitleMas($datas) {

//pr($datas);
//echo count($datas['title']);
		
		$CptTitleMas = ClassRegistry::init('CptTitleMas');
		
		$ins_cnt = 0;
		$rtn = array();
		$rtn['flag'] = false;
		
		$CptTitleMas->begin();
		foreach($datas['title'] as $idx => $v){
			$saveData = array();
			$saveData['title'] = $datas['title'][$idx];
			$saveData['description'] = $datas['description'][$idx];
			$saveData['vowel'] = $datas['vowel'][$idx];
			$saveData['wikiurl'] = $datas['wikiurl'][$idx];
			
			if(!$CptTitleMas->isExistsSameTitle($saveData['title'])){
				$CptTitleMas->create();
				if(false === $CptTitleMas->saveTitle($saveData)){
					//$CptTitleMas->rollback();
					return $rtn;
				} else {
					$ins_cnt++;
				}
			}
		}
		$CptTitleMas->commit();
		
		$rtn['flag'] = true;
		$rtn['ins_cnt'] = $ins_cnt;
		
		return $rtn;
	}
	
}
