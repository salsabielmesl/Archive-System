<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 * @property Web_model $Web_model
 * @property Customer_model $Customer_model
 * @property Datatable_model $Datatable_model
 */
class Web extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
        $this->load->model('Web_model');
        $this->load->model('Customer_model');
        $this->load->model('Datatable_model');
    }

    /** Display web list */
    public function index()
    {
        $this->load->view('web/web_view'); 
    }

    /** Add a website */
    public function add()
    {
        $data['customers'] = $this->Customer_model->get_all_customers();
        $data['hosting_services'] = $this->Web_model->get_all_hosting_services();

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('domain', 'Domain', 'required|trim');
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
            $this->form_validation->set_rules('customer_id', 'Customer', 'required|integer');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $insertData = [
                    'domain'          => $this->input->post('domain', TRUE),
                    'username'        => $this->input->post('username', TRUE),
                    'password'        => $this->input->post('password', TRUE),
                    'customer_id'     => $this->input->post('customer_id', TRUE),
                    'hosting_link'    => $this->input->post('hosting_link', TRUE) ?: '',
                    'ip_address'      => $this->input->post('ip_address', TRUE) ?: '',
                    'hosting_company' => $this->input->post('hosting_company', TRUE) ?: '',
                    'period'          => $this->input->post('period', TRUE) ?: 0,
                    'cost'            => $this->input->post('cost', TRUE) ?: 0,
                    'price'           => $this->input->post('price', TRUE) ?: 0,
                    'hosting_id'      => $this->input->post('hosting_id') ?: null,
                    'start_date'      => $this->input->post('start_date', TRUE),
                    'expiring_date'   => $this->input->post('expiring_date', TRUE) ?: null,
                    'recharge_date'   => $this->input->post('recharge_date', TRUE) ?: null
                ];

                $result = $this->Web_model->insert($insertData);
                $response = $result 
                    ? ['status'=>'success','message'=>'Website added successfully.'] 
                    : ['status'=>'error','message'=>'Failed to add website.'];

                if ($this->input->is_ajax_request()) {
                    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
                }
                $this->session->set_flashdata('success', $response['message']);
                redirect('Web');
            }

            if ($this->input->is_ajax_request()) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status'=>'error','message'=>validation_errors()]));
            }
        }

        $this->load->view('web/add', $data);
    }

    /** Edit website */
    public function edit($id)
    {
        $web = $this->Web_model->get_by_id($id);
        if (!$web) redirect('Web');

        $data['customers'] = $this->Customer_model->get_all_customers();
        $data['hosting_services'] = $this->Web_model->get_all_hosting_services();
        $data['web'] = $web;

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('domain', 'Domain', 'required|trim');
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
            $this->form_validation->set_rules('customer_id', 'Customer', 'required|integer');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $updateData = [
                    'domain'          => $this->input->post('domain', TRUE),
                    'username'        => $this->input->post('username', TRUE),
                    'password'        => $this->input->post('password', TRUE),
                    'customer_id'     => $this->input->post('customer_id', TRUE),
                    'hosting_link'    => $this->input->post('hosting_link', TRUE) ?: '',
                    'ip_address'      => $this->input->post('ip_address', TRUE) ?: '',
                    'hosting_company' => $this->input->post('hosting_company', TRUE) ?: '',
                    'period'          => $this->input->post('period', TRUE) ?: 0,
                    'cost'            => $this->input->post('cost', TRUE) ?: 0,
                    'price'           => $this->input->post('price', TRUE) ?: 0,
                    'hosting_id'      => $this->input->post('hosting_id') ?: null,
                    'start_date'      => $this->input->post('start_date', TRUE),
                    'expiring_date'   => $this->input->post('expiring_date', TRUE) ?: null,
                    'recharge_date'   => $this->input->post('recharge_date', TRUE) ?: null
                ];

                $updated = $this->Web_model->update($id, $updateData);
                $response = $updated 
                    ? ['status'=>'success','message'=>'Website updated successfully.'] 
                    : ['status'=>'error','message'=>'Failed to update website.'];

                if ($this->input->is_ajax_request()) {
                    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
                }
                $this->session->set_flashdata('success', $response['message']);
                redirect('Web');
            }

            if ($this->input->is_ajax_request()) {
                return $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>'error','message'=>validation_errors()]));
            }
        }

        $this->load->view('web/edit', $data);
    }

    /** Delete website */
    public function delete($id)
    {
        $this->Web_model->delete($id);
        $response = ['status'=>'success','message'=>'Website deleted successfully.'];

        if ($this->input->is_ajax_request()) {
            return $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
        $this->session->set_flashdata('success', $response['message']);
        redirect('Web');
    }

    /** Fetch websites for a customer (info modal) */
    public function fetch_web_by_customer()
    {
        ob_clean();
        $this->output->set_content_type('application/json; charset=utf-8');

        $customer_id = $this->input->post('customer_id');
        $this->db->select('web.*, customers.name as customer_name, hosting_services.name as hosting_service_name')
                 ->from('web')
                 ->join('customers', 'customers.id = web.customer_id', 'left')
                 ->join('hosting_services', 'hosting_services.id = web.hosting_id', 'left');

        if ($customer_id) $this->db->where('web.customer_id', $customer_id);

        $list = $this->db->get()->result();
        $data = [];

        foreach ($list as $web) {
            $data[] = [
                'id'                   => $web->id ?? 0,
                'customer_name'        => $web->customer_name ?? '',
                'domain'               => $web->domain ?? '',
                'username'             => $web->username ?? '',
                'password'             => $web->password ?? '',
                'hosting_link'         => $web->hosting_link ?? '',
                'hosting_service_name' => $web->hosting_service_name ?? '',
                'hosting_company'      => $web->hosting_company ?? '',
                'period'               => $web->period ?? 0,
                'cost'                 => $web->cost ?? 0,
                'price'                => $web->price ?? 0,
                'ip_address'           => $web->ip_address ?? '',
                'start_date'           => $web->start_date ?? '',
                'expiring_date'        => $web->expiring_date ?? '',
                'recharge_date'        => $web->recharge_date ?? '',
                'actions'              => '<a href="'.site_url('Web/edit/'.$web->id).'" class="btn btn-sm btn-warning me-2"><i class="fas fa-edit"></i></a>'
            ];
        }

        echo json_encode($data);
        exit;
    }

    /** Fetch websites for DataTable (server-side) */
    public function fetch_web_datatable()
    {
        $this->output->set_content_type('application/json; charset=utf-8');

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = $this->input->post('search')['value'] ?? '';

        $this->db->start_cache();
        $this->db->select('web.*, customers.name as customer_name, hosting_services.name as hosting_service_name')
                 ->from('web')
                 ->join('customers', 'customers.id = web.customer_id', 'left')
                 ->join('hosting_services', 'hosting_services.id = web.hosting_id', 'left');
        $recordsTotal = $this->db->count_all_results('', FALSE); // count total

        if(!empty($search)) {
            $this->db->group_start()
                     ->like('web.domain', $search)
                     ->or_like('customers.name', $search)
                     ->or_like('web.username', $search)
                     ->group_end();
        }

        $recordsFiltered = $this->db->count_all_results('', FALSE);

        if ($length != -1) $this->db->limit($length, $start);

        $query = $this->db->get();
        $this->db->stop_cache();
        $list = $query->result();
        $this->db->flush_cache();

        $data = [];
        foreach ($list as $web) {
            $data[] = [
                'id'                   => $web->id,
                'customer_name'        => $web->customer_name ?? '',
                'domain'               => $web->domain ?? '',
                'username'             => $web->username ?? '',
                'password'             => $web->password ?? '',
                'hosting_link'         => $web->hosting_link ?? '',
                'hosting_service_name' => $web->hosting_service_name ?? '',
                'hosting_company'      => $web->hosting_company ?? '',
                'period'               => $web->period ?? 0,
                'cost'                 => $web->cost ?? 0,
                'price'                => $web->price ?? 0,
                'ip_address'           => $web->ip_address ?? '',
                'start_date'           => $web->start_date ?? '',
                'expiring_date'        => $web->expiring_date ?? '',
                'recharge_date'        => $web->recharge_date ?? '',
                'description'        => $web->description ?? '',
                'actions'              => '<a href="'.site_url('Web/edit/'.$web->id).'" class="btn btn-sm btn-warning me-2"><i class="fas fa-edit"></i></a>'
            ];
        }

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]);
        exit;
    }

    // ---------------- EMAIL MANAGEMENT ---------------- //

    public function email($web_id)
    {
        $web = $this->Web_model->get_by_id($web_id);
        if (!$web) redirect('Web');

        $data = ['web' => $web, 'web_id' => $web_id];
        $this->load->view('web/email', $data);
    }

    public function fetch_emails()
    {
        $web_id = $this->input->post('web_id', TRUE);
        if (!$web_id) return $this->output->set_content_type('application/json')->set_output(json_encode(['data'=>[]]));

        $emails = $this->Web_model->get_emails_by_web_id($web_id);
        $data = [];
        foreach ($emails as $email) {
            $data[] = [
                'id'      => $email->id,
                'email'   => $email->email,
                'domain'  => $email->domain
            ];
        }

        $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                "draw"            => intval($this->input->post('draw')),
                "recordsTotal"    => count($data),
                "recordsFiltered" => count($data),
                "data"            => $data
            ]));
    }

    public function email_add($web_id)
    {
        $web = $this->Web_model->get_by_id($web_id);
        if (!$web) redirect('Web');

        $data = ['web' => $web, 'web_id' => $web_id];
        $this->load->view('web/email_add', $data);
    }

    public function email_add_action()
{
    $this->form_validation->set_rules('email','Email','required|trim|valid_email');
    $this->form_validation->set_rules('web_id','Web','required|integer');

    if ($this->form_validation->run() === TRUE){
        $web_id = $this->input->post('web_id',TRUE);
        $web = $this->Web_model->get_by_id($web_id);
        if(!$web) return $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>'error','message'=>'Invalid web selected.']));

        // Safely get customer_id
        $customer_id = isset($web->customer_id) ? $web->customer_id : 0;

        $insertData = [
            'email'       => $this->input->post('email',TRUE),
            'customer_id' => $customer_id,
            'web_id'      => $web_id
        ];
        $inserted = $this->Web_model->insert_email($insertData);

        return $this->output->set_content_type('application/json')->set_output(json_encode($inserted
            ? ['status'=>'success','message'=>'Email added successfully.']
            : ['status'=>'error','message'=>'Failed to add email.']));
    }

    return $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>'error','message'=>validation_errors()]));
}

public function email_update($id)
{
    $this->form_validation->set_rules('email','Email','required|trim|valid_email');

    if($this->form_validation->run() === TRUE){
        $emailRow = $this->Web_model->get_email_by_id($id);
        if(!$emailRow) return $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>'error','message'=>'Email not found.']));

        // Safely get customer_id
        $customer_id = isset($emailRow->customer_id) ? $emailRow->customer_id : 0;

        $updateData = [
            'email'       => $this->input->post('email', TRUE),
            'customer_id' => $customer_id
        ];
        $updated = $this->Web_model->update_email($id, $updateData);

        return $this->output->set_content_type('application/json')->set_output(json_encode($updated
            ? ['status'=>'success','message'=>'Email updated successfully.']
            : ['status'=>'error','message'=>'Failed to update email.']));
    }

    return $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>'error','message'=>validation_errors()]));
}
public function email_edit($id)
{
    $email = $this->Web_model->get_email_by_id($id);
    if(!$email) redirect('Web');
    $web = $this->Web_model->get_by_id($email->web_id);

    $data = ['email' => $email, 'web' => $web, 'web_id'=> $email->web_id];
    $this->load->view('web/email_edit', $data);
}
public function delete_email($id)
{
    $deleted = $this->db->where('id', $id)->delete('emails'); // table name

    $response = $deleted
        ? ['status'=>'success','message'=>'Email deleted successfully.']
        : ['status'=>'error','message'=>'Failed to delete email.'];

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}


}
