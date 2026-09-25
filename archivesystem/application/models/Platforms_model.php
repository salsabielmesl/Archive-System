<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Platforms_model extends CI_Model
{
    private $table = 'platforms';

    public function __construct()
    {
        parent::__construct();
    }

    // ===== Insert new platform =====
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // ===== Get platform by ID =====
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    // ===== Update platform =====
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // ===== Delete platform =====
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    // ===== Get all platforms (for dropdown) =====
    public function get_all()
    {
        return $this->db
            ->select('id, app_platform')
            ->order_by('app_platform', 'ASC')
            ->get($this->table)
            ->result();
    }
}
