<?php

class RoomModel extends CI_MODEL
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllRoominfo(): array
    {
        $query = $this->db->get('room')->result_array();
        $files = $this->db->get('file')->result_array();
 
        foreach ($query as $key => $room) {
            foreach ($files as $file => $image) {
                if ($room['room_number'] == $image['room_number']) {
                    $query[$key]["image"][] = $files[$file];
                }
            }
        }

        return $query;
    }

    public function getRoominfoByNum(int $room_number): array
    {
        $this->db->where("room_number = $room_number");
        
        return $this->db->get('room')->result_array();
    }
}
