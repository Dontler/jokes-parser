<?php


namespace App\Controllers;


use App\Jokes\JokesService;


class JokesController {

    public function list() {
        $date = new \DateTime();
        $date->setTimestamp($_GET['date']);

        $jokes = (new JokesService())->getJokes($date);
        $jokesText = array();
        foreach ($jokes as $joke) {
            $jokesText[] = array(
                    'text' => $joke->getText(),
                    'rating' => $joke->getRating()
            );
        }

        echo json_encode($jokesText);
    }

}