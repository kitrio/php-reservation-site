<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class QnaReply extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('QnaReplyModel', 'qnaReply', true);
        $this->load->library('session');
    }

    public function replies_get()
    {
        $idx = (int)$this->get('idx');
        $info = $this->qnaReply->getReplyByNum($idx);
        if ($info === null) {
            return $this->response($info, 404);
        }
        return $this->response($info, 200);
    }

    public function reply_post()
    {
        $data = [
            'memberid' => $this->session->memberid,
            'title' => $this->post('title'),
            'content' => $this->post('content')
        ];
        $info = $this->qnaReply->insertReply($data);
        if ($info === null) {
            return $this->response($info, 404);
        }
        return $this->response(true, 200);
    }

    public function reply_put()
    {
        $data = [
            'memberid' => $this->session->memberid,
            'title' => $this->post('title'),
            'content' => $this->post('content')
        ];
        $info = $this->qnaReply->updateReply($data);
        if ($info === null) {
            return $this->response($info, 404);
        }
        return $this->response(true, 200);
    }

    public function reply_delete()
    {
        $data = [
            'memberid' => $this->session->memberid,
            'idx' => $this->post('idx')
        ];
        $info = $this->qnaReply->deleteReply($data);
        if ($info === null) {
            return $this->response($info, 404);
        }
        return $this->response(true, 200);
    }
}
