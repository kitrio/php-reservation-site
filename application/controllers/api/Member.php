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
        
        if ($this->member->CreateMember($data) === 'duplication') {
            return $this->response('id 가 중복되었습니다.', 409);
        } else {
            return $this->response('success', 200);
        }
    }
}