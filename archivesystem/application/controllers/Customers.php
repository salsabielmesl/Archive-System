<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Customer_model $Customer_model
 * @property Datatable_model $Datatable_model
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 */
class Customers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('Datatable_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    // ===== Customers List =====
    public function index()
    {
        $this->load->view('customers/customers_view');
    }

    // ===== Fetch Customers for DataTable (AJAX) =====
    public function fetch()
    {
        $columns = ['name', 'phone', 'phone2', 'email', 'start_date', 'end_date', 'active'];
        $result = $this->Datatable_model->fetch_data('customers', $columns, ['column' => 'name', 'dir' => 'asc']);

        $data = [];
        foreach ($result['data'] as $c) {
            $data[] = [
                'name'       => $c->name,
                'phone'      => $c->phone,
                'phone2'     => $c->phone2,
                'email'      => $c->email,
                'start_date' => $c->start_date,
                'end_date'   => $c->end_date,
                'active'     => ucfirst($c->active),
                'id'         => $c->id
            ];
        }

        $result['data'] = $data;
        echo json_encode($result);
    }

    // ===== Add Customer (AJAX-enabled) =====
    public function add()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
            $this->form_validation->set_rules('phone2', 'Phone 2', 'trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required|trim');
            $this->form_validation->set_rules('end_date', 'End Date', 'trim');
            $this->form_validation->set_rules('active', 'Active', 'required|in_list[yes,no]');

            if ($this->form_validation->run() === TRUE) {
                $insert_data = [
                    'name'       => $this->input->post('name', TRUE),
                    'phone'      => $this->input->post('phone', TRUE),
                    'phone2'     => $this->input->post('phone2', TRUE),
                    'email'      => $this->input->post('email', TRUE),
                    'start_date' => $this->input->post('start_date', TRUE),
                    'end_date'   => $this->input->post('end_date', TRUE),
                    'active'     => $this->input->post('active', TRUE)
                ];

                $inserted = $this->Customer_model->insert($insert_data);

                if ($this->input->is_ajax_request()) {
                    echo json_encode([
                        'status' => $inserted ? 'success' : 'error',
                        'message' => $inserted ? 'Customer added successfully!' : 'Failed to add customer.'
                    ]);
                    return;
                }

                if ($inserted) {
                    $this->session->set_flashdata('success', 'Customer added successfully.');
                    redirect('customers');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add customer.');
                    redirect('customers/add');
                }
            } else {
                if ($this->input->is_ajax_request()) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => validation_errors()
                    ]);
                    return;
                }
            }
        }

        $this->load->view('customers/add');
    }

    // ===== Edit Customer (AJAX-enabled) =====
    public function edit($id)
    {
        $customer = $this->Customer_model->get_by_id($id);
        if (!$customer) show_404();

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
            $this->form_validation->set_rules('phone2', 'Phone 2', 'trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required|trim');
            $this->form_validation->set_rules('end_date', 'End Date', 'trim');
            $this->form_validation->set_rules('active', 'Active', 'required|in_list[yes,no]');

            if ($this->form_validation->run() === TRUE) {
                $update_data = [
                    'name'       => $this->input->post('name', TRUE),
                    'phone'      => $this->input->post('phone', TRUE),
                    'phone2'     => $this->input->post('phone2', TRUE),
                    'email'      => $this->input->post('email', TRUE),
                    'start_date' => $this->input->post('start_date', TRUE),
                    'end_date'   => $this->input->post('end_date', TRUE),
                    'active'     => $this->input->post('active', TRUE)
                ];

                $this->Customer_model->update($id, $update_data);

                if ($this->input->is_ajax_request()) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Customer updated successfully!'
                    ]);
                    return;
                }

                $this->session->set_flashdata('success', 'Customer updated successfully.');
                redirect('customers');
            } else {
                if ($this->input->is_ajax_request()) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => validation_errors()
                    ]);
                    return;
                }
            }
        }

        $data['customer'] = $customer;
        $this->load->view('customers/edit', $data);
    }

    // ===== Delete Customer (AJAX-enabled) =====
    public function delete($id)
    {
        if ($this->input->is_ajax_request()) {
            $deleted = $this->Customer_model->delete($id);

            echo json_encode([
                'status' => $deleted ? 'success' : 'error',
                'message' => $deleted ? 'Customer deleted successfully!' : 'Failed to delete customer.'
            ]);
            return;
        }

        // Normal fallback
        if ($id) {
            $this->Customer_model->delete($id);
            $this->session->set_flashdata('success', 'Customer deleted successfully.');
        }
        redirect('customers');
    }
}
