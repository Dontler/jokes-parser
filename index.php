<?php


require 'vendor/autoload.php';


use App\JokesService;


try {

    $requestData = file_get_contents('php://input');
    $data = json_decode($requestData, true);

    $date = new \DateTime();
    $date->setTimestamp($data['date']);

    $jokes = (new JokesService())->getJokes($date);
    $jokesText = array();
    foreach ($jokes as $joke) {
        $jokesText[] = $joke->getText();
    }

    echo json_encode($jokesText);

} catch (\Exception $exception) {
    echo json_encode(array('error' => $exception->getMessage()));
}