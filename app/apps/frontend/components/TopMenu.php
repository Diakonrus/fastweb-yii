<?

class TopMenu extends CWidget {
	public $params = array();

	public function run()
	{

		$data['ret'] = '';
		$this->render('view_TopMenu', $data);
	}
}

?>

