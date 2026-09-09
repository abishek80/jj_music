<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Loginmodel extends CI_Model
{
    // Login Checking
    public function checkLogin($username, $password)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where("(mobile_number = '$username' OR login_code = '$username')");
        $this->db->where('delete_status', 0);
        $this->db->where('status', 'active');
        $this->db->where('password', md5($password));
        $query = $this->db->get();
        $res = $query->result();
        $rows = $query->num_rows();
        $login_id = '';

        $status = '';
        if (!empty($res)) {
            foreach ($res as $row) {
                $status = $row->status;

                if ($status == 'active') {
                    $userData = array(
                        'userid' => $row->id,
                        'logincode' => $row->login_code,
                        'username' => $row->user_name,
                        'mobile' => $row->mobile_number,
                        'email' => $row->email,
                        'loggedin' => TRUE,
                        'is_admin' => $row->is_admin
                    );
                    $this->session->set_userdata($userData);
                }

                $login_id = $row->id;
            }
        }
        $resArr["rowCount"] = $rows;
        $resArr["status"] = $status;
        $resArr["login_id"] = $login_id;
        return $resArr;
    }
}
?>