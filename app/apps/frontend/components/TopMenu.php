<?

class TopMenu extends CWidget {
	public $params = array();

	public function run() 
	{
		$model_Pages = Pages::model()->findAll(array('condition'=>'in_header=1','order'=>'left_key'));
		$ret = '';
		foreach ($model_Pages as $model_Pages_item)
		{
			if ($model_Pages_item->level == 1)continue;
			$class = "";
			if (strpos($_SERVER['REQUEST_URI'],$model_Pages_item->url)!==false || ($model_Pages_item->main_page && (!$_SERVER['REQUEST_URI'] || $_SERVER['REQUEST_URI']=="/")))
			{
				$class=" active";
			}
			if ($model_Pages_item->main_page)
				$url = "";
			else
				$url = trim(strip_tags($model_Pages_item->url));
				
			$ret.= '<li class="item1'.$class.'"><a href="'.SITE_NAME_FULL."/".$url.'" ><span>'.$model_Pages_item->title.'</span></a></li>';
		}

		$data['ret'] = $ret;
		$this->render('view_TopMenu', $data);
	}
}

?>

