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

    public function checkReservation($checkinDay, $checkoutDay) : array
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

        return (array)$rooms;
    }


}
