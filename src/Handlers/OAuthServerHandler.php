<?php

namespace SMartins\Exceptions\Handlers;

use League\OAuth2\Server\Exception\OAuthServerException;
use SMartins\Exceptions\JsonApi\Error;
use SMartins\Exceptions\JsonApi\Source;

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
    public function handle()
    {
        return (new Error())->setStatus($this->getHttpStatusCode())
            ->setSource((new Source())->setPointer($this->getDefaultPointer()))
            ->setTitle($this->exception->getErrorType())
            ->setDetail($this->exception->getMessage());
    }
}
