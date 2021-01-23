<?php


namespace App;


class Route {

    /** @var string $controller */
    private $controller;
    /** @var string $action */
    private $action;

    public function __construct(string $controller, string $action) {
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getController(): string {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string {
        return $this->action;
    }

}