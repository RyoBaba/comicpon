<?php

//楽天APIのソート指定文字列
$config['Raku']['sort'] = array(
	'standard'=>'標準',
	'sales'=>'売れている順',
	'+releaseDate'=>'発売日(古い)',
	'-releaseDate'=>'発売日(新しい)',
	'+itemPrice'=>'価格(安い)',
	'-itemPrice'=>'価格(高い)',
	'reviewCount'=>'反響多',
	'reviewAverage'=>'評判良',
);

//WikipediaのルートURL
$config['wikiRootUrl'] = "http://ja.wikipedia.org/";

//50音ひらがなリスト
$config['Hiragana'] = array(
	'あ行'=> array('あ','い','う','え','お'),
	'か行'=>array('か','き','く','け','こ'),
	'さ行'=>array('さ','し','す','せ','そ'),
	'た行'=>array('た','ち','つ','て','と'),
	'な行'=>array('な','に','ぬ','ね','の'),
	'は行'=>array('は','ひ','ふ','へ','ほ'),
	'ま行'=>array('ま','み','む','め','も'),
	'や行'=>array('や','ゆ','よ'),
	'ら行'=>array('ら','り','る','れ','ろ'),
	'わ行'=>array('わ','ん')
)



?>