<?php

namespace SMartins\Exceptions\Handlers;

use SMartins\Exceptions\JsonApi\Error;
use SMartins\Exceptions\JsonApi\Source;

class MissingScopeHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        return (new Error())->setStatus(403)
            ->setSource((new Source())->setPointer($this->getDefaultPointer()))
            ->setTitle($this->getDefaultTitle())
            ->setDetail($this->exception->getMessage());
    }
}
