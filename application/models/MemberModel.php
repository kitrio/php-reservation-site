<?php


class MemberModel extends CI_MODEL
{
    public function __construct()
    {
        parent::__construct();
    }

    public function CreateMember($data)
    {
        $passwd = $data['passwd'];
        $passwd = password_hash($passwd,PASSWORD_BCRYPT);

        $this->db->set('id', $data['memberid']);
        $this->db->set('passwd', $passwd);
        $this->db->set('name', $data['name']);
        $this->db->set('phone_number', $data['phoneNumber']);   
        
        $DUPLICATION_ERROR = 1062;

        $this->db->insert('member');
        //var_dump($this->db->error());
        if($this->db->error()['code'] === $DUPLICATION_ERROR)
        {
            return 'duplication';
        } else {
            return true;
        }
        
    }
}