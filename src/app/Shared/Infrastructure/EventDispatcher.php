<?php

namespace App\Shared\Infrastructure;

use App\Shared\Contracts\Events\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface {
    private array $listeners = [];

    public function addListener(string $eventClass, callable $listener): void {
        $this->listeners[$eventClass][] = $listener;
    }

    public function dispatch(object $event): void {
        $eventClass = get_class($event);
        if (isset($this->listeners[$eventClass])) {
            foreach ($this->listeners[$eventClass] as $listener) {
                $listener($event);
            }
        }
    }
}