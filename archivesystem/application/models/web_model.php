<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web_model extends CI_Model
{
    protected $table = 'web';
    protected $column_order = [
        'web.domain', 'web.username', 'web.password', 'web.hosting_link',
        'hosting_services.name', 'web.hosting_company', 'web.period', 'web.cost',
        'web.price', 'web.ip_address', 'web.start_date', 'web.expiring_date', 'web.recharge_date'
    ];
    protected $column_search = [
        'web.domain', 'web.username', 'web.password',
        'web.hosting_link', 'hosting_services.name', 'web.hosting_company',
        'web.period', 'web.cost', 'web.price', 'web.ip_address'
    ];
    protected $order = ['web.id' => 'DESC'];

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /** ---------------- Websites ---------------- */

    private function _get_datatables_query($customer_id = null)
    {
        $this->db->select('
            web.*,
            hosting_services.name as hosting_service_name
        ');
        $this->db->from($this->table);
        $this->db->join('hosting_services', 'hosting_services.id = web.hosting_id', 'left');

        if (!empty($customer_id)) {
            $this->db->where('web.customer_id', $customer_id);
        }

        $i = 0;
        foreach ($this->column_search as $item) {
            if (!empty($_POST['search']['value'])) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by(
                $this->column_order[$_POST['order']['0']['column']],
                $_POST['order']['0']['dir']
            );
        } else {
            $this->db->order_by(key($this->order), $this->order[key($this->order)]);
        }
    }

    public function get_datatables($customer_id = null)
    {
        $this->_get_datatables_query($customer_id);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        return $this->db->get()->result();
    }

    public function count_filtered($customer_id = null)
    {
        $this->_get_datatables_query($customer_id);
        return $this->db->get()->num_rows();
    }

    public function count_all($customer_id = null)
    {
        $this->db->from($this->table);
        if (!empty($customer_id)) {
            $this->db->where('customer_id', $customer_id);
        }
        return $this->db->count_all_results();
    }

    public function get_all()
    {
        $this->db->select('
            web.*,
            hosting_services.name as hosting_service_name
        ');
        $this->db->from($this->table);
        $this->db->join('hosting_services', 'hosting_services.id = web.hosting_id', 'left');

        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('
            web.*,
            hosting_services.name as hosting_service_name
        ');
        $this->db->from($this->table);
        $this->db->join('hosting_services', 'hosting_services.id = web.hosting_id', 'left');
        $this->db->where('web.id', $id);

        return $this->db->get()->row();
    }

    public function insert($data)
    {
        $insertData = array_merge([
            'start_date'    => null,
            'expiring_date' => null,
            'recharge_date' => null
        ], $data);

        $this->db->insert($this->table, $insertData);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $updateData = array_merge([
            'start_date'    => null,
            'expiring_date' => null,
            'recharge_date' => null
        ], $data);

        $this->db->where('id', $id);
        return $this->db->update($this->table, $updateData);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function get_all_hosting_services()
    {
        return $this->db->get('hosting_services')->result();
    }

    public function get_hosting_service_by_id($id)
    {
        return $this->db->where('id', $id)->get('hosting_services')->row();
    }

    /** ---------------- Emails ---------------- */

    public function get_emails_by_web_id($web_id)
    {
        $this->db->select('emails.*, web.domain');
        $this->db->from('emails');
        $this->db->join('web', 'web.id = emails.web_id', 'left');
        $this->db->where('emails.web_id', $web_id);

        return $this->db->get()->result();
    }

    public function get_email_by_id($id)
    {
        return $this->db->where('id', $id)->get('emails')->row();
    }

    public function insert_email($data)
    {
        $insertData = [
            'email'  => $data['email'],
            'web_id' => $data['web_id']
        ];

        $this->db->insert('emails', $insertData);
        return $this->db->insert_id();
    }

    public function update_email($id, $data)
    {
        $emailRow = $this->get_email_by_id($id);
        if (!$emailRow) return false;

        $updateData = [
            'email' => $data['email']
        ];

        $this->db->where('id', $id);
        return $this->db->update('emails', $updateData);
    }

    public function delete_email($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('emails');
    }
}
