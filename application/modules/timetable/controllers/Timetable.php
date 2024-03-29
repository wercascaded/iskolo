<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Timetable extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        User::logged_in();
        $this->load->model(array('App'));
        $this->load->library('form_validation');
    }

    function index()
    {
                $this->load->module('layouts');
                $this->load->library('template');
                $this->template->title('Timetable'. ' @ '. $this->config->item('website_name'));
                $data['fullcalendar'] = TRUE;
                $data['datepicker'] = TRUE;
                $data['form'] = TRUE;
                $data['page'] = lang('calendar');
                $this->template
                ->set_layout('users')
                ->build('calendar',isset($data) ? $data : NULL);

    }
    function settings()
    {
                if ($_POST) {
                    $this->db->where('config_key','gcal_api_key')->update('config',array('value' => $_POST['gcal_api_key']));
                    $this->db->where('config_key','gcal_id')->update('config',array('value' => $_POST['gcal_id']));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->load->view('modal/calendar-settings',isset($data) ? $data : NULL);
                }
    }

    function add_event()
    {
        if(User::is_admin()){

        if ($_POST) {

        $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
        $this->form_validation->set_rules('event_name', lang('event_name'), 'required');
        $this->form_validation->set_rules('start_date', lang('start_date'), 'required');
        $this->form_validation->set_rules('end_date', lang('end_date'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            Applib::go_to($_SERVER['HTTP_REFERER'],'error',lang('error_in_form'));
        }else{
            $start_date = Applib::date_formatter($this->input->post('start_date', TRUE));
            $end_date = Applib::date_formatter($this->input->post('end_date', TRUE));
                    $data = array(
                        'event_name'    => $this->input->post('event_name', TRUE),
                        'description'   => $this->input->post('description', TRUE),
                        'start_date'    => $start_date,
                        'end_date'      => $end_date,
                        'project'       => $this->input->post('project', TRUE),
                        'color'         => $this->input->post('color', TRUE),
                        'added_by'      => User::get_id(),
                        'created'       => date('Y-m-d H:i:s')
                        );
                    $this->db->insert('events', $data);
                    Applib::go_to($_SERVER['HTTP_REFERER'],'success',lang('event_added_success'));
            }
                } else {
                    $this->load->view('modal/add_event',isset($data) ? $data : NULL);
                }
    }
}


function edit_event($id = NULL)
    {
        if(User::is_admin()){

        if ($_POST) {

        $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
        $this->form_validation->set_rules('event_name', lang('event_name'), 'required');
        $this->form_validation->set_rules('start_date', lang('start_date'), 'required');
        $this->form_validation->set_rules('end_date', lang('end_date'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            Applib::go_to($_SERVER['HTTP_REFERER'],'error',lang('error_in_form'));
        }else{
            $start_date = Applib::date_formatter($this->input->post('start_date', TRUE));
            $end_date = Applib::date_formatter($this->input->post('end_date', TRUE));
                    $data = array(
                        'event_name'    => $this->input->post('event_name', TRUE),
                        'description'   => $this->input->post('description', TRUE),
                        'start_date'    => $start_date,
                        'end_date'      => $end_date,
                        'project'       => $this->input->post('project', TRUE),
                        'color'         => $this->input->post('color', TRUE),
                        'added_by'      => User::get_id()
                        );
                    $this->db->where('id',$this->input->post('id', TRUE))->update('events', $data);
                    Applib::go_to($_SERVER['HTTP_REFERER'],'success',lang('event_edited_success'));
            }
                } else {
                    $data['event'] = $this->db->where('id',$id)->get('events')->row();
                    $this->load->view('modal/edit_event',isset($data) ? $data : NULL);
                }
    }
}

        
        function event($type, $id) {
                
            switch ($type) {
                case "tasks" : 
                    $tasks = $this->db
                                ->select('*, fx_tasks.description as task_description', TRUE)
                                ->join('projects','project_id = project')
                                ->join('users','id = added_by')
                                ->where('t_id',$id)
                                ->get('tasks')
                                ->result();
                    $data['task'] = $tasks[0];
                    break;
                case "payments" : 
                    $payments = $this->db
                                ->join('payment_methods','method_id = payment_method')
                                ->join('companies','paid_by = co_id')
                                ->join('invoices','inv_id = invoice')
                                ->where('p_id',$id)
                                ->get('payments')
                                ->result();
                    $data['payment'] = $payments[0];
                    break;
                case "projects" : 
                    $projects = $this->db
                                ->join('companies','client = co_id')
                                ->where('project_id',$id)
                                ->get('projects')
                                ->result();
                    $data['project'] = $projects[0];
                    break;
                case "invoices" : 
                    $invoices = $this->db
                                ->join('companies','client = co_id')
                                ->where('inv_id',$id)
                                ->get('invoices')
                                ->result();
                    $data['invoice'] = $invoices[0];
                    break;
                case "estimates" : 
                    $estimates = $this->db
                                ->join('companies','client = co_id')
                                ->where('est_id',$id)
                                ->get('estimates')
                                ->result();
                    $data['estimate'] = $estimates[0];
                    break;
                case 'events':
                    $events = $this->db
                                ->where('id',$id)
                                ->get('events')
                                ->result();
                    $data['event'] = $events[0];
                    break;
            }

                $this->load->view('modal/event-details',isset($data) ? $data : NULL);
		}
}
