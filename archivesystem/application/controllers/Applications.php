<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Applications_model $Applications_model
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 */
class Applications extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Applications_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    // ===== Add Platform for a Mobile User =====
    public function add()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $mobile_id   = $this->input->post('mobile_id', TRUE);
        $platform_id = $this->input->post('platform_id', TRUE);
        $email       = $this->input->post('email', TRUE);
        $password    = $this->input->post('password', TRUE);

        // Validation rules
        $this->form_validation->set_rules('mobile_id', 'Mobile User', 'required|integer');
        $this->form_validation->set_rules('platform_id', 'Platform', 'required|integer');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode([
                'success' => false,
                'message' => validation_errors()
            ]);
            return;
        }

        $insert_data = [
            'mobile_id'         => $mobile_id,
            'platform_id'       => $platform_id,
            'platform_email'    => $email,
            'platform_password' => $password
        ];

        $inserted_id = $this->Applications_model->insert_application($insert_data);

        echo json_encode([
            'success'        => $inserted_id ? true : false,
            'message'        => $inserted_id ? 'Platform added successfully.' : 'Failed to add platform.',
            'application_id' => $inserted_id
        ]);
    }

    // ===== Fetch Platforms by Mobile User =====
    public function get_by_mobile($mobile_id)
    {
        if (!$this->input->is_ajax_request()) show_404();

        $mobile_id = intval($mobile_id);
        if (!$mobile_id) {
            echo json_encode([]);
            return;
        }

        $platforms = $this->Applications_model->get_by_mobile($mobile_id);

        $data = [];
        foreach ($platforms as $p) {
            $data[] = [
                'id'                => $p->id,
                'mobile_id'         => $p->mobile_id,
                'platform_name'     => $p->platform_name,
                'platform_email'    => $p->platform_email,
                'platform_password' => $p->platform_password,
                'created_at'        => $p->created_at ?? ''
            ];
        }

        echo json_encode([
            'draw'            => intval($this->input->post('draw') ?? 1),
            'recordsTotal'    => count($data),
            'recordsFiltered' => count($data),
            'data'            => $data
        ]);
    }

    // ===== Get single application by ID =====
    public function get($application_id)
    {
        if (!$this->input->is_ajax_request()) show_404();

        $app = $this->Applications_model->get_by_id($application_id);
        if(!$app){
            echo json_encode(['success' => false, 'message' => 'Application not found']);
            return;
        }

        echo json_encode($app);
    }

    // ===== Fetch all platforms for dropdown =====
    public function get_platforms()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $platforms = $this->Applications_model->get_all_platforms();

        echo json_encode($platforms);
    }

    // ===== Update Platform =====
    public function update()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id = $this->input->post('id', TRUE);
        $data = [
            'platform_id'       => $this->input->post('platform_id', TRUE),
            'platform_email'    => $this->input->post('platform_email', TRUE),
            'platform_password' => $this->input->post('platform_password', TRUE)
        ];

        $updated = $this->Applications_model->update_application($id, $data);

        echo json_encode([
            'success' => $updated ? true : false,
            'message' => $updated ? 'Application updated successfully' : 'Failed to update application'
        ]);
    }

    // ===== Delete single Platform =====
    public function delete($application_id)
    {
        if (!$this->input->is_ajax_request()) show_404();

        $application_id = intval($application_id);
        if(!$application_id){
            echo json_encode(['success' => false, 'message' => 'Invalid application ID']);
            return;
        }

        $deleted = $this->Applications_model->delete_by_id($application_id);

        echo json_encode([
            'success' => $deleted ? true : false,
            'message' => $deleted ? 'Application deleted successfully' : 'Failed to delete application'
        ]);
    }
}
