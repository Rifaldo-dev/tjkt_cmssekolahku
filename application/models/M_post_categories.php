<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CMS Sekolahku | CMS (Content Management System) dan PPDB/PMB Online GRATIS 
 * untuk sekolah SD/Sederajat, SMP/Sederajat, SMA/Sederajat, dan Perguruan Tinggi
 * @version    2.0.0
 * @author     Anton Sofyan | https://facebook.com/antonsofyan | 4ntonsofyan@gmail.com | 0857 5988 8922
 * @copyright  (c) 2014-2017
 * @link       http://sekolahku.web.id
 * @since      Version 2.0.0
 *
 * PERINGATAN :
 * 1. TIDAK DIPERKENANKAN MEMPERJUALBELIKAN APLIKASI INI TANPA SEIZIN DARI PIHAK PENGEMBANG APLIKASI.
 * 2. TIDAK DIPERKENANKAN MENGHAPUS KODE SUMBER APLIKASI.
 * 3. TIDAK MENYERTAKAN LINK KOMERSIL (JASA LAYANAN HOSTING DAN DOMAIN) YANG MENGUNTUNGKAN SEPIHAK.
 */

class M_post_categories extends CI_Model {

	/**
	 * Primary key
	 * @var string
	 */
	public static $pk = 'id';

	/**
	 * Table
	 * @var string
	 */
	public static $table = 'post_categories';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get data for pagination
	 * @param string
	 * @param int
	 * @param int
	 * @return Query
	 */
	public function get_where($keyword, $limit = 0, $offset = 0, $sort_field = '', $sort_type = 'ASC') {
		$this->db->select('id, category, description, slug, is_deleted');
		$this->db->like('category', $keyword);
		$this->db->or_like('description', $keyword);
		$this->db->or_like('slug', $keyword);
		if ($sort_field != '') {
			$this->db->order_by($sort_field, $sort_type);
		}
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		return $this->db->get(self::$table);
	}

	/**
	 * Get all data
	 * @return Query
	 */
	public function get_all() {
		return $this->db
			->select('id, category, slug, description')
			->where('is_deleted', 'false')
			->get(self::$table);
	}

	/**
	 * Get Total row for pagination
	 * @param string
	 * @return int
	 */
	public function total_rows($keyword) {
		return $this->db
			->like('category', $keyword)
			->or_like('description', $keyword)
			->or_like('slug', $keyword)
			->count_all_results(self::$table);
	}

	/**
	 * Dropdown
	 * @return array
	 */
	public function dropdown() {
		$this->db->select('id, category');
		$query = $this->db->get(self::$table);
		$data = [];
		foreach($query->result() as $row) {
			$data[$row->id] = $row->category;
		}
		return $data;
	}

	/**
	 * custom Save
	 * @param Array
	 * @return Int
	 */
	public function save($fill_data) {
		$query = $this->db->insert(self::$table, $fill_data);
		return $query ? $this->db->insert_id() : 0;
	}

	/**
	 * Get All Post Categories
	 * @access public
	 * @return Query
	 */
	public function get_post_categories($limit = null) {
		$this->db->select('id, category, slug, description');
		$this->db->where('is_deleted', 'false');
		if ($limit) {
			$this->db->limit($limit);
		}
		return $this->db->get(self::$table);
	}
}