<?

	class Filters extends CWidget {
		public $params = array(
			'data'=>array(),
			);
	
		public function run() {
			
			// Сбрасываем фильтр
			//------------------------------------------------------------------------
			if (isset($_POST['reset_filter_form']))
			{
				setcookie("filters", '', time()+3600, $_SERVER['REQUEST_URI']);
				header("Location: ".$_SERVER['REQUEST_URI']);
				exit();
			}
			//------------------------------------------------------------------------
			
			
			
			$data = $this->params['data'];
			
			
			
			
			//------------------------------------------------------------------------
			if (isset($_POST['filter']))
			{
				setcookie("filters", serialize($_POST['filter']), time()+3600, $_SERVER['REQUEST_URI']);
				header("Location: ".$_SERVER['REQUEST_URI']);
				exit();
			}
			//------------------------------------------------------------------------


			$this->render('view_Filters', $data);
		}
	}

?>

