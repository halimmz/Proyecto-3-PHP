<?php
class Pokemon {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function get_data() {
        return $this->data;
    }

    public function get_message() {
        // lógica para obtener mensaje
    }
}