<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_User extends CI_Model
{
     /* tabla a utilizar    */
    protected $user_table = 'tbusuarios';
     /* Variable cadena para seguirdad de password     */
    protected $cadena_add = 'HKJGKBGhjjfsf*-/jd_jdsf44';
    

    /**
     * User Login
     * ----------------------------------
     * @param: username or email address
     * @param: password
     */
    public function user_login($username, $password)
    {
        $this->db->where('Usuario', $username);
        $q = $this->db->get($this->user_table);

        if( $q->num_rows() ) 
        {
            $user_pass = $q->row('Clave');
            if(md5($password.$this->cadena_add)."-".$this->cadena_add === $user_pass) {
                return $q->row();
            }
            return FALSE;
        }else{
            return FALSE;
        }
    }
}