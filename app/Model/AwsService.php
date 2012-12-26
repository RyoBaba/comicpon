<?php
App::uses('AppModel', 'Model');
/**
 * AwsService Model
 *
 */
class AwsService extends AppModel {

	public $useTable = false;
	
	/**
	 * ItemLookUpサービスでアイテム情報取得
	 * @param $ItemId  商品検索ID(どのキーに対応させるかはIdType引数に依存（デフォルトはASIN）
	 * @param $IdType  商品検索IDタイプ　default=ASIN
	 */
	public function getItemFromAws($ItemId, $IdType='ASIN'){
		
        //HttpSocket
        App::uses('HttpSocket', 'Network/Http');
        App::uses('Xml', 'Utility');
        $HttpSocket = new HttpSocket();
        
        $access_key_id = 'AKIAJ7PIXAJ77UOVXKTA';
        $secret_access_key = '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';
        
        // Amazon Web Service 接続API
        // パラメタの設定
        $baseurl = 'http://ecs.amazonaws.jp/onca/xml';
        $params = array();
        $params['Service']        = 'AWSECommerceService';
        $params['AWSAccessKeyId'] = $access_key_id;
        $params['Version']        = '2009-03-31';
        
        //ItemSearch例
        //$params['Operation']      = 'ItemSearch';
        //$params['SearchIndex']    = 'Books';
        
        //ItemLookUp
        
        $params['Operation'] = 'ItemLookup';
        $params['ItemId'] = $ItemId;
        $params['IdType']       = $IdType;     //
        
        $params['AssociateTag']       = 'ryosugisaku-22';
        $params['ResponseGroup'] = "OfferFull";
        $params['Condition'] = "All";
        $params['MerchantId'] = "All";
        
        // Timestamp GMT標準時間（形式：YYYY-MM-DDTH:i:sZ)
        // 形式を指定してGMT標準時刻を取得
        $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
        
        // リクエストパラメタをキーの昇順にソートしておく
        ksort($params);
        
        // canonical string
        $canonical_string = '';
        foreach ($params as $k => $v) {
            $canonical_string .= '&'.$this->_urlencode_rfc3986($k).'='.$this->_urlencode_rfc3986($v);
        }
        $canonical_string = substr($canonical_string, 1);
        
        // ¼ðì¬µÜ·
        // - KèÌ¶ñtH[}bgðì¬
        // - HMAC-SHA256 ðvZ
        // - BASE64 GR[h
        $parsed_url = parse_url($baseurl);
        $string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
        $signature = base64_encode(hash_hmac('sha256', $string_to_sign, $secret_access_key, true));


        // リクエストURL
        $url = $baseurl.'?'.$canonical_string.'&Signature='.$this->_urlencode_rfc3986($signature);

        //$res = $HttpSocket->get($url);
        if(FALSE === $xml = Xml::toArray( Xml::build($url) ) ){
        	return false;
        }
        
        pr($xml);
        return $xml;
	
	}
    // RFC3986標準によるURLエンコード
    private function _urlencode_rfc3986($str)
    {
        return str_replace('%7E', '~', rawurlencode($str));
    }


}
