<?php


namespace App\Application\Common;


class RestrictedAction implements Action
{
    private $action;

    private $restricter;

    public function __construct(Action $action, Restricter $restricter)
    {
        $this->action = $action;
        $this->restricter = $restricter;
    }

    public function doSomething()
    {
        $this->restricter->restrict();
        $this->action->doSomething();
    }
}