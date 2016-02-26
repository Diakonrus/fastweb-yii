<?php
class ControllerCouriersCourier extends Controller {
	private $error = array();

	public function index() {

		$this->language->load('module/courier');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('couriers/couriers');

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['firstname'])) {
			$firstname = $this->request->get['firstname'];
		} else {
			$firstname = null;
		}

		if (isset($this->request->get['lastname'])) {
			$lastname = $this->request->get['lastname'];
		} else {
			$lastname = null;
		}

		if (isset($this->request->get['middlename'])) {
			$middlename = $this->request->get['middlename'];
		} else {
			$middlename = null;
		}

		if (isset($this->request->get['shortfio'])) {
			$shortfio = $this->request->get['shortfio'];
		} else {
			$shortfio = null;
		}

		if (isset($this->request->get['email1'])) {
			$email1 = $this->request->get['email1'];
		} else {
			$email1 = null;
		}

		if (isset($this->request->get['email2'])) {
			$email2 = $this->request->get['email2'];
		} else {
			$email2 = null;
		}

		if (isset($this->request->get['phone1'])) {
			$phone1 = $this->request->get['phone1'];
		} else {
			$phone1 = null;
		}

		if (isset($this->request->get['phone2'])) {
			$phone2 = $this->request->get['phone2'];
		} else {
			$phone2 = null;
		}

		if (isset($this->request->get['phone3'])) {
			$phone3 = $this->request->get['phone3'];
		} else {
			$phone3 = null;
		}

		if (isset($this->request->get['telegramid'])) {
			$telegramid = $this->request->get['telegramid'];
		} else {
			$telegramid = null;
		}

		if (isset($this->request->get['city'])) {
			$city = $this->request->get['city'];
		} else {
			$city = null;
		}

		if (isset($this->request->get['address'])) {
			$address = $this->request->get['address'];
		} else {
			$address = null;
		}

		if (isset($this->request->get['comments'])) {
			$comments = $this->request->get['comments'];
		} else {
			$comments = null;
		}

		if (isset($this->request->get['position'])) {
			$position = $this->request->get['position'];
		} else {
			$position = null;
		}

		if (isset($this->request->get['pass_series'])) {
			$pass_series = $this->request->get['pass_series'];
		} else {
			$pass_series = null;
		}

		if (isset($this->request->get['pass_number'])) {
			$pass_number = $this->request->get['pass_number'];
		} else {
			$pass_number = null;
		}

		if (isset($this->request->get['pass_takeby'])) {
			$pass_takeby = $this->request->get['pass_takeby'];
		} else {
			$pass_takeby = null;
		}

		if (isset($this->request->get['pass_takewhen'])) {
			$pass_takewhen = $this->request->get['pass_takewhen'];
		} else {
			$pass_takewhen = null;
		}

		if (isset($this->request->get['pass_scan'])) {
			$pass_scan = $this->request->get['pass_scan'];
		} else {
			$pass_scan = null;
		}

		if (isset($this->request->get['agreement_scan'])) {
			$agreement_scan = $this->request->get['agreement_scan'];
		} else {
			$agreement_scan = null;
		}

		if (isset($this->request->get['status'])) {
			$status = $this->request->get['status'];
		} else {
			$status = null;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('couriers/courier/', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);



		$data['add'] = $this->url->link('couriers/courier/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('couriers/courier/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['products'] = array();

		$filter_data = array(
			'firstname'	  => $firstname,
			'lastname'	  => $lastname,
			'middlename'	  => $middlename,
			'shortfio' => $shortfio,
			'email1'   => $email1,
			'email2'            => $email2,
			'phone1'           => $phone1,
			'phone2'           => $phone2,
			'phone3'           => $phone3,
			'telegramid'           => $telegramid,
			'city'           => $city,
			'address'           => $address,
			'comments'           => $comments,
			'position'           => $position,
			'pass_series'           => $pass_series,
			'pass_number'           => $pass_number,
			'pass_takeby'           => $pass_takeby,
			'pass_takewhen'           => $pass_takewhen,
			'pass_scan'           => $pass_scan,
			'agreement_scan'           => $agreement_scan,
			'status'           => $status,

			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$results = $this->model_couriers_couriers->getAllCouriers();
		foreach ($results as $result) {

			$data['couriers'][] = array(
				'courier_id' => $result['id'],
				'firstname' => $result['firstname'],
				'lastname'       => $result['lastname'],
				'middlename'      => $result['middlename'],
				'shortfio'      => $result['shortfio'],
				'email1'   => $result['email1'],
				'email2'   => $result['email2'],
				'phone1'   => $result['phone1'],
				'phone2'   => $result['phone2'],
				'phone3'   => $result['phone3'],
				'telegramid'   => $result['telegramid'],
				'city'   => $result['city'],
				'address'   => $result['address'],
				'comments'   => $result['comments'],
				'position'   => $result['position'],
				'pass_series'   => $result['pass_series'],
				'pass_number'   => $result['pass_number'],
				'pass_takeby'   => $result['pass_takeby'],
				'pass_takewhen'   => $result['pass_takewhen'],
				'pass_scan'   => $result['pass_scan'],
				'agreement_scan'   => $result['agreement_scan'],
				'status' => $result['status'],
				//'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('couriers/courier/edit', 'token=' . $this->session->data['token'] . '&courier_id=' . $result['id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');


		$data['column_firstname'] = $this->language->get('firstname');
		$data['column_lastname'] = $this->language->get('lastname');
		$data['column_middlename'] = $this->language->get('middlename');
		$data['column_shortfio'] = $this->language->get('shortfio');
		$data['column_email1'] = $this->language->get('email1');
		$data['column_email2'] = $this->language->get('email2');
		$data['column_phone1'] = $this->language->get('phone1');
		$data['column_phone2'] = $this->language->get('phone2');
		$data['column_phone3'] = $this->language->get('phone3');
		$data['column_telegramid'] = $this->language->get('telegramid');
		$data['column_city'] = $this->language->get('city');
		$data['column_address'] = $this->language->get('address');
		$data['column_comments'] = $this->language->get('comments');
		$data['column_position'] = $this->language->get('position');
		$data['column_pass_series'] = $this->language->get('pass_series');
		$data['column_pass_number'] = $this->language->get('pass_number');
		$data['column_pass_takeby'] = $this->language->get('pass_takeby');
		$data['column_pass_takewhen'] = $this->language->get('pass_takewhen');
		$data['column_pass_scan'] = $this->language->get('pass_scan');
		$data['column_agreement_scan'] = $this->language->get('agreement_scan');
		$data['column_status'] = $this->language->get('pass_status');


		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');



		$data['error_warning'] = $this->language->get('error_warning');
		$data['success'] = $this->language->get('success');


		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}



		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('courier/couriers_list.tpl', $data));
	}

	public function add() {
		$this->language->load('module/courier');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('couriers/couriers');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_couriers_couriers->addCourier($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('couriers/courier', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}


	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['courier_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_option'] = $this->language->get('text_option');
		$data['text_option_value'] = $this->language->get('text_option_value');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['column_firstname'] = $this->language->get('firstname');
		$data['column_lastname'] = $this->language->get('lastname');
		$data['column_middlename'] = $this->language->get('middlename');
		$data['column_shortfio'] = $this->language->get('shortfio');
		$data['column_email1'] = $this->language->get('email1');
		$data['column_email2'] = $this->language->get('email2');
		$data['column_phone1'] = $this->language->get('phone1');
		$data['column_phone2'] = $this->language->get('phone2');
		$data['column_phone3'] = $this->language->get('phone3');
		$data['column_telegramid'] = $this->language->get('telegramid');
		$data['column_city'] = $this->language->get('city');
		$data['column_address'] = $this->language->get('address');
		$data['column_comments'] = $this->language->get('comments');
		$data['column_position'] = $this->language->get('position');
		$data['column_pass_series'] = $this->language->get('pass_series');
		$data['column_pass_number'] = $this->language->get('pass_number');
		$data['column_pass_takeby'] = $this->language->get('pass_takeby');
		$data['column_pass_takewhen'] = $this->language->get('pass_takewhen');
		$data['column_pass_scan'] = $this->language->get('pass_scan');
		$data['column_agreement_scan'] = $this->language->get('agreement_scan');
		$data['column_status'] = $this->language->get('status');
		$data['column_button_add'] = $this->language->get('button_add');
		$data['column_button_delete'] = $this->language->get('button_delete');
		$data['column_text_list'] = $this->language->get('text_list');
		$data['column_text_no_results'] = $this->language->get('text_no_results');


		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_attribute_add'] = $this->language->get('button_attribute_add');
		$data['button_option_add'] = $this->language->get('button_option_add');
		$data['button_option_value_add'] = $this->language->get('button_option_value_add');
		$data['button_discount_add'] = $this->language->get('button_discount_add');
		$data['button_special_add'] = $this->language->get('button_special_add');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_recurring_add'] = $this->language->get('button_recurring_add');

		$data['text_confirm'] = $this->language->get('text_confirm');



		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = array();
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['email1'])) {
			$data['error_email1'] = $this->error['email1'];
		} else {
			$data['error_email1'] = '';
		}
		if (isset($this->error['email2'])) {
			$data['error_email2'] = $this->error['email2'];
		} else {
			$data['error_email2'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('couriers/courier/', 'token=' . $this->session->data['token'], 'SSL')
		);


		if (!isset($this->request->get['courier_id'])) {
			$data['action'] = $this->url->link('couriers/courier/add', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('couriers/courier/edit', 'token=' . $this->session->data['token'] . '&courier_id=' . $this->request->get['courier_id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('couriers/courier', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['courier_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$courier_info = $this->model_couriers_couriers->getCourier($this->request->get['courier_id']);
		}

		$data['token'] = $this->session->data['token'];
		$data['ckeditor'] = $this->config->get('config_editor_default');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['lang'] = $this->language->get('lang');



		if (isset($this->request->post['comments'])) {
			$data['comments'] = $this->request->post['comments'];
		} elseif (!empty($courier_info)) {
			$data['comments'] = $courier_info['comments'];
		} else {
			$data['comments'] = '';
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($courier_info)) {
			$data['firstname'] = $courier_info['firstname'];
		}  else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($courier_info)) {
			$data['lastname'] = $courier_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['middlename'])) {
			$data['middlename'] = $this->request->post['middlename'];
		} elseif (!empty($courier_info)) {
			$data['middlename'] = $courier_info['middlename'];
		} else {
			$data['middlename'] = '';
		}

		if (isset($this->request->post['shortfio'])) {
			$data['shortfio'] = $this->request->post['shortfio'];
		} elseif (!empty($courier_info)) {
			$data['shortfio'] = $courier_info['shortfio'];
		} else {
			$data['shortfio'] = '';
		}

		if (isset($this->request->post['email1'])) {
			$data['email1'] = $this->request->post['email1'];
		} elseif (!empty($courier_info)) {
			$data['email1'] = $courier_info['email1'];
		} else {
			$data['email1'] = '';
		}

		if (isset($this->request->post['email2'])) {
			$data['email2'] = $this->request->post['email2'];
		} elseif (!empty($courier_info)) {
			$data['email2'] = $courier_info['email2'];
		} else {
			$data['email2'] = '';
		}

		if (isset($this->request->post['phone1'])) {
			$data['phone1'] = $this->request->post['phone1'];
		} elseif (!empty($courier_info)) {
			$data['phone1'] = $courier_info['phone1'];
		} else {
			$data['phone1'] = '';
		}

		if (isset($this->request->post['phone2'])) {
			$data['phone2'] = $this->request->post['phone2'];
		} elseif (!empty($courier_info)) {
			$data['phone2'] = $courier_info['phone2'];
		} else {
			$data['phone2'] = '';
		}

		if (isset($this->request->post['phone3'])) {
			$data['phone3'] = $this->request->post['phone3'];
		} elseif (!empty($courier_info)) {
			$data['phone3'] = $courier_info['phone3'];
		} else {
			$data['phone3'] = '';
		}

		if (isset($this->request->post['telegramid'])) {
			$data['telegramid'] = $this->request->post['telegramid'];
		} elseif (!empty($courier_info)) {
			$data['telegramid'] = $courier_info['telegramid'];
		} else {
			$data['telegramid'] = '';
		}
		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($courier_info)) {
			$data['city'] = $courier_info['city'];
		} else {
			$data['city'] = '';
		}
		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($courier_info)) {
			$data['address'] = $courier_info['address'];
		} else {
			$data['address'] = '';
		}
		if (isset($this->request->post['position'])) {
			$data['position'] = $this->request->post['position'];
		} elseif (!empty($courier_info)) {
			$data['position'] = $courier_info['position'];
		} else {
			$data['position'] = '';
		}
		if (isset($this->request->post['pass_series'])) {
			$data['pass_series'] = $this->request->post['pass_series'];
		} elseif (!empty($courier_info)) {
			$data['pass_series'] = $courier_info['pass_series'];
		}  else {
			$data['pass_series'] = '';
		}
		if (isset($this->request->post['pass_number'])) {
			$data['pass_number'] = $this->request->post['pass_number'];
		} elseif (!empty($courier_info)) {
			$data['pass_number'] = $courier_info['pass_number'];
		} else {
			$data['pass_number'] = '';
		}
		if (isset($this->request->post['pass_takeby'])) {
			$data['pass_takeby'] = $this->request->post['pass_takeby'];
		} elseif (!empty($courier_info)) {
			$data['pass_takeby'] = $courier_info['pass_takeby'];
		} else {
			$data['pass_takeby'] = '';
		}
		if (isset($this->request->post['pass_takewhen'])) {
			$data['pass_takewhen'] = $this->request->post['pass_takewhen'];
		} elseif (!empty($courier_info)) {
			$data['pass_takewhen'] = $courier_info['pass_takewhen'];
		} else {
			$data['pass_takewhen'] = '';
		}
		if (isset($this->request->post['pass_scan'])) {
			$data['pass_scan'] = $this->request->post['pass_scan'];
		} elseif (!empty($courier_info)) {
			$data['pass_scan'] = $courier_info['pass_scan'];
		} else {
			$data['pass_scan'] = '';
		}
		if (isset($this->request->post['agreement_scan'])) {
			$data['agreement_scan'] = $this->request->post['agreement_scan'];
		} elseif (!empty($courier_info)) {
			$data['agreement_scan'] = $courier_info['agreement_scan'];
		} else {
			$data['agreement_scan'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($courier_info)) {
			$data['status'] = $courier_info['status'];
		}  else {
			$data['status'] = '';
		}






		if ($this->config->get('config_product_upc_hide') != 0) {
			$data['hide_upc'] = true;
		} else {
			$data['hide_upc'] = false;
		}

		if ($this->config->get('config_product_ean_hide') != 0) {
			$data['hide_ean'] = true;
		} else {
			$data['hide_ean'] = false;
		}

		if ($this->config->get('config_product_jan_hide') != 0) {
			$data['hide_jan'] = true;
		} else {
			$data['hide_jan'] = false;
		}

		if ($this->config->get('config_product_isbn_hide') != 0) {
			$data['hide_isbn'] = true;
		} else {
			$data['hide_isbn'] = false;
		}

		if ($this->config->get('config_product_mpn_hide') != 0) {
			$data['hide_mpn'] = true;
		} else {
			$data['hide_mpn'] = false;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('courier/couriers_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'couriers/courier')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['firstname']) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}
		if (!$this->request->post['lastname']) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ($this->request->post['email1']){
			preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $this->request->post['email1'], $match);
			if (empty($match)){ $this->error['email1'] = $this->language->get('error_email1'); }
		}
		if ($this->request->post['email2']){
			preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $this->request->post['email2'], $match);
			if (empty($match)){ $this->error['email2'] = $this->language->get('error_email2'); }
		}


		return !$this->error;
	}


	public function edit() {
		$this->language->load('module/courier');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('couriers/couriers');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_couriers_couriers->editCourier($this->request->get['courier_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('couriers/courier', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('module/courier');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('couriers/couriers');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $courier_id) {
				$this->model_couriers_couriers->deleteCourier($courier_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('couriers/courier', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}
}
