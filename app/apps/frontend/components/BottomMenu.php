<?

class BottomMenu extends CWidget {
	public $params = array();

	public function run() 
	{
		$data['ret'] = '';
		$data['curentPageID'] = ((!empty($this->params))?($this->params):(null));
		$this->render('view_BottomMenu', $data);
	}
}

?>

