<?

class LeftMenu extends CWidget {
	public $params = array();

	public function run() 
	{
		$root = CatalogRubrics::model()->roots()->find();
		$all = CatalogRubrics::model()->findByPk($root->id)->findAll();
		$ret = '';
		foreach ($all as $item)
		{
			$item_attributes = $item->getAttributes();
			if ($item_attributes['parent_id']==4890)
			{
				$ret.='<li class="lmenu_item_'.$item_attributes['id'].'">
				<a href="/catalog/'.$item_attributes['url'].'">'.$item_attributes['name'].'</a>
				<div class="div_arrow moreheight down" idx="'.$item_attributes['id'].'"></div>
				';
				$subitems='';
				foreach ($all as $item2)
				{
					$item2_attributes = $item2->getAttributes();
					if ($item2_attributes['parent_id']==$item_attributes['id'])
					{
						$subitems.='<li  class="lmenu_item_'.$item2_attributes['id'].'">

						<a href="/catalog/'.$item2_attributes['url'].'">'.$item2_attributes['name'].'</a>';
						$subsubitems='';
						foreach ($all as $item3)
						{
							$item3_attributes = $item3->getAttributes();
							if ($item3_attributes['parent_id']==$item2_attributes['id'])
							{
								$subsubitems.='<li class="lmenu_item_'.$item3_attributes['id'].'">
											           <a href="/catalog/'.$item3_attributes['url'].'">
											             '.$item3_attributes['name'].'
											           </a>
											         </li>';
							}
						}
						if (strlen($subsubitems))
						{
							$subsubitems = '
							<div class="div_arrow" idx="'.$item2_attributes['id'].'">
							</div>
							<ul class="parent_lmcontainer_'.$item2_attributes['id'].'">'.$subsubitems.'</ul>';
						}
						$subitems.=$subsubitems.'</li>';
					}
				}
				if (strlen($subitems))
				{
					$ret.= '<ul class="parent_lmcontainer_'.$item_attributes['id'].'">'.$subitems.'</ul>';
				}
				$ret.= '</li>';
			}
		}
		$data['ret'] = $ret;
		$this->render('view_LeftMenu', $data);
	}
}

?>

