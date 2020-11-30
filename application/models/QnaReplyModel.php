<?php

class QnaReplyModel extends CI_MODEL
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getReplyByNum(int $idx)
    {
        $this->db->where('fk_qna_idx', $idx);
        $query = $this->db->get('reply')->result_array();

        if ($this->db->error()['code'] === 0) {//success
            return $query;
        } else {
            log_message("error", $this->db->error()['code']. $this->db->error()['message']);
            return $query = null;
        }
    }

    public function insertReply($data)
    {
        $this->db->set('fk_qna_idx', $data['idx']);
        $this->db->set('fk_writer', $data['memberid']);
        $this->db->set('content', $data['content']);
        $this->db->set('date', date("Y-m-d H:i:s"));

        $this->db->insert('reply');

        if ($this->db->error()['code'] === 0) {// success
            return true;
        } else {
            log_message("error", $this->db->error()['code']. $this->db->error()['message']);
            return false;
        }
    }

    public function updateReply($data)
    {
        $this->db->where('fk_writer', $data['memberid']);
        $this->db->where('fk_qna_idx', $data['idx']);
        $this->db->set('content', $data['content']);

        $this->db->update('reply');

        if ($this->db->error()['code'] === 0) {// success
            return true;
        } else {
            log_message("error", $this->db->error()['code']. $this->db->error()['message']);
            return false;
        }
    }

    public function deleteReply($data)
    {
        $this->db->where('fk_writer', $data['memberid']);
        $this->db->where('fk_qna_idx', $data['idx']);

        $this->db->delete('reply');

        if ($this->db->error()['code'] === 0) {// success
            return true;
        } else {
            log_message("error", $this->db->error()['code']. $this->db->error()['message']);
            return false;
        }
    }
}
