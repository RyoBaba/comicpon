<?php
    //ページCSS
    echo $this->Html->css('mock');
?>

<script type="text/javascript">

$(document).ready(function(){
	$('.transition').live('click',function(){
	    
	    var clickedEle = $(this);
	    
	    console.log($(this).attr('id'));
	    
		var frame_element = $('.transition');
		//var image_element = $('.book_img');
		
		
		if(clickedEle.hasClass('transition2')){
			clickedEle.removeClass('transition2');
		} else {
			clickedEle.addClass('transition2');
		}


		frame_element.each(function(){
		
console.log("Now clicked-id : "+clickedEle.attr('id') + " EachList-id" + $(this).attr('id'));
			if(clickedEle.attr('id') != $(this).attr('id') ){
				if( $(this).hasClass('transition2') ){
					$(this).removeClass('transition2');
				}
			}
		});
		
	});
});


</script>


<div class="search_head">
	<h3>検索キーワード</h3>
	<span>わんぴーす</span>
	<input type="text" placeholder="キーワードを入力" />
	<button type="button" value="検索">検索</button>
</div>
<div class="comic_list">
    <ul>
    <li class="transition" id="tra0">
        <img class="book_img" src="../book_images/one_piece01.jpg"  width="80"/>
        <ul class="comic_shousai">
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href="#">もっと詳しく</a>
            </li>
        </ul>
    </li>
    <li class="transition" id="tra1">
        <img class="book_img" src="../book_images/one_piece01.jpg"  width="80"/>
        <ul class="comic_shousai">
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href="#">もっと詳しく</a>
            </li>
        </ul>
    </li>
    <li class="transition" id="tra2">
        <img class="book_img" src="../book_images/one_piece01.jpg"  width="80"/>
        <ul class="comic_shousai">
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href="#">もっと詳しく</a>
            </li>
        </ul>
    </li>
    <li class="transition" id="tra3">
        <img class="book_img" src="../book_images/one_piece01.jpg"  width="80"/>
        <ul class="comic_shousai">
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href="#">もっと詳しく</a>
            </li>
        </ul>
    </li>
    <li class="transition" id="tra4">
        <img class="book_img" src="../book_images/one_piece01.jpg"  width="80"/>
        <ul class="comic_shousai">
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href="#">もっと詳しく</a>
            </li>
        </ul>
    </li>
    <li class="transition" id="tra5">
        <img class="book_img" src="../book_images/one_piece01.jpg"  width="80"/>
        <ul class="comic_shousai">
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href="#">もっと詳しく</a>
            </li>
        </ul>
    </li>
    </ul>
<div>
