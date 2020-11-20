<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;


class Qna extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('QnaContentModel', 'qnaModel', true);
        $this->load->library('session');
    }

    public function contents_get()
    {
        $offset = (int)$this->get('offset');
        $info = $this->qnaModel->getContents($offset);
        if($info === null){
            return $this->response($info, 404);    
        }
        return $this->response($info, 200);
    }

    public function content_get()
    {
        $idx = (int)$this->get('idx');
        $info = $this->qnaModel->getContentByNum($idx);
        if($info === null){
            return $this->response($info, 404);    
        }
        return $this->response($info, 200);
    }

    public function content_post()
    {
        $data = [
            'memberid' => $this->session->memberid,
            'title' => $this->post('title'),
            'content' => $this->post('content')
        ];
        $info = $this->qnaModel->insertContent($data);
        if($info === null){
            return $this->response($info, 404);    
        }
        return $this->response(true, 200);
    }

    public function content_put()
    {
        $data = [
            'idx' => $this->put('idx'),
            'memberid' => $this->session->memberid,
            'title' => $this->put('title'),
            'content' => $this->put('content')
        ];

        $info = $this->qnaModel->updateContent($data);
        if($info === null){
            return $this->response($info, 404);    
        }
        return $this->response(true, 200);
    }

    public function content_delete()
    {
        $data = [
            'memberid' => $this->session->memberid,
            'idx' => $this->delete('idx')
        ];
        $info = $this->qnaModel->deleteContent($data);
        if($info === null){
            return $this->response($info, 404);    
        }
        return $this->response(true, 200);
    }
}
