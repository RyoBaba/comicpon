CakePHP 2.2系の練習がてら

漫画（じゃなくてもいいけど）単行本の
ISBNコードを入力すると、
「こんなのも読んだらいいよ」なレコメンドを返すサービスが作りたくて。

さしあたり楽天APIから書籍情報を引っ張ってくるロジックを書きました
（Model/RakutenBookSearch.php 参照）

2013.1.20 追記
同一タイトルで別巻数のタイトルを名寄せするために
タイトルのマスタデータが必要だと判断し、
参考情報としてWikipediaのまとめページHTMLソースを
ブラウザ上に読み込んでDOMツリー展開した後
必要な情報を正規化してマスタ登録するツールを作りました。

ほんとはサーバサイドでHTML解析やった方がスマートなんだろうけど
さしあたって賢いライブラリが見つからず
手軽に賢い解析してくれるのはブラウザ以外思いつかなかった。。。

どなたかご教授頂けると嬉しいです。


[概要]

書籍情報の取得は楽天ブックスAPIから
同一ISBNの書籍は、初回取得時にテーブルに保存し
次回以降はローカルからの取り出しとなります。
（APIリクエスト発生件数抑制のため）

レコメンド生成にあたり
書籍の関連付けデータ
及び書籍のマスタデータもおまけで付けてあります


[動作環境]
CakePHP2.2が動作すること
MySQL

※SampleDatasモデルのタイトルマスタ登録機能は
登録件数が多い場合に、php.iniのmax_input_vars設定の
制約を受ける可能性があるので、動作環境に注意

