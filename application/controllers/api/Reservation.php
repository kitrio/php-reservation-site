<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Reservation extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ReservationService');
        $this->load->library('session');
    }

    //예약확인
    public function reservation_get()//check_post()
    {
        $data = [
            'people' => (int)$this->post('people'),
            'checkIn' => $this->post('checkIn'),
            'checkOut' => $this->post('checkOut')
        ];

        $info = $this->reservationservice->checkReservation($data['checkIn'], $data['checkOut']);
        if ($info === null) {
            return $this->response("msg:fail", 404);
        }
        return $this->response($info, 200);
    }
    
    //예약
    public function reservation_post()
    {
        $data = [
            'room_number' => (int)$this->post('room_number'),
            'memberid' => $this->session->memberid,
            'checkin' => $this->post('checkin'),
            'checkout' => $this->post('checkout')
        ];
        if ($data['memberid'] === null) {
            return $this->response('msg: not login', 401);
        }

        $info = $this->reservationservice->reservation($data['memberid'], $data['room_number'], $data['checkin'], $data['checkout']);
        if ($info) {
            return $this->response("msg:fail", 404);
        }

        return $this->response($info, 200);
    }
}
