<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datatable_model extends CI_Model
{
    /**
     * Fetch server-side data for DataTables
     *
     * @param string $table Table name
     * @param array $columns Columns to select and search
     * @param array $order Default ordering ['column' => 'name', 'dir' => 'asc']
     * @return array
     */
    public function fetch_data($table, $columns, $order = ['column' => 'id', 'dir' => 'asc'])
    {
        $search = $this->input->post('search')['value'];
        $start  = $this->input->post('start');
        $length = $this->input->post('length');
        $order_column_index = $this->input->post('order')[0]['column'] ?? 0;
        $order_dir = $this->input->post('order')[0]['dir'] ?? 'asc';

        $order_column = $columns[$order_column_index] ?? $order['column'];

        // Total records
        $total_records = $this->db->count_all($table);

        // Filtered records
        if (!empty($search)) {
            $this->db->group_start();
            foreach ($columns as $col) {
                $this->db->or_like($col, $search);
            }
            $this->db->group_end();
        }

        $this->db->order_by($order_column, $order_dir);
        $this->db->limit($length, $start);

        $query = $this->db->get($table);
        $filtered_records = $query->num_rows(); // number after filter

        return [
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => $total_records,
            'recordsFiltered' => $this->count_filtered($table, $columns, $search),
            'data' => $query->result()
        ];
    }

    private function count_filtered($table, $columns, $search)
    {
        if (!empty($search)) {
            $this->db->group_start();
            foreach ($columns as $col) {
                $this->db->or_like($col, $search);
            }
            $this->db->group_end();
        }
        return $this->db->count_all_results($table);
    }
}
