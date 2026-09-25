<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hosting_services extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Hosting_Services_model'); // Model for hosting_services table
        $this->load->model('Datatable_model');       // For DataTables AJAX
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    // ===== Main page =====
    public function index()
    {
        $this->load->view('hosting_services/hosting_view');
    }

    // ===== Fetch data for DataTables =====
    public function fetch()
    {
        $columns = ['name'];
        $result = $this->Datatable_model->fetch_data('hosting_services', $columns, ['column' => 'name', 'dir' => 'asc']);

        $data = [];
        foreach ($result['data'] as $h) {
            $data[] = [
                'name' => $h->name,
                'id'   => $h->id
            ];
        }

        $result['data'] = $data;
        echo json_encode($result);
    }

    // ===== Add Hosting Service (Standalone AJAX page) =====
    public function add()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Hosting Service Name', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $insert = ['name' => $this->input->post('name', TRUE)];
                if ($this->Hosting_Services_model->insert($insert)) {
                    echo json_encode(['status' => 'success', 'message' => 'Hosting Service added successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add Hosting Service.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            }
        } else {
            // Load the standalone Add page
            $this->load->view('hosting_services/add');
        }
    }

    // ===== Edit Hosting Service (Standalone AJAX page) =====
    public function edit($id)
    {
        $hosting = $this->Hosting_Services_model->get_by_id($id);
        if (!$hosting) show_404();

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Hosting Service Name', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $update = ['name' => $this->input->post('name', TRUE)];
                if ($this->Hosting_Services_model->update($id, $update)) {
                    echo json_encode(['status' => 'success', 'message' => 'Hosting Service updated successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update Hosting Service.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            }
        } else {
            // Load the standalone Edit page
            $data['hosting'] = $hosting;
            $this->load->view('hosting_services/edit', $data);
        }
    }

    // ===== Delete Hosting Service =====
    public function delete($id)
    {
        if ($this->Hosting_Services_model->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Hosting Service deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete Hosting Service.']);
        }
    }
}
