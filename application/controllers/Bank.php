<?php

class Bank extends CI_Controller
{
    public function index()
    {
        $this->load->model('Bankmdl');
        $data['banks'] = $this->Bankmdl->allbanks();
        $data['title'] = "Banks IFSC codes";

        $this->load->view('template/header', $data);
        $this->load->view('bank/index', $data);
        $this->load->view('template/footer');
    }

    public function searchbank()
    {
        $this->load->model('Bankmdl');
        $data['banks'] = $this->Bankmdl->searchbank($_POST['searchval']);
        $data['token'] = $this->security->get_csrf_hash();

        echo json_encode($data);
    }

    public function banksreload()
    {
        $this->load->model('Bankmdl');
        $data['banks'] = $this->Bankmdl->banksreload();
        $data['token'] = $this->security->get_csrf_hash();

        echo json_encode($data);
    }

    public function branches($id)
    {
        $this->load->model('Bankmdl');
        $data['branches'] = $this->Bankmdl->bank_branch($id);
        $data['title'] = $_SESSION['bnkname'];

        $this->load->view('template/header', $data);
        $this->load->view('bank/branches', $data);
        $this->load->view('template/footer');
    }

    public function info($id)
    {
        $this->load->model('Bankmdl');
        $data['branchinfo'] = $this->Bankmdl->bank_branch_info($id);
        $data['title'] = $_SESSION['bnkname'] . " " . $data['branchinfo']->adr1 . " IFSC Code";

        $this->load->view('template/header', $data);
        $this->load->view('bank/branch', $data);
        $this->load->view('template/footer');
    }
}
