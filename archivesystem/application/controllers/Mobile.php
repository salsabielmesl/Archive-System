<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Mobile_model $Mobile_model
 * @property Customer_model $Customer_model
 * @property Web_model $Web_model
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 */
class Mobile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mobile_model');
        $this->load->model('Customer_model');
        $this->load->model('Web_model'); // Domains
        $this->load->helper(['url','form']);
        $this->load->library('form_validation');
    }

    // ===== Mobile Users List =====
    public function index()
    {
        $this->load->view('mobile/mobile_view');
    }

    // ===== Fetch Mobile Users for DataTable =====
    public function fetch()
    {
        $start    = intval($this->input->post('start') ?? 0);
        $length   = intval($this->input->post('length') ?? 10);
        $draw     = intval($this->input->post('draw') ?? 1);
        $search   = $this->input->post('search')['value'] ?? '';

        $columns = [
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
        $order   = $this->input->post('order')[0] ?? ['column'=>1,'dir'=>'asc'];
        $order_column = $columns[intval($order['column'] ?? 1)] ?? 'app_name';
        $order_dir    = $order['dir'] ?? 'asc';

        $totalRecords    = $this->Mobile_model->count_all();
        $filteredRecords = $this->Mobile_model->count_filtered($search);

        $users = $this->Mobile_model->get_datatables($search, intval(array_search($order_column, $columns)), $order_dir, $start, $length);

        $data = [];
        foreach($users as $u){
            $data[] = [
                'id'              => $u->id,
                'customer_name'   => $u->customer_name ?? 'N/A',
                'app_name'        => $u->app_name ?? '',
                'email'           => $u->email ?? '',
                'password'        => $u->password ?? '',
                'username'        => $u->username ?? '',
                'domain_name'     => $u->domain_name ?? '',
                'admin_page_link' => $u->admin_page_link ?? '',
                'api_main_path'   => $u->api_main_path ?? '',
                'app_key'         => $u->app_key ?? '',
                'note'            => $u->note ?? ''
            ];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data
        ]);
        exit;
    }

    // ===== Add Mobile User with multiple platforms =====
    public function add()
    {
        $data['customers'] = $this->Customer_model->get_all_customers();
        $data['domains']   = $this->Web_model->get_all();
        $data['platforms'] = $this->Mobile_model->get_platforms();

        if ($this->input->post()) {
            $this->form_validation->set_rules('customer_id', 'Customer', 'required|integer');
            $this->form_validation->set_rules('app_name', 'Application Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
            // domain is now optional
            $this->form_validation->set_rules('domain', 'Domain', 'trim');
            $this->form_validation->set_rules('note', 'Note', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $insert_data = [
                    'customer_id'     => $this->input->post('customer_id', TRUE),
                    'app_name'        => $this->input->post('app_name', TRUE),
                    'email'           => $this->input->post('email', TRUE),
                    'password'        => $this->input->post('password', TRUE),
                    'username'        => $this->input->post('username', TRUE) ?: '',
                    'domain'          => $this->input->post('domain', TRUE) ?: null,
                    'admin_page_link' => $this->input->post('admin_page_link', TRUE) ?: '',
                    'api_main_path'   => $this->input->post('api_main_path', TRUE) ?: '',
                    'app_key'         => $this->input->post('app_key', TRUE) ?: '',
                    'note'            => $this->input->post('note', TRUE) ?: ''
                ];

                $mobile_id = $this->Mobile_model->insert($insert_data);

                if(!$mobile_id){
                    $msg = 'Failed to add mobile user.';
                    echo $this->input->is_ajax_request() ? json_encode(['success'=>false,'message'=>$msg]) : show_error($msg);
                    return;
                }

                // Insert multiple platforms
                $platforms = $this->input->post('platforms') ?? [];
                if(!is_array($platforms)) $platforms = [];

                foreach ($platforms as $p) {
                    if (empty($p['platform_id'])) continue;
                    $platform_data = [
                        'mobile_id'         => $mobile_id,
                        'platform_id'       => $p['platform_id'],
                        'platform_email'    => $p['platform_email'] ?? '',
                        'platform_password' => $p['platform_password'] ?? ''
                    ];
                    $this->Mobile_model->insert_platform($platform_data);
                }

                if ($this->input->is_ajax_request()) {
                    echo json_encode(['success' => true, 'mobile_id' => $mobile_id]);
                    return;
                } else {
                    $this->session->set_flashdata('success', 'Mobile user and platforms added successfully.');
                    redirect('mobile');
                }
            } else {
                if ($this->input->is_ajax_request()) {
                    echo json_encode(['success' => false, 'message' => validation_errors()]);
                    return;
                }
            }
        }

        $this->load->view('mobile/add', $data);
    }

    // ===== Edit Mobile User =====
    public function edit($id)
    {
        $mobile = $this->Mobile_model->get_by_id($id);
        if (!$mobile) show_404();

        $data['customers'] = $this->Customer_model->get_all_customers();
        $data['domains']   = $this->Web_model->get_all();
        $data['platforms'] = $this->Mobile_model->get_platforms();
        $data['mobile']    = $mobile;

        if ($this->input->post()) {
            $this->form_validation->set_rules('customer_id', 'Customer', 'required|integer');
            $this->form_validation->set_rules('app_name', 'Application Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('domain', 'Domain', 'trim'); // optional now

            if ($this->form_validation->run() === TRUE) {
                $update_data = [
                    'customer_id'     => $this->input->post('customer_id', TRUE),
                    'app_name'        => $this->input->post('app_name', TRUE),
                    'email'           => $this->input->post('email', TRUE),
                    'username'        => $this->input->post('username', TRUE) ?: '',
                    'domain'          => $this->input->post('domain', TRUE) ?: null,
                    'admin_page_link' => $this->input->post('admin_page_link', TRUE) ?: '',
                    'api_main_path'   => $this->input->post('api_main_path', TRUE) ?: '',
                    'app_key'         => $this->input->post('app_key', TRUE) ?: '',
                    'note'            => $this->input->post('note', TRUE) ?: '',
                    'password'        => $this->input->post('password', TRUE) ?: $mobile->password
                ];

                $success = $this->Mobile_model->update($id, $update_data);

                if ($this->input->is_ajax_request()) {
                    echo json_encode([
                        'success' => $success,
                        'message' => $success ? 'Mobile user updated successfully.' : 'Failed to update mobile user.'
                    ]);
                    return;
                } else {
                    $this->session->set_flashdata('success', $success ? 'Mobile user updated successfully.' : 'Failed to update mobile user.');
                    redirect('mobile');
                }
            } else {
                if ($this->input->is_ajax_request()) {
                    echo json_encode([
                        'success' => false,
                        'message' => validation_errors()
                    ]);
                    return;
                }
            }
        }

        $this->load->view('mobile/edit', $data);
    }

    // ===== Delete Mobile User =====
// In mobile controller delete method
public function delete($id) {
    $success = $this->Mobile_model->delete($id); // your delete logic

    if($success){
        echo json_encode(['success' => true, 'message' => 'Mobile user deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete mobile user']);
    }
}

}
