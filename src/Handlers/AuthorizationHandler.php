<?php

namespace SMartins\Exceptions\Handlers;

use SMartins\Exceptions\JsonApi\Error;
use SMartins\Exceptions\JsonApi\Source;
use SMartins\Exceptions\Response\ErrorHandledCollectionInterface;
use SMartins\Exceptions\Response\ErrorHandledInterface;

class AuthorizationHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(): ErrorHandledInterface|ErrorHandledCollectionInterface
    {
        return (new Error())->setStatus(403)
            ->setCode($this->getCode('authorization'))
            ->setSource((new Source())->setPointer($this->getDefaultPointer()))
            ->setTitle(__('exception::exceptions.authorization.title'))
            ->setDetail($this->exception->getMessage());
    }
}
