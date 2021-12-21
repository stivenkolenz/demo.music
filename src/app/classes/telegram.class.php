<?php

// namespace Classes\SendToTelegram;


class SendToTelegram {
    var $_TOKEN = null;
    var $_CHATID = null;
    var $_ACTION = null;
    var $_DATA = null;

    function __construct ( $token = null, $id = null ) {
        $this->setConfig( $token, $id );
    }

    private function setConfig ( $token, $id ) {
        if ( $token == false || $id == false ) {
            die ( 'Error! TOKEN or CHATID not set' );
        }
        $this->_TOKEN = $token;
        $this->_CHATID = $id;
    }

    private function send () {
        $POSTFIELDS = array_merge(['chat_id' => $this->_CHATID], $this->_DATA);
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot' . $this->_TOKEN . '/'.$this->_ACTION,
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => $POSTFIELDS,
            )
        );
        curl_exec($ch);
    }

    public function sendMessage ( $message ) {
        $this->_ACTION = 'sendMessage';
        $this->_DATA = ['text'=> $message, 'parse_mode' => 'HTML'];
        $this->send();
    }

    public function sendPhoto ( $photo, $caption = false ) {
        $this->_ACTION = 'sendPhoto';
        $this->_DATA = ['photo'=> new CURLFile( realpath( $photo ) ) ];
        if ( $caption ) $this->_DATA['caption'] = $caption;
        $this->send();
    }

    public function sendDocument ( $document, $caption = false ) {
        $this->_ACTION = 'sendDocument';
        $this->_DATA = ['document'=> new CURLFile( realpath( $document ) ) ];
        if ( $caption ) $this->_DATA['caption'] = $caption;
        $this->send();
    }

    public function getUpdates () {
        $data = json_decode ( file_get_contents ( "https://api.telegram.org/bot".$this->_TOKEN."/getUpdates" ) );
        return $data;
    }

    public function botInfo () {
        $data = json_decode ( file_get_contents ( "https://api.telegram.org/bot".$this->_TOKEN."/getMe" ) );
        return $data;
    }
    
}

?>