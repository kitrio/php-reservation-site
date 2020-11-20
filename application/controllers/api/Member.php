<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Member extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('MemberModel', 'member', TRUE);
        $this->load->library('reservationservice');
    }

    public function signup_post()
    {
        $data = [
            'memberid' => $this->post('memberid'),
            'passwd' => $this->post('passwd'),
            'name' => $this->post('name'),
            'phoneNumber' => $this->post('phoneNumber')
        ];
        
        if ($this->member->createMember($data) === 'duplication') {
            return $this->response('id 가 중복되었습니다.', 409);
        } else {
            return $this->response('success', 200);
        }
    }

    public function login_post()
    {
        $data = [
            'memberid' => $this->post('memberid'),
            'passwd' => $this->post('passwd'),
        ];
        
        if($this->member->loginMember($data)) {
            return $this->response('success',200);
        } else {
            return $this->response('id또는 비밀번호가 틀렸습니다.',405);
        }
        
    }

    public function logout_post()
    {
        $this->load->library('session');
        $this->session->sess_destroy();

        return $this->response('success',200);
    }
}