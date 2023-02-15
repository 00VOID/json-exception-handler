<?php

namespace SMartins\Exceptions\Handlers;

use League\OAuth2\Server\Exception\OAuthServerException;
use SMartins\Exceptions\JsonApi\Error;
use SMartins\Exceptions\JsonApi\Source;
use SMartins\Exceptions\Response\ErrorHandledCollectionInterface;
use SMartins\Exceptions\Response\ErrorHandledInterface;

class OAuthServerHandler extends AbstractHandler
{
    /**
     * Create instance using the Exception to be handled.
     */
    public function __construct(OAuthServerException $e)
    {
        parent::__construct($e);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(): ErrorHandledInterface|ErrorHandledCollectionInterface
    {
        return (new Error())->setStatus($this->getHttpStatusCode())
            ->setCode($this->getCode())
            ->setSource((new Source())->setPointer($this->getDefaultPointer()))
            ->setTitle($this->exception->getErrorType())
            ->setDetail($this->exception->getMessage());
    }
}
