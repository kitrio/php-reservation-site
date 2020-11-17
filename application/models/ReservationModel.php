<?php

class ReservationModel extends CI_MODEL
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getReselvationInfo($checkinDay, $checkoutDay): array
    {
        $this->db->where("check_in BETWEEN '$checkinDay' AND '$checkoutDay' ");

        return $this->db->get("reservation")->result_array();
    }

    public function insertReservation(array $data): bool
    {
        $this->db->insert('reservation',$data);

        if($this->db->error())
        {
            return false;
        } else {
            return true;
        }
    }

}
