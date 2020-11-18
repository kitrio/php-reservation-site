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
        return $this->db->get('qna', $limit, $offset)->result_array();
    }

    public function getContentByNum(int $idx)
    {
        $this->db->where('idx',$idx);
        return $this->db->get('qna')->row();
    }

    public function insertContent($data)
    {
        $this->db->set('writer',$data['memberid']);
        $this->db->set('title',$data['title']);
        $this->db->set('content',$data['content']);
        $this->db->set('date',date("Y-m-d H:i:s"));

        $this->db->insert('qna');

        if($this->db->error())
        {
            return false;
        } else {
            return true;
        }
    }
}