<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');

        if (($this->session->userdata('userid') != null) || ($this->session->userdata('userid') != "")) {
            redirect(base_url() . 'login');
        }
    }

    public function index()
    {
        $this->load->view('settings/login');
    }

    public function checkLogin()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($username != "" && $password != "") {
            $result = $this->loginmodel->checkLogin($username, $password);
            $rowCount = $result["rowCount"];
            $status = $result["status"];
            $login_id = $result["login_id"];

            if ($rowCount == 1 && $status == 'active') { // Check if login_id is not null
                $data["isError"] = FALSE;
                $data["message"] = "You Are Logged In Successfully.";
            } else {
                if ($status == 'inactive') {
                    $data["isError"] = TRUE;
                    $data["message"] = "Your Account Has Been Suspended By Admin. Please Contact Admin.";
                } else {
                    $data["isError"] = TRUE;
                    $data["message"] = "Login Code, Mobile No Or Password Is Not Matched.";
                }
            }
        } else {
            $data["isError"] = TRUE;
            $data["message"] = "Please Fill All Details.";
        }

        echo json_encode($data);
    }
}
?>