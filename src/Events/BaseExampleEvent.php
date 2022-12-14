<?php
namespace DreamFactory\Core\Events;

use DreamFactory\Core\As400\Models\As400Config;
use Illuminate\Queue\SerializesModels;

abstract class BaseExampleEvent
{
    use SerializesModels;

    public $example;

    /**
     * Create a new event instance.
     *
     * @param As400Config $example
     */
    public function __construct(As400Config $example)
    {
        $this->example = $example;
    }
}

