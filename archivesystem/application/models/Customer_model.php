<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // ===== Fetch all customers =====
    public function get_all_customers()
    {
        return $this->db->get('customers')->result();
    }

    // ===== Fetch a single customer by ID =====
    public function get_by_id($id)
    {
        return $this->db->get_where('customers', ['id' => $id])->row();
    }

    // ===== Insert a new customer =====
    public function insert($data)
    {
        // Ensure start_date is set (default to today if not provided)
        if (!isset($data['start_date']) || empty($data['start_date'])) {
            $data['start_date'] = date('Y-m-d');
        }

        // Ensure end_date is null if not set
        if (!isset($data['end_date']) || empty($data['end_date'])) {
            $data['end_date'] = null;
        }

        // Ensure active is set (default 'yes')
        if (!isset($data['active']) || !in_array($data['active'], ['yes', 'no'])) {
            $data['active'] = 'yes';
        }

        return $this->db->insert('customers', $data);
    }

    // ===== Update an existing customer =====
    public function update($id, $data)
    {
        // Preserve existing start_date if not provided
        if (!isset($data['start_date'])) {
            $existing = $this->db->select('start_date')->get_where('customers', ['id' => $id])->row();
            if ($existing) {
                $data['start_date'] = $existing->start_date;
            }
        }

        // Preserve existing end_date if not provided
        if (!isset($data['end_date'])) {
            $existing = $this->db->select('end_date')->get_where('customers', ['id' => $id])->row();
            if ($existing) {
                $data['end_date'] = $existing->end_date;
            }
        }

        // Ensure active is valid
        if (!isset($data['active']) || !in_array($data['active'], ['yes', 'no'])) {
            $existing = $this->db->select('active')->get_where('customers', ['id' => $id])->row();
            if ($existing) {
                $data['active'] = $existing->active;
            } else {
                $data['active'] = 'yes';
            }
        }

        $this->db->where('id', $id);
        return $this->db->update('customers', $data);
    }

    // ===== Delete a customer =====
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('customers');
    }

    // ===== Count total customers =====
    public function count_all()
    {
        return $this->db->count_all('customers');
    }

    // ===== Optional: Check if email is already taken (for editing) =====
    public function is_email_taken($email, $exclude_id = null)
    {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('customers');
        return $query->num_rows() > 0;
    }
}
