<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Clientes extends REST_Controller
{
    public function __construct() {
        header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
        parent::__construct();
        $this->load->library('Authorization_Token');
        $this->load->model("Model_Clientes");
        
    }

    /**
     *  add
     * --------------------------
     * @param: Nombre
     * @param: Apellido Paterno
     * @param: Apellido Materno
     * @param: RFC
     * @param: calle
     * @param: No Esterior
     * @param: No Interior
     * @param: Municipio
     * @param: Estado
     * @param: Tel
     * @param: Correo
     *
     * --------------------------
     * @method : POST
     * @link : api/clientes/save
     */
     public function add_post()
    {
         if ($this->check_session()) {
            
            $_POST = json_decode(file_get_contents("php://input"), true);
            # XSS filtracion (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);
            
            # validacion del formulario con la libreria del framework

            $config = array(
                array(
                    'field' => 'Nombre',
                    'label' => 'Nombre',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'Apellido_Pat',
                    'label' => 'Apellido Paterno',
                    'rules' => 'trim|xss_clean|required'
                ), array(
                    'field' => 'RFC',
                    'label' => 'RFC',
                    'rules' => 'trim|required|xss_clean|'
                ), array(
                    'field' => 'Calle',
                    'label' => 'Calle',
                    'rules' => 'trim|xss_clean|required'
                ), array(
                    'field' => 'No_Exterior',
                    'label' => 'No. Exterior',
                    'rules' => 'trim|xss_clean|required'
                ), array(
                    'field' => 'No_Interior',
                    'label' => 'No Interior',
                    'rules' => 'trim|xss_clean'
                ), array(
                    'field' => 'Municipio',
                    'label' => 'Municipio',
                    'rules' => 'trim|xss_clean|required'
                ), array(
                    'field' => 'Estado',
                    'label' => 'Estado',
                    'rules' => 'trim|xss_clean|required'
                ),array(
                    'field' => 'Tel',
                    'label' => 'Teléfono',
                    'rules' => 'trim|xss_clean|required'
                ), array(
                    'field' => 'Correo',
                    'label' => 'Correo Electronico',
                    'rules' => 'trim|xss_clean|required|is_unique[clientes.Correo]|valid_email'
                )
            );
            $array = array(
                "required" => 'El campo %s es obligatorio',
                "valid_email" => 'El campo %s no es valido',
                'is_unique' => 'El contenido del campo %s ya esta registrado'
            );
            $this->form_validation->set_message($array);
            if (!$this->form_validation->run()) {
                // si no hay errores procedo a guardar los datos
                $respuesta=$this->Model_Clientes->save(
                    $_POST["Nombre"],
                    $_POST["Apellido_Pat"],
                    $_POST["Apellido_Mat"],
                    $_POST["RFC"],
                    $_POST["Calle"],
                    $_POST["No_Interior"],
                    $_POST["No_Exterior"],
                    $_POST["Municipio"],
                    $_POST["Estado"],
                    $_POST["Tel"],
                    $_POST["Correo"],
                    $_POST["CP"]
                );

                if ($respuesta) {
                    // retorno en un array el error
                    $message = array(
                        'status' => true,
                        'data' => $_POST
                    );
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    // retorno en un array el error
                    $message = array(
                        'status' => false,
                        'message' => "Error al alctualizar"
                    );
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            } else {
                // retorno en un array el error
                $message = array(
                    'status' => false,
                    'error' => $this->form_validation->error_array(),
                    'message' => validation_errors()
                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }

    }

    /**
     *  update
     * --------------------------
     * @param: IDCliente
     * @param: Nombre
     * @param: Apellido Paterno
     * @param: Apellido Materno
     * @param: RFC
     * @param: calle
     * @param: No Esterior
     * @param: No Interior
     * @param: Municipio
     * @param: Estado
     * @param: Tel
     * @param: Correo
     *
     * --------------------------
     * @method : POST
     * @link : api/user/login
     */
    public function update_post()
    {
        if ($this->check_session()) {
            $_POST = json_decode(file_get_contents("php://input"), true);
            # XSS filtracion (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);

            # validacion del formulario con la libreria del framework

            $config = array(
                array(
                    'field' => 'Nombre',
                    'label' => 'Nombre',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'Apellido_Pat',
                    'label' => 'Apellido Paterno',
                    'rules' => 'trim|xss_clean|required'
                ), array(
                    'field' => 'RFC',
                    'label' => 'RFC',
                    'rules' => 'trim|required|xss_clean|'
                ), array(
                    'field' => 'Calle',
                    'label' => 'Calle',
                    'rules' => 'trim|xss_clean|required'
                ), array(
                    'field' => 'No_Exterior',
                    'label' => 'No. Exterior',
                    'rules' => 'trim|xss_clean|required'
                ), array(
                    'field' => 'No_Interior',
                    'label' => 'No Interior',
                    'rules' => 'trim|xss_clean'
                ), array(
                    'field' => 'Municipio',
                    'label' => 'Municipio',
                    'rules' => 'trim|xss_clean|required'
                ), array(
                    'field' => 'Estado',
                    'label' => 'Estado',
                    'rules' => 'trim|xss_clean|required'
                ), array(
                    'field' => 'Tel',
                    'label' => 'Teléfono',
                    'rules' => 'trim|xss_clean|required'
                ), array(
                    'field' => 'Correo',
                    'label' => 'Correo Electronico',
                    'rules' => 'trim|xss_clean|required|is_unique[clientes.Correo]|valid_email'
                )
            );
            $array = array(
                "required" => 'El campo %s es obligatorio',
                "valid_email" => 'El campo %s no es valido',
                'is_unique' => 'El contenido del campo %s ya esta registrado'
            );
            $this->form_validation->set_message($array);
            if (!$this->form_validation->run()) {
                // si no hay errores procedo a guardar los datos
                $respuesta=$this->Model_Clientes->update(
                    $_POST["IDCliente"],
                    $_POST["Nombre"],
                    $_POST["Apellido_Pat"],
                    $_POST["Apellido_Mat"],
                    $_POST["RFC"],
                    $_POST["Calle"],
                    $_POST["No_Interior"],
                    $_POST["No_Exterior"],
                    $_POST["Municipio"],
                    $_POST["Estado"],
                    $_POST["Tel"],
                    $_POST["Correo"],
                    $_POST["CP"]
                );
                if($respuesta){
                    // retorno en un array el error
                    $message = array(
                        'status' => true,
                        'data' => $_POST
                    );
                    $this->response($message, REST_Controller::HTTP_OK);
                }else{
                    // retorno en un array el error
                    $message = array(
                        'status' => false,
                        'message' => "Error al alctualizar"
                    );
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
                
            } else {
                // retorno en un array el error
                $message = array(
                    'status' => false,
                    'error' => $this->form_validation->error_array(),
                    'message' => validation_errors()
                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    /**
     *  delete
     * --------------------------
     * @param: usuario
     * @param: contraseña
     *
     * --------------------------
     * @method : get
     * @link : api/user/delete
     */
    public function delete_post()
    {

        if ($this->check_session()) {
            $_POST = json_decode(file_get_contents("php://input"), true);
            # XSS filtracion (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);
            $respuesta = $this->Model_Clientes->delete($_POST["IDCliente"]);
            if ($respuesta) {
                // retorno en un array el error
                $message = array(
                    'status' => true,
                    'data' => $_POST
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                // retorno en un array el error
                $message = array(
                    'status' => false,
                    'message' => "Error al alctualizar"
                );
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    /**
     *  get by ID
     * --------------------------
     * @param: IDCliente
     * 
     *
     * --------------------------
     * @method : GET
     * @link : api/clientes/getbyID
     */
    public function getbyID_post()
    {

        if ($this->check_session()) {
            $_POST = json_decode(file_get_contents("php://input"), true);
            # XSS filtracion (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);
            
            $respuesta=$this->Model_Clientes->getCliente($_POST["IDCliente"]);
            // retorno en un array el error
            $message = array(
                'status' => true,
                'data' => $respuesta
            );
            $this->response($message, REST_Controller::HTTP_OK);
        }
    }

    /**
     *  get all
     * --------------------------
     *
     * --------------------------
     * @method : GET
     * @link : api/clientes/getAll
     */
    public function getAll_get()
    {
        if($this->check_session()){
           
            # XSS filtracion (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);
            $repuesta = $this->Model_Clientes->getAll();
            // retorno en un array el error
            $message = array(
                'status' => true,
                'data' => $repuesta
            );
            $this->response($message, REST_Controller::HTTP_OK);
        }
    }
    /**
     *  revicion de session para acceso
  
     */

    private function check_session(){

        $decodedToken = $this->authorization_token->userData()->ID_Usuario;
        if (!$decodedToken) {
            $message = array(
                'status' => false,
                'data' => "Unauthorised"
            );
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
            return false;
        }
        else{
            return true;
        }
    }
    /**
     *  revicion de session para acceso
  
     */
    public function buscar_post(){
        $_POST = json_decode(file_get_contents("php://input"), true);
        # XSS filtracion (https://www.codeigniter.com/user_guide/libraries/security.html)
        $_POST = $this->security->xss_clean($_POST);
        
        $repuesta = $this->Model_Clientes->search($_POST["Palabra"]);
        // retorno en un array el error
        $message = array(
            'status' => true,
            'data' => $repuesta
        );
        $this->response($message, REST_Controller::HTTP_OK);
    }
}