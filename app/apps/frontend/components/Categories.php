<?

class Categories extends CWidget {
	public $params = array();

	public function run() 
	{
		$root = CatalogRubrics::model()->roots()->find();
		$all = CatalogRubrics::model()->findByPk($root->id)->findAll();
		$ret = '';
		if (count($this->params)) {
			$pid = $this->params[0];
		} else {
			$pid = 4890;
		}
		foreach ($all as $item)
		{
			$item_attributes = $item->getAttributes();
			if ($item_attributes['parent_id']==$pid)
			{
				if (strpos($_SERVER['REQUEST_URI'],"/catalog/".$item_attributes['url'])!==false)
					$ret.='<div class="menuinside3"><span style="color: #e9c865;"><a href="/catalog/'.$item_attributes['url'].'">'.$item_attributes['name'].'</a></span></div>';
				else
					$ret.='<div class="menuinside3"><a href="/catalog/'.$item_attributes['url'].'">'.$item_attributes['name'].'</a></div>';
			}
		}
		$data['ret'] = $ret;
		$this->render('view_Categories', $data);
	}
}

?>

