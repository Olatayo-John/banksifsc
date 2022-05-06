<?php

class Bankmdl extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function allbanks()
    {
        $query = $this->db->get('bank_names');
        return $query;
    }

    public function searchbank($searchval)
    {
        $this->db->like('name', $searchval);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('bank_names');
        return $query->result();
    }

    public function banksreload()
    {
        $query = $this->db->get('bank_names');
        return $query->result();
    }

    public function BankBranches($bankName)
    {
        $this->db->select('adr1');
        $this->db->where('name', $bankName);
        $this->db->order_by('adr1', 'asc');
        $query = $this->db->get('data');
        return $query;
    }

    public function BranchesState($bankName, $branchName)
    {
        $this->db->select('adr4');
        $this->db->where(array('name' => $bankName, 'adr1' => $branchName));
        $this->db->order_by('adr4', 'asc');
        $query = $this->db->get('data');
        return $query;
    }

    public function StateCity($bankName, $branchName, $stateName)
    {
        $this->db->select('adr3');
        $this->db->where(array('name' => $bankName, 'adr1' => $branchName, 'adr4' => $stateName));
        $this->db->order_by('adr3', 'asc');
        $query = $this->db->get('data');
        return $query;
    }

    public function bankfilterinfo_info($bank, $branch,$state,$city)
    {
        $this->db->where(array('name' => $bank, 'adr1' => $branch, 'adr3' => $city, 'adr4' => $state));
        $query = $this->db->get('data')->row();
        if(!$query){
            return false;
        }else{
        return $query;
        }
    }

    public function bank_branch($id)
    {
        $this->db->where('id', $id);
        $bnkname = $this->db->get('bank_names')->row();

        $_SESSION['bnkname'] = $bnkname->name;

        $this->db->where('name', $bnkname->name);
        $this->db->order_by('adr1', 'asc');
        $query = $this->db->get('data');
        return $query;
    }

    public function bank_branch_info($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('data')->row();
        return $query;
    }
}
