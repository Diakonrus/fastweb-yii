<?php
class ModelCouriersCouriers extends Model {
	public function addCourier($data) {

		$this->db->query("INSERT INTO couriers SET
			firstname = '" . $data['firstname'] . "',
			lastname = '" . $data['firstname'] . "',
			middlename = '" . $data['middlename'] . "',
			shortfio = '" . $data['shortfio'] . "',
			email1 = '" . $data['email1'] . "',
			email2 = '" . $data['email2'] . "',
			phone1 = '" . $data['phone1'] . "',
			phone2 = '" . $data['phone2'] . "',
			phone3 = '" . $data['phone3'] . "',
			telegramid = '" . $data['telegramid'] . "',
			city = '" . $data['city'] . "',
			address = '" . $data['address'] . "',
			comments = '" . $data['comments'] . "',
			`position` = '" . $data['position'] . "',
			pass_number = '" . $data['pass_number'] . "',
			pass_takeby = '" . $data['pass_takeby'] . "',
			pass_takewhen = '" . $data['pass_takewhen'] . "',
			pass_scan = '" . $data['pass_scan'] . "',
			agreement_scan = '" . $data['agreement_scan'] . "',
			`status` = '" . (int)$data['status'] . "',
			created_at = NOW(), updated_at = NOW()");

		$courier_id = $this->db->getLastId();


		return $courier_id;
	}

	public function getAllCouriers() {
		$query = $this->db->query("SELECT * FROM  couriers");

		$couriers_data = array();
		foreach ($query->rows as $row) {
			$couriers_data[$row['id']] = $row;
		}
		return $couriers_data;
	}

	public function getCourier($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM couriers WHERE id = '" . (int)$id ."'");

		return $query->row;
	}

	public function editCourier($id, $data) {

		$this->db->query("UPDATE couriers SET
			firstname = '" . $this->db->escape($data['firstname']) . "',
			lastname = '" . $this->db->escape($data['lastname']) . "',
			middlename = '" . $this->db->escape($data['middlename']) . "',
			shortfio = '" . $this->db->escape($data['shortfio']) . "',
			email1 = '" . $this->db->escape($data['email1']) . "',
			email2 = '" . $this->db->escape($data['email2']) . "',
			phone1 = '" . $this->db->escape($data['phone1']) . "',
			phone2 = '" . $this->db->escape($data['phone2']) . "',
			phone3 = '" . $this->db->escape($data['phone3']) . "',
			telegramid = '" . $this->db->escape($data['telegramid']) . "',
			city = '" . $this->db->escape($data['city']) . "',
			address = '" . $this->db->escape($data['address']) . "',
			comments = '" . $this->db->escape($data['comments']) . "',
			`position` = '" . $this->db->escape($data['position']) . "',
			pass_series = '" . $this->db->escape($data['pass_series']) . "',
			pass_number = '" . $this->db->escape($data['pass_number']) . "',
			pass_takeby = '" . $this->db->escape($data['pass_takeby']) . "',
			pass_takewhen = '" . $this->db->escape($data['pass_takewhen']) . "',
			pass_scan = '" . $this->db->escape($data['pass_scan']) . "',
			agreement_scan = '" . $this->db->escape($data['agreement_scan']) . "',
			`status` = '" . (int)$data['status'] . "',
			updated_at = NOW()
			WHERE id = '" . (int)$id . "'");
	}


	public function deleteCourier($id) {
		$this->db->query("DELETE FROM couriers WHERE id = '" . (int)$id . "'");

	}


}
