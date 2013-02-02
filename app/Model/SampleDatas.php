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
	
	/**
	 * タイトルマスタ上に保存されているWikipediaのurlから
	 * HTMLデータを取得した後、正規化し、タイトルごとに保存してしまう
	 */
	public function getTitleIds() {
		
		$CptTitleMas = ClassRegistry::init('CptTitleMas');
		
		$ids = array();
		
		//[1]WikipediaURLを全て取得
		$vowel_list = Configure::read('Hiragana');
		foreach($vowel_list as $vowels){
			foreach($vowels as $vowel){
				$conditions = array('vowel'=>$vowel);
				$fields = array('id');
				$order = array('id'=>'asc');
				$recs = $CptTitleMas->find('all', array(
					'conditions' => $conditions,
					'fields' => $fields,
					'order' => $order
				));
				foreach($recs as $rec){
					$ids[] = $rec['CptTitleMas']['id'];
				}
			}
		}
		
		/*
		//[2]各URLにリクエストし、HTMLテキストデータを取得
		foreach($urls as $url){
			$domDocument = new DOMDocument();
			$html = file_get_contents($url);
			$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'ASCII, JIS, UTF-8, EUC-JP, SJIS');
			$domDocument->loadHTML($html);
			$xmlString = $domDocument->saveXml();
			$xmlObj = simplexml_load_string($xmlString);
			$urls[] = $xmlObj->body;
			break;
		}
		*/		
		
		
		return $ids;
	}
	
	/*
	 * 指定されたURLのHTMLデータを取得する
	 */
	public function getHtmlData($id){
		
		$CptTitleMas = ClassRegistry::init('CptTitleMas');
		$title_rec = $CptTitleMas->findById($id);
		$url = $title_rec['CptTitleMas']['wikiurl'];
		
		App::uses('HttpSocket', 'Network/Http');
		$HttpSocket = new HttpSocket();
		$data = $HttpSocket->get($url);
		return $data;

	}
	
	
	
}
