<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class user_model extends Model
{
    public function read()
    {
        return $this->db->table('jlmc_users')->get_all();
    }

    public function create($lastname, $firstname, $email, $gender, $address)
    {
        $data = array(
            'jlmc_last_name' => $lastname,
            'jlmc_first_name' => $firstname,
            'jlmc_email' => $email,
            'jlmc_gender' => $gender,
            'jlmc_address' => $address,
        );
        return $this->db->table('jlmc_users')->insert($data);
    }



    public function get1($id)
    {
        return $this->db->table('jlmc_users')->where('id', $id)->get();
    }

    public function update($lastname, $firstname, $email, $gender, $address, $id)
    {
        $data = array(
            'jlmc_last_name' => $lastname,
            'jlmc_first_name' => $firstname,
            'jlmc_email' => $email,
            'jlmc_gender' => $gender,
            'jlmc_address' => $address
        );
        return $this->db->table('jlmc_users')->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->db->table('jlmc_users')->where('id', $id)->delete();
    }
}
