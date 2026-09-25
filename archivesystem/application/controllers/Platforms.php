<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Platforms extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Platforms_model');   // Model for platforms table
        $this->load->model('Datatable_model');   // Model for DataTables server-side processing
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    // ===== Main page =====
    public function index()
    {
        $this->load->view('platforms/platforms_view');
    }

    // ===== Fetch platforms for DataTables =====
    public function fetch()
    {
        $columns = ['app_platform'];

        $result = $this->Datatable_model->fetch_data('platforms', $columns, ['column' => 'app_platform', 'dir' => 'asc']);

        $data = [];
        foreach ($result['data'] as $p) {
            $data[] = [
                'id'           => $p->id,
                'app_platform' => $p->app_platform
            ];
        }

        $result['data'] = $data;
        echo json_encode($result);
    }

    // ===== Fetch platforms for dropdown =====
    public function fetch_dropdown()
    {
        $platforms = $this->Platforms_model->get_all(); // returns id + app_platform
        echo json_encode($platforms);
    }

    // ===== Add platform =====
    public function add()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('app_platform', 'Platform Name', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $insert = ['app_platform' => $this->input->post('app_platform', TRUE)];
                if ($this->Platforms_model->insert($insert)) {
                    echo json_encode(['status' => 'success', 'message' => 'Platform added successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add platform.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            }
        } else {
            // Load separate page for Add form
            $this->load->view('platforms/add');
        }
    }

    // ===== Edit platform =====
    public function edit($id)
    {
        $platform = $this->Platforms_model->get_by_id($id);
        if (!$platform) show_404();

        if ($this->input->post()) {
            $this->form_validation->set_rules('app_platform', 'Platform Name', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $update = ['app_platform' => $this->input->post('app_platform', TRUE)];
                if ($this->Platforms_model->update($id, $update)) {
                    echo json_encode(['status' => 'success', 'message' => 'Platform updated successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update platform.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            }
        } else {
            // Load separate page for Edit form
            $data['platform'] = $platform;
            $this->load->view('platforms/edit', $data);
        }
    }

    // ===== Delete platform =====
    public function delete($id)
    {
        if ($this->Platforms_model->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Platform deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete platform.']);
        }
    }
}
