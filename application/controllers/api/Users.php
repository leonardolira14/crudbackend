<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Users extends REST_Controller
{
    public function __construct() {
        header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
        parent::__construct();
        $this->load->library('Authorization_Token');
        $this->load->model('Model_User');
    }


    /**
     * User Login API
     * --------------------
     * @param: username
     * @param: password
     * --------------------------
     * @method : POST
     * @link: api/user/login
     */
    public function login_post()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
        $_POST = $this->security->xss_clean($_POST);
        # Form Validation
        $this->form_validation->set_rules('username', 'Usuario', 'trim|required');
        $this->form_validation->set_rules('password', 'Contraseña', 'trim|required|max_length[100]');

        $array = array(
            "required" => 'El campo %s es obligatorio',
            "valid_email" => 'El campo %s no es valido',
            'is_unique' => 'El contenido del campo %s ya esta registrado'
        );
        $this->form_validation->set_message($array);
        if ($this->form_validation->run() == FALSE) {
            // validacion de formularios
            $message = array(
                'status' => false,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            // Load Login Function
            $output = $this->Model_User->user_login($this->input->post('username'), $this->input->post('password'));

            if (!empty($output) and $output != FALSE) {

                // Generate Token
                $token_data['ID_Usuario'] = $output->IDUsuario;
                $token_data['Nombre'] = $output->Nombre;
                $token_data['Usuario'] = $output->Usuario;
                $token_data['Apellido_Pat'] = $output->Apellido_Pat;
                $token_data['Apellido_Mat'] = $output->Apellido_Mat;
                $token_data['time'] = time();

                $user_token = $this->authorization_token->generateToken($token_data);

                $data_user['token'] = $user_token;
                $return_data = $data_user;
                // Login Success
                $message = [
                    'status' => true,
                    'data' => $return_data,
                    'message' => "Acceso consedido"
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                // Login Error
                $message = [
                    'status' => FALSE,
                    'message' => "Usuario y/o Contraseña no validos"
                ];
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
}