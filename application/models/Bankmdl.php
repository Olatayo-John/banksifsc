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
