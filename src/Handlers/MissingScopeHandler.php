<?php

namespace SMartins\Exceptions\Handlers;

use SMartins\Exceptions\JsonApi\Error;
use SMartins\Exceptions\JsonApi\Source;
use SMartins\Exceptions\Response\ErrorHandledCollectionInterface;
use SMartins\Exceptions\Response\ErrorHandledInterface;

class MissingScopeHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(): ErrorHandledInterface|ErrorHandledCollectionInterface
    {
        return (new Error())->setStatus(403)
            ->setCode($this->getCode('missing_scope'))
            ->setSource((new Source())->setPointer($this->getDefaultPointer()))
            ->setTitle($this->getDefaultTitle())
            ->setDetail($this->exception->getMessage());
    }
}
