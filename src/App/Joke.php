<?php


namespace App;


class Joke {

    private string $text;

    public function __construct(string $text) {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }

}