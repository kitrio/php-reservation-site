<?php

class RoomModel extends CI_MODEL
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllRoominfo(): array
    {
        return $this->db->get('room')->result_array();
    }

    public function getRoominfoByNum(int $room_number): array
    {
        $this->db->where("room_number = $room_number");
        return $this->db->get('room')->result_array();
    }

}
