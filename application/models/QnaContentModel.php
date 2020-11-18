<?php

class QnaContentModel extends CI_MODEL
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getContents(int $offset)
    {
        $limit = 10;
        $query = $this->db->get('qna', $limit, $offset)->result_array();
        if($this->db->error()['code'] === 0)//success
        {
            return $query;
        } else {
            log_message("error", $this->db->error()['code']. $this->db->error()['message']);
            return $query = null;
        }
    }

    public function getContentByNum(int $idx)
    {
        $this->db->where('idx',$idx);
        $query = $this->db->get('qna')->row();
        if($this->db->error()['code'] === 0)//success
        {
            return $query;
        } else {
            log_message("error", $this->db->error()['code']. $this->db->error()['message']);
            return $query = null;
        }
    }

    public function insertContent($data)
    {
        $this->db->set('writer',$data['memberid']);
        $this->db->set('title',$data['title']);
        $this->db->set('content',$data['content']);
        $this->db->set('date',date("Y-m-d H:i:s"));

        $this->db->insert('qna');

        if($this->db->error()['code'] === 0)// success
        {
            return true;
        } else {
            log_message("error", $this->db->error()['code']. $this->db->error()['message']);
            return false;
        }
    }
}