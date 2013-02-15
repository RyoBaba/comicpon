<?php
    //ページCSS
    echo $this->Html->css('view/mock');
?>

<script type='text/javascript'>

$(document).ready(function(){

	$('.book_img').live('click',function(){
	
		var clickEle = $(this);
	    
		var image_element = $('.book_img');
		
		if (clickEle.hasClass('book_img2')){
			clickEle.removeClass('book_img2');
			clickEle.parent('li').removeClass('transition2');
		} else {
			clickEle.addClass('book_img2');
			clickEle.parent('li').addClass('transition2');
		}

		image_element.each(function(){
			if (clickEle.attr('id') != $(this).attr('id')){
				$(this).removeClass('book_img2');
				$(this).parent('li').removeClass('transition2');
			}
		});
		
		//ページ内スクロール
		var i = $('.book_img').index(this)
		var p = $('.book_img').eq(i).offset().top;
		$('html,body').animate({ scrollTop: p }, 1200);
		return false;
	});
});


</script>


<div id='search_wrap'>
	<h3>キーワード検索</h3>
	<span>わんぴーす</span>
	<div class='search_box'>
		<input class='search_text' type='text' placeholder='再検索' />
		<input class='search_btn search_key' type='submit' value='検索' />
	</div>
</div>
<div class='comic_list'>
    <ul>
    <li class='transition'>
        <img  id='book0' class='book_img' src='../book_images/one_piece01.jpg'  width='80'/>
        <ul class='comic_shousai'>
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href='#'>もっと詳しく</a>
            </li>
        </ul>
    </li>
    <li class='transition'>
        <img  id='book1' class='book_img' src='../book_images/one_piece01.jpg'  width='80'/>
        <ul class='comic_shousai'>
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href='#'>もっと詳しく</a>
            </li>
        </ul>
    </li>
    <li class='transition'>
        <img  id='book2' class='book_img' src='../book_images/one_piece01.jpg'  width='80'/>
        <ul class='comic_shousai'>
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href='#'>もっと詳しく</a>
            </li>
        </ul>
    </li>
    <li class='transition'>
        <img  id='book3' class='book_img' src='../book_images/one_piece01.jpg'  width='80'/>
        <ul class='comic_shousai'>
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href='#'>もっと詳しく</a>
            </li>
        </ul>
    </li>
    <li class='transition'>
        <img  id='book4' class='book_img' src='../book_images/one_piece01.jpg'  width='80'/>
        <ul class='comic_shousai'>
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href='#'>もっと詳しく</a>
            </li>
        </ul>
    </li>
    <li class='transition'>
        <img  id='book5' class='book_img' src='../book_images/one_piece01.jpg'  width='80' />
        <ul class='comic_shousai'>
            <li>
                ONE PIECE
            </li>
            <li>
                尾田ちゃん
            </li>
            <li>
                <a href='#'>もっと詳しく</a>
            </li>
        </ul>
    </li>
    </ul>
<div>
