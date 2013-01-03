<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $cakeDescription ?>:
        <?php echo $title_for_layout; ?>
    </title>
    <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('comic_recomends');
	?>
	<script src="<?php echo $this->webroot; ?>js/jquery.1.8.3.js" type="text/javascript"></script>
	<?php
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
</head>
<body>
	<?php echo $this->element('ComicRecomends_head_menu'); ?>
    <div id="container">
        <div id="content">

            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>
        </div>
    </div>
    <?php echo $this->element('sql_dump'); ?>
</body>
</html>
