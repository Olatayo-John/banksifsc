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

    public function BankBranches()
    {
        $this->load->model('Bankmdl');

        $bankName = htmlentities($_POST['bank']);
        $branchs = $this->Bankmdl->BankBranches($bankName);
        if ($branchs->num_rows() <= '0') {
            $data['status'] = "failure";
        } else {
            $data['status'] = "success";
            $data['branchs'] = $branchs->result();
        }

        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }

    public function BranchesState()
    {
        $this->load->model('Bankmdl');

        $bankName = htmlentities($_POST['bank']);
        $branchName = htmlentities($_POST['branch']);
        $states = $this->Bankmdl->BranchesState($bankName, $branchName);
        if ($states->num_rows() <= '0') {
            $data['status'] = "failure";
        } else {
            $data['status'] = "success";
            $data['states'] = $states->result();
        }

        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }

    public function StateCity()
    {
        $this->load->model('Bankmdl');

        $bankName = htmlentities($_POST['bank']);
        $branchName = htmlentities($_POST['branch']);
        $stateName = htmlentities($_POST['state']);
        $cities = $this->Bankmdl->StateCity($bankName, $branchName, $stateName);
        if ($cities->num_rows() <= '0') {
            $data['status'] = "failure";
        } else {
            $data['status'] = "success";
            $data['cities'] = $cities->result();
        }

        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }

    public function ifsc()
    {
        $bank = htmlentities($_GET['bank']);
        $branch = htmlentities($_GET['branch']);
        $state = htmlentities($_GET['state']);
        $city = htmlentities($_GET['city']);

        if (!empty($bank) && !empty($branch) && !empty($state) && !empty($city)) {
            $this->load->model('Bankmdl');

            $branchinfo = $this->Bankmdl->bankfilterinfo_info($bank, $branch, $state, $city);

            if ($branchinfo !== false) {
                $data['branchinfo'] = $branchinfo;
                $data['title'] = $bank . " " . $data['branchinfo']->adr1 . " IFSC Code";

                $this->load->view('template/header', $data);
                $this->load->view('bank/branch', $data);
                $this->load->view('template/footer');
            }else{
                redirect('home');
            }
        } else {
            redirect('home');
        }
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
