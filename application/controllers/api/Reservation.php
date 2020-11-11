<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Reservation extends RestController {

    function __construct()
    {
        parent::__construct(); //super
        $this->load->library('Reservationservice');
    }

    //예약확인
    public function check_post()
    {
        $data = [
            'people' => (int)$this->post('people'),
            'checkIn' => $this->post('checkIn'),
            'checkOut' => $this->post('checkOut')
        ];

        $info = $this->reservationservice->checkReservation($data['checkIn'], $data['checkOut']);
        return $this->response($info, 200);
    }

}