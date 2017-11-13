<?php
/**
 * Classe Index, contendo todas as funções necessárias para execução do programa
 *
 * @author  Paulo Jeffrerson <dark_4862@hotmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller{
    
    /**
     * Carregando classe Activity
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Activity','',TRUE);
    }
    
    /**
     * IndexAction
     * 
     * Carrega a view
     */
    public function index()
    {
        $this->load->view('index');
    }
    
    /**
     * getActivity
     * 
     * Efetua a busca de todas as atividades para serem mostradas pela datatable
     */
    public function getActivity()
    {
        $activity = $this->Activity->select();
        
        $data = array(
            'data' => $activity
        );
        
        echo json_encode($data);
    }
    
    /**
     * getActivityByFilter
     * 
     * Efetua a busca das atividades filtradas por status e por situação
     */
    public function getActivityByFilter()
    {
        $status = ($this->uri->segment(3) != 'null') ? $this->uri->segment(3) : NULL;
        $situation = ($this->uri->segment(4) != 'null') ? $this->uri->segment(4) : NULL;
        
        if(!is_null($status) && !is_null($situation))
        {
            $activity = $this->Activity->select(NULL, array('status' => $status, 'situation' => $situation));
        } else if(is_null($status) && !is_null($situation))
        {
            $activity = $this->Activity->select(NULL, array('situation' => $situation));
        } else if(!is_null($status) && is_null($situation))
        {
            $activity = $this->Activity->select(NULL, array('status' => $status));
        } else {
            $activity = $this->Activity->select();
        }
        
        $data = array(
            'data' => $activity
        );
        
        echo json_encode($data);
    }
    
    /**
     * getActivityById
     * 
     * Efetua uma busca no banco de dados pela atividade cujo id é enviado via AJAX com método POST
     */
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
    
    /**
     * addActivity
     * 
     * Adicona uma nova ativadade no banco de dados
     * Recebe dados enviados via AJAX com método POST vindos do formulário
     */
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
    
    /**
     * editActivity
     * 
     * Edita uma atividade no banco de dados
     * Recebe dados enviados via AJAX com método POST vindos do formulário
     */
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