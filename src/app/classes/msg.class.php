<?php

class Msg extends Functions
{

    // public $msg = [];
    private $use_cookie = true;
    private $msg = [];

    public function __construct()
    {
        if (!$this->use_cookie) session_start();
        $this->load_msg();
    }

    private function load_msg()
    {
        if ($this->use_cookie) {
            if (!isset($_COOKIE['smsg']))
                $this->set_cookie('smsg', '', 31);
            else
                $this->msg = json_decode($_COOKIE['smsg']);
        } else {
            if (!isset($_SESSION['smsg']))
                $_SESSION['smsg'] = [];
            else
                $this->msg = $_SESSION['smsg'];
        }
    }

    private function save_msg()
    {
        if ($this->use_cookie)
            $this->set_cookie('smsg', json_encode($this->msg), 31);
        else
            $_SESSION['smsg'] = $this->msg;
    }

    public function add($text)
    {
        if ($this->use_cookie)
            $this->msg[] = $text;
        else
            $_SESSION['smsg'][] = $text;

        $this->save_msg();
    }

    public function get_msg()
    {
        return $this->msg;
    }

    public function clear()
    {
        /* if ($this->use_cookie)
            $this->set_cookie('smsg', '', -1);
        else
            $_SESSION['smsg'] = []; */
    }
}
