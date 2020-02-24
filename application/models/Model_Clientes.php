<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Clientes extends CI_Model
{
      /* tabla a utilizar    */
    protected $clientes_table = 'tbclientes';

    function __construct()
	{
        $this->load->database();
         
    }
    /**
     * Cliente get all
     * obtener todos los clientes
     * ----------------------------------
     */
    public function getAll(){
            $lista=$this->db->select('*')->get($this->clientes_table);
            
            // retorno datos en un array
            return $lista->result_array();
    }
    /**
     * Cliente get by IDCliente
     * obtener todos los clientes
     * ----------------------------------
     */
    public function getCliente($_IDCliente)
    {
        $lista = $this->db->select('*')->where("IDCliente='$_IDCliente'")->get($this->clientes_table);

        // retorno datos en un array
        return $lista->row_array();
    }
    /**
     * Cliente add
     * ----------------------------------
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
     */
 public function save($_Nombre,$_Apellido_Pat, $_Apellido_Mat, $_RFC, $_Calle, $_No_Interior, $_No_Exterior='', $_Municipio, $_Estado, $_Tel, $_Correo,$_CP){
     // inciamos el array con los parametros para poder guardarlos en la base de datos 
     $datos=array(
        "Nombre"=>$_Nombre,
        "Apellido_Pat"=> $_Apellido_Pat,
        "Apellido_Mat"=> $_Apellido_Mat,
        "RFC"=>$_RFC,
        "Calle"=>$_Calle,
        "No_Interior"=>$_No_Interior,
        "No_Exterior" => $_No_Exterior,
        "Municipio" => $_Municipio,
        "Estado" => $_Estado,
        "Correo"=>$_Correo,
        "Tel"=>$_Tel ,
        "CP"=>$_CP
     );
     return $this->db->insert($this->clientes_table,$datos);

 }

 /**
     * Cliente update
     * ----------------------------------
     * @param: IDCliente
     * @param: Nombre
     * @param: Apellido Paterno
     * @param: Apellido Materno
     * @param: RFC
     * @param: calle
     * @param: No Esterior
     * @param: No Interior
     * @param: Municipio
     * @param: EEstado
     * @param: Tel
     * @param: Correo
     * @param: NombreComercial
     */
 public function update($_IDCliente,$_Nombre, $_Apellido_Pat, $_Apellido_Mat, $_RFC, $_Calle, $_No_Interior, $_No_Exterior, $_Municipio, $_Estado, $_Tel, $_Correo,$_CP){
        // inciamos el array con los parametros para poder guardarlos en la base de datos 
        $datos = array(
            "Nombre" => $_Nombre,
            "Apellido_Pat" => $_Apellido_Pat,
            "Apellido_Mat" => $_Apellido_Mat,
            "RFC" => $_RFC,
            "Calle" => $_Calle,
            "No_Interior" => $_No_Interior,
            "No_Exterior" => $_No_Exterior,
            "Municipio" => $_Municipio,
            "Estado" => $_Estado,
            "Correo" => $_Correo,
            "Tel" => $_Tel,
            "CP" => $_CP
        );
        return $this->db->where("IDCliente='$_IDCliente'")->update($this->clientes_table, $datos);
 }
 /**
     * Cliente Delete
     * ----------------------------------
     * @param:IDCliente
     */
 public function delete($_IDCliente){
        return $this->db->where("IDCliente='$_IDCliente'")->delete($this->clientes_table);
 }
 /**
     * Cliente Update Status
     * ----------------------------------
     * @param:IDCliente
     * @param:Status
     */
 public function update_status($_IDCliente,$_Status){
     // cambio el status que me mando para hacer lo contrario
     ($_Status==='1')?$_Status='0':$_Status='1';

        return $this->db->where("IDCliente='$_IDCliente'")->delete($this->clientes_table,array("Status"=>$_Status));
     
 }
    /**
     * Cliente seach 
     * ----------------------------------
     * @param:palabra
     */
    public function search($_Palabra)
    {
        //primero por nombre
        $_ResultadosN = $this->db->query("SELECT * FROM $this->clientes_table WHERE Nombre LIKE '%$_Palabra%'");
        $_ResultadosN = $_ResultadosN->result_array();

        return $_ResultadosN;
    }

}