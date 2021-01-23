<?php


namespace App\Jokes;


class Joke {

    /** @var string $text */
    private $text;
    /** @var int $rating */
    private $rating;

    public function __construct(string $text, int $rating) {
        $this->text = $text;
        $this->rating = $rating;
    }

    /**
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getRating(): int {
        return $this->rating;
    }

}