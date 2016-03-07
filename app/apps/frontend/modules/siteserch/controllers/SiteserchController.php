<?php

class SiteserchController extends Controller
{
	public $layout='//layouts/main';

  
  function compares($s,$word){
		if(!function_exists('mb_ucfirst')) {
				function mb_ucfirst($str, $enc = 'utf-8') { 
						return mb_strtoupper(mb_substr($str, 0, 1, $enc), $enc).mb_substr($str, 1, mb_strlen($str, $enc), $enc); 
				}
		}
		
		if(!function_exists('mb_str_replace')) {
				function mb_str_replace($haystack, $search,$replace, $offset=0,$encoding='auto'){
						$len_sch=mb_strlen($search,$encoding);
						$len_rep=mb_strlen($replace,$encoding);
					 
						while (($offset=mb_strpos($haystack,$search,$offset,$encoding))!==false){
								$haystack=mb_substr($haystack,0,$offset,$encoding)
								    .$replace
								    .mb_substr($haystack,$offset+$len_sch,1000,$encoding);
								$offset=$offset+$len_rep;
								if ($offset>mb_strlen($haystack,$encoding))break;
						}
						return $haystack;
				}
		}
		
		$s = mb_str_replace($s,'ё','е',0,'utf-8');
		$word = mb_str_replace($word,'ё','е',0,'utf-8');
		
		
		
		$s = trim($s);
		$s_arr = explode(' ',$s);
		if (count($s_arr)==1)
		{
			/*
			$pattern = '/'.$s.'/i';
			if (preg_match($pattern,$word))
			{
				return true;
			}
			*/
			if (mb_strpos($word,$s,0,'utf-8')!==false)
			{
				return true;
			}
			if (mb_strpos($word,mb_ucfirst($s,'utf-8'),0,'utf-8')!==false)
			{
				return true;
			}
			if (mb_strpos($word,mb_strtolower($s,'utf-8'),0,'utf-8')!==false)
			{
				return true;
			}
		}
		elseif(count($s_arr)>1)
		{
			$ret_arr = array();
			foreach ($s_arr as $s_arr_item)
			{
				$s_arr_item = trim($s_arr_item);
				if (strlen($s_arr_item))
				{
					$ret_arr_item = false;
					$pattern = '/'.$s_arr_item.'/i';
					if (preg_match($pattern,$word))
					{
						$ret_arr_item = true;
					}
					if (mb_strpos($word,$s_arr_item,0,'utf-8')!==false)
					{
						$ret_arr_item = true;
					}
					if (mb_strpos($word,mb_ucfirst($s_arr_item,'utf-8'),0,'utf-8')!==false)
					{
						$ret_arr_item = true;
					}
					if (mb_strpos($word,mb_strtolower($s_arr_item,'utf-8'),0,'utf-8')!==false)
					{
						$ret_arr_item = true;
					}
					
					$ret_arr[] = $ret_arr_item;
				}
			}
			
			foreach ($ret_arr as $ret_arr_item)
			{
				if (!$ret_arr_item)
				{
					return false;
				}
			}
			
			if (count($ret_arr))
			{
				return true;
			}
		}
		
		

  	return false;
  }
    

	public function actionIndex()
	{
		$model = array();
		$data[] = array();
		$data['model_elements'] = array();
		if (isset($_GET['s']) && (!empty($_GET['s'])) && (strlen(trim($_GET['s']))))
		{
			$pattern = trim($_GET['s']);
			$pattern_orig = $pattern;
			$pattern = '/'.$pattern.'/i';

			$page = (isset($_GET['page']))?intval($_GET['page']):0;
			$data['page']=$page;
			//Ищем в каталоге
			
			$crubrics = CatalogRubrics::model()->findAll('status=1');
			$data['allow_rubrics'] = array();
			foreach ($crubrics as $datas)
			{
				if ($this->compares($pattern_orig,$datas->name))
				{
					$data['allow_rubrics'][]=$datas->id;
				}
			}
			
			
			
			foreach ($data['allow_rubrics'] as $allow_rubric)
			{
				
				$celements = CatalogElements::model()->findAll('status=1 AND parent_id = '.intval($allow_rubric));
				foreach ($celements as $datas)
				{
					if (
					     ($this->compares($pattern_orig,$datas->name)) &&
					     (!isset($data['model_elements'][$datas->id]))
					   )
					{
						$data['model_elements'][$datas->id]=$datas;
					}
				}

				foreach ($celements as $datas)
				{
					if (
					     ($this->compares($pattern_orig,$datas->description)) &&
					     (!isset($data['model_elements'][$datas->id]))
					   )
					{
						$data['model_elements'][$datas->id]=$datas;
					}
				}
			}


			$celements = CatalogElements::model()->findAll('status=1');
			foreach ($celements as $datas)
			{
				if ( 
				     ($this->compares($pattern_orig,$datas->name)) &&
				     (!isset($data['model_elements'][$datas->id]))
				   )
				{
					$data['model_elements'][$datas->id]=$datas;
				}
			}

			foreach ($celements as $datas)
			{
				if (
				     ($this->compares($pattern_orig,$datas->description)) &&
				     (!isset($data['model_elements'][$datas->id]))
				   )
				{
					$data['model_elements'][$datas->id]=$datas;
				}
			}

			
			$count = count($data['model_elements'])-12;

			$criteria = new CDbCriteria();
			$pages=new CPagination($count);
			$pages->pageSize=12;
			$pages->applyLimit($criteria);
			$data['pages']=$pages;
		}
		$this->render('index', $data);
	}




}
