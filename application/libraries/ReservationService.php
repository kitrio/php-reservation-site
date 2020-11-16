<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReservationService
{
    private $CI = null;

    function __construct()
    {
        $this->CI = get_instance();
        $this->CI->load->model("RoomModel","roomModel",true); //DB 연결
        $this->CI->load->model("ReservationModel","reservationModel",true);
    }

    function reservation(string $memberId, int $roomNumber, $checkinDay, $checkoutDay)
    {
        $roomInfo = $this->CI->roomModel->getRoominfoByNum($roomNumber);

        $checkinDay = date_create($checkinDay);
        $checkoutDay = date_create($checkoutDay);
        $price = $roomInfo[0]['price'];
        $day = date_diff($checkinDay, $checkoutDay)->format('%R%a');
        $price = ((int)$price * (int)$day);

        $data = [
            'memberId' => $memberId,
            'fk_room_number' => $roomNumber,
            'price' => $price,
            'check_in' => $checkinDay,
            'check_out' => $checkoutDay,
            'resesrvation_date' => date("Y-m-d H:i:s")
        ];

        $this->reservation->insertReservation($data);
    }

    public function checkReservation($checkinDay, $checkoutDay)
    {
        $rooms =  $this->CI->roomModel->getAllRoominfo();
        $reservation =  $this->CI->reservationModel->getReselvationInfo($checkinDay, $checkoutDay);

        foreach ($rooms as $key => $roominfo) 
        {
            foreach ($reservation as $reservationKey => $reservationinfo)
            {
                if($roominfo['room_number'] === $reservationinfo['fk_room_number'])
                {
                    unset($rooms[$key]); //remove
                }
            }
        }

        return $rooms;
    }


}
