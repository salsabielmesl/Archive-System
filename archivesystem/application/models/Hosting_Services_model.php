<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hosting_Services_model extends CI_Model {

    private $table = 'hosting_services';

    public function __construct() {
        parent::__construct();
    }

    // ===== Get all hosting services =====
    public function get_all() {
        return $this->db->select('id, name')
                        ->order_by('name', 'ASC')
                        ->get($this->table)
                        ->result();
    }

    // ===== Get hosting service by ID =====
    public function get_by_id($id) {
        return $this->db->where('id', $id)
                        ->get($this->table)
                        ->row();
    }

    // ===== Insert new hosting service =====
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    // ===== Update hosting service =====
    public function update($id, $data) {
        return $this->db->where('id', $id)
                        ->update($this->table, $data);
    }

    // ===== Delete hosting service =====
    public function delete($id) {
        return $this->db->where('id', $id)
                        ->delete($this->table);
    }
}
