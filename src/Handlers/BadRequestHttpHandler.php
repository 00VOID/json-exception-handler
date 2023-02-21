<?php

namespace SMartins\Exceptions\Handlers;

use SMartins\Exceptions\JsonApi\Error;
use SMartins\Exceptions\JsonApi\Source;
use SMartins\Exceptions\Response\ErrorHandledCollectionInterface;
use SMartins\Exceptions\Response\ErrorHandledInterface;

class BadRequestHttpHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        return (new Error())->setStatus(400)
            ->setSource((new Source())->setPointer($this->getDefaultPointer()))
            ->setTitle($this->getDefaultTitle())
            ->setDetail($this->exception->getMessage());
    }
}
