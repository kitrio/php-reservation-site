<?php

class MemberModel extends CI_MODEL
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function createMember($data)
    {
        $passwd = $data['passwd'];
        $passwd = password_hash($passwd, PASSWORD_BCRYPT);

        $this->db->set('id', $data['memberid']);
        $this->db->set('passwd', $passwd);
        $this->db->set('name', $data['name']);
        $this->db->set('phone_number', $data['phoneNumber']);

        $DUPLICATION_ERROR = 1062;

        $this->db->insert('member');
        //var_dump($this->db->error());
        if ($this->db->error()['code'] === $DUPLICATION_ERROR) {
            return 'duplication';
        } else {
            return true;
        }
    }

    private function passwordMatch(string $memberid, string $passwd): bool
    {
        $this->db
            ->select('passwd')
            ->where('id', $memberid);

        $selectPasswd = (array)$this->db->get('member')->row(); //row() 결과값 한줄

        return password_verify($passwd, $selectPasswd['passwd']);
    }

    public function loginMember($data)
    {
        if ($this->passwordMatch($data['memberid'], $data['passwd'])) {
            $id = $data['memberid'];
            $this->db->select('name')
                     ->where('id', $id);
            $name = $this->db->get('member')->row();

            $sessionData = ['memberid' => $id, 'name'=> $name];
            $this->session->set_userdata($sessionData);
            return true;
        } else {
            return false;
        }
    }
}
