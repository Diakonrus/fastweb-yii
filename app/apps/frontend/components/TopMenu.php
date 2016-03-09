<?

class TopMenu extends CWidget {
	public $params = array();

	public function run() {
		$data['pages'] = Pages::getMenu(2);
		$data['currentPageUri'] = Yii::app()->request->getRequestUri();
		$this->render('view_TopMenu', $data);
	}
}
