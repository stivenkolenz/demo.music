<?php

class Content {

    private $content = [];
    private $name = null;

    public function create ( $name, $content = false ) {
        $this->setName( $name );
        $this->content[$this->name] = [];
        if ( $content !== false ) $this->add( $content );
    }

    public function add ( $content, $name = false ) {
        $this->content[( $name ? $name : $this->name )][] = $content;
    }

    public function setName ( $name ) {
        $this->name = $name;
    }

    public function get( $name = false ) {
        if ( empty($this->content[ ( $name ? $name : $this->name ) ])) return false;
        return implode( '', $this->content[ ( $name ? $name : $this->name ) ] );
    }

}