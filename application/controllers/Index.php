<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Activity','',TRUE);
    }
    
    public function index()
    {
        $this->load->view('index');
    }
    
    public function getActivity()
    {
        $activity = $this->Activity->select();
        
        $data = array(
            'data' => $activity
        );
        
        echo json_encode($data);
    }
    
    public function getActivityByStatus()
    {
        $id = $this->uri->segment(3);
        if(!is_null($id))
        {
            $activity = $this->Activity->select(NULL, array('status' => $id));
        } else {
            $activity = $this->Activity->select();
        }
        
        $data = array(
            'data' => $activity
        );
        
        echo json_encode($data);
    }
    
    public function getActivityBySituation()
    {
        $id = $this->uri->segment(3);
        if(!is_null($id))
        {
            $activity = $this->Activity->select(NULL, array('situation' => $id));
        } else {
            $activity = $this->Activity->select();
        }
        
        $data = array(
            'data' => $activity
        );
        
        echo json_encode($data);
    }
    
    public function getActivityById()
    {
        $post = $this->input->post();
        $select = array(
            'id' => $post['id']
        );
        
        $activity = $this->Activity->select(NULL, $select);
        $data = array(
            'data' => $activity[0]
        );
        
        echo json_encode($data);
    }
    
    public function addActivity()
    {
        $post = $this->input->post();
        
        $data = array(
            'name' => $post['name'],
            'description' => $post['description'],
            'start_date' => $post['s_date'],
            'end_date' => ($post['e_date'] == '') ? NULL : $post['e_date'],
            'status' => $post['status'],
            'situation' => $post['situation']
        );
        
        $this->Activity->insert($data);
        
        echo json_encode(array('hasError' => false));
    }
    
    public function editActivity()
    {
        $post = $this->input->post();
        
        $data = array(
            'name' => $post['name'],
            'description' => $post['description'],
            'start_date' => $post['s_date'],
            'end_date' => ($post['e_date'] == '') ? NULL : $post['e_date'],
            'status' => $post['status'],
            'situation' => $post['situation']
        );
        
        $filter = array(
            'id' => $post['id'],
        );
        
        $this->Activity->update($data, $filter);
        
        echo json_encode(array('hasError' => false));
    }
}