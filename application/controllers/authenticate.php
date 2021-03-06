<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authenticate extends CI_Controller {

    /**
     * Post Request data
     * @var array $data
     */
    var $data = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        $this->session_uid = $this->usermodel->session_uid;
        $this->session_logged_in = $this->usermodel->session_logged_in;
        $this->data = $this->input->post("data");

        // redirect users if there is no session		
        if ($this->session_uid) {
            redirect(base_url());
        }
    }

    /**
     * Method to login user
     * @param string $option 
     */
    public function user($option = null) {

        $data = $this->input->post("data");
        $this->usermodel->email = $this->db->escape_str($data["user"]["email"]);
        $this->usermodel->password = $this->db->escape_str(sha1($data["user"]["password"]));

        if ($this->usermodel->authenticate_user()):

            $newdata = array(
                'uid' => $this->usermodel->id,
                'login_time' => time(),
                'logged_in' => true
            );

            $this->session->set_userdata($newdata);

            if ($option == "redirectback"):
                redirect($_SERVER['HTTP_REFERER']);
            else:
                redirect("/dashboard");
            endif;

        else:
            redirect("/pages/login/fail");
        endif;
    }

    /**
     * Registers a new user
     */
    public function register_user() {


        if ($this->data) {

            $email = $this->data['user']['email'];
            $first_name = $this->data['user']['first_name'];
            $last_name = $this->data['user']['last_name'];
            $password = sha1($this->data['user']['password']);
            $cpassword = sha1($this->data['user']['cpassword']);
            $role = $this->data['user']['role'];
            $modified = time();
            $modified_by = "SYS";

            $user = $this->usermodel;
            $user->email = $email;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->password = $password;
            $user->role_id = $role;
            $user->modified = $modified;
            $user->modified_by = $modified_by;

            if (!$user->check_user() &&
                    !empty($email) &&
                    !empty($first_name) &&
                    !empty($last_name) &&
                    is_numeric($role) &&
                    !empty($password) &&
                    !empty($cpassword) &&
                    $password == $cpassword) {

                print_r($this->data);

                $user->save();

                $newdata = array(
                    'uid' => $this->db->insert_id(),
                    'login_time' => time(),
                    'logged_in' => true
                );

                // set session data
                $this->session->set_userdata($newdata);
                
                
                // redirect back to main page to get to the dashboard
                redirect(base_url() . "index.php?/dashboard");
            } else {
                echo "<h2>Sorry something went wrong! :(</h2>";
            }
        }
    }

}
