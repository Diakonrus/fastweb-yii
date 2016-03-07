<?

class Categories extends CWidget {

	public $params = array();

	public function run() {
		$moduleModel = SiteModule::model()->findByPk(4);

		if (!empty($moduleModel)) {
			$root = CatalogRubrics::getRoot();
			$categories = $root->descendants()->findAll($root->id);
			$tree = '';
			$level=0;

			foreach ($categories as $n=>$category) {

				if ($category->status == 1) {
					if ($category->level == $level) {
						$tree .= CHtml::closeTag('li')."\r\n";
					} else if($category->level > $level) {
						$tree .= CHtml::openTag('ul')."\r\n";
					} else {
						$tree .= CHtml::closeTag('li')."\r\n";
						for($i=$level-$category->level; $i; $i--) {
							$tree .= CHtml::closeTag('ul')."\r\n";
							$tree .= CHtml::closeTag('li')."\r\n";
						}
					}

					$tree .= CHtml::openTag('li');
					$tree .= CHtml::link($category->name, Yii::app()->urlManager->createUrl($moduleModel->url_to_controller . '/element', array('param' => $category->url)));
					$level = $category->level;
				}
			}

			$tree .= CHtml::closeTag('li')."\r\n";
			$tree .= CHtml::closeTag('ul')."\r\n";

			$data['tree'] = $tree;
			$this->render('view_Categories', $data);
		}
	}

}