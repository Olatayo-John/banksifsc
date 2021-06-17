<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
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

    public function contact()
    {
        $data['title'] = "contact";

        $this->load->view('template/header', $data);
        $this->load->view('pages/contact-us');
        $this->load->view('template/footer');
    }

    public function about()
    {
        $data['title'] = "about us";

        $this->load->view('template/header', $data);
        $this->load->view('pages/about-us');
        $this->load->view('template/footer');
    }

    public function privacy()
    {
        $data['title'] = "privacy policy";

        $this->load->view('template/header', $data);
        $this->load->view('pages/privacy-policy');
        $this->load->view('template/footer');
    }
}
