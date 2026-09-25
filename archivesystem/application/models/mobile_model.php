<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile_model extends CI_Model
{
    var $table = 'mobile';
    var $column_order = [
        'customer_name',
        'app_name',
        'email',
        'password',
        'username',
        'domain_name',
        'admin_page_link',
        'api_main_path',
        'app_key',
        'note'
    ];
    var $column_search = [
        'customer_name',
        'app_name',
        'email',
        'password',
        'username',
        'domain_name',
        'admin_page_link',
        'api_main_path',
        'app_key',
        'note'
    ];
    var $order = ['app_name' => 'asc'];

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // ===== CRUD for Mobile Users =====
    public function get_all()
    {
        $this->db->select('mobile.*, 
            IFNULL(customers.name,"N/A") as customer_name, 
            IFNULL(web.domain,"") as domain_name');
        $this->db->from($this->table);
        $this->db->join('customers', 'customers.id = mobile.customer_id', 'left');
        $this->db->join('web', 'web.id = mobile.domain', 'left');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('mobile.*, 
            IFNULL(customers.name,"N/A") as customer_name, 
            IFNULL(web.domain,"") as domain_name');
        $this->db->from($this->table);
        $this->db->join('customers', 'customers.id = mobile.customer_id', 'left');
        $this->db->join('web', 'web.id = mobile.domain', 'left');
        $this->db->where('mobile.id', $id);
        return $this->db->get()->row();
    }

    public function insert($data)
    {
        unset($data['app_platform'], $data['platform_id']);
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        unset($data['app_platform'], $data['platform_id']);
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    // ===== DataTables Support =====
    private function _get_datatables_query($search = null)
    {
        $this->db->select('mobile.*, 
            IFNULL(customers.name,"N/A") as customer_name, 
            IFNULL(web.domain,"") as domain_name');
        $this->db->from($this->table);
        $this->db->join('customers', 'customers.id = mobile.customer_id', 'left');
        $this->db->join('web', 'web.id = mobile.domain', 'left');

        if (!empty($search)) {
            $this->db->group_start();
            foreach ($this->column_search as $col) {
                $this->db->or_like($col, $search);
            }
            $this->db->group_end();
        }
    }

    public function get_datatables($search = null, $order_column = 0, $order_dir = 'asc', $start = 0, $length = 10)
    {
        $this->_get_datatables_query($search);
        $col = isset($this->column_order[$order_column]) ? $this->column_order[$order_column] : 'app_name';
        $this->db->order_by($col, $order_dir);
        if ($length != -1) {
            $this->db->limit($length, $start);
        }
        return $this->db->get()->result();
    }

    public function count_filtered($search = null)
    {
        $this->_get_datatables_query($search);
        return $this->db->count_all_results();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->join('customers', 'customers.id = mobile.customer_id', 'left');
        $this->db->join('web', 'web.id = mobile.domain', 'left');
        return $this->db->count_all_results();
    }

    // ===== Platforms / Applications =====
    public function get_platforms()
    {
        return $this->db->get('platforms')->result();
    }

    public function get_platform_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('platforms')->row();
    }

    public function get_applications_by_mobile($mobile_id)
    {
        return $this->db->where('mobile_id', $mobile_id)
                        ->get('applications')
                        ->result();
    }

    public function insert_platform($data)
    {
        if (!isset($data['mobile_id']) || !isset($data['platform_id'])) return false;
        return $this->db->insert('applications', $data);
    }

    public function update_platform($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('applications', $data);
    }

    public function delete_platform($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('applications');
    }
    
}
