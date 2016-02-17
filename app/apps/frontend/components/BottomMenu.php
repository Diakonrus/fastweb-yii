<?

class BottomMenu extends CWidget {
	public $params = array();

	public function run() 
	{
		$model_Pages = Pages::model()->findAll(array('condition'=>'in_footer=1','order'=>'left_key'));
		$ret = '';
		foreach ($model_Pages as $model_Pages_item)
		{
			if ($model_Pages_item->level > 2) continue;
			
			$root = Pages::model()->findByPk($model_Pages_item->id);
			$descendants = $root->descendants()->findAll($root->id);
			$childs_menu = "";
			$childs = array();
			foreach ($descendants AS $child) {
				$url_child = trim(strip_tags($child->url));
				$childs[] = '<a class="submenu-bottom" href="'.SITE_NAME_FULL."/".$url_child.'" >&nbsp;-&nbsp;'.$child->title.'</a>';
			}
			$childs_menu = implode("<br />", $childs);
			if ($childs_menu) $childs_menu = "<br />".$childs_menu;
		
			$class = "";
			if (strpos($_SERVER['REQUEST_URI'],$model_Pages_item->url)!==false || ($model_Pages_item->main_page && (!$_SERVER['REQUEST_URI'] || $_SERVER['REQUEST_URI']=="/")))
			{
				$class=" active";
			}
			if ($model_Pages_item->main_page)
				$url = "";
			else
				$url = trim(strip_tags($model_Pages_item->url));
				
			$ret.= '<li class="item1'.$class.'"><a href="'.SITE_NAME_FULL."/".$url.'" ><span>'.$model_Pages_item->title.'</span></a>'.$childs_menu.'</li>';
			
		}

		$data['ret'] = $ret;
		$this->render('view_BottomMenu', $data);
	}
}

?>

