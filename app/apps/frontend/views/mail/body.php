<?php
    $assetPath = Yii::app()->createAbsoluteUrl(Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'));
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Example</title>
</head>
<body style="line-height: 112%" alink="#ffffff" vlink="#ffffff">
        <?php echo $body ?>
</body>
</html>