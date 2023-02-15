<?php

namespace SMartins\Exceptions\Handlers;

use SMartins\Exceptions\JsonApi\Error;
use SMartins\Exceptions\JsonApi\Source;
use SMartins\Exceptions\Response\ErrorHandledCollectionInterface;
use SMartins\Exceptions\Response\ErrorHandledInterface;

class NotFoundHttpHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(): ErrorHandledInterface|ErrorHandledCollectionInterface
    {
        return (new Error())->setStatus($this->getStatusCode())
            ->setCode($this->getCode('not_found_http'))
            ->setSource((new Source())->setPointer($this->getDefaultPointer()))
            ->setTitle($this->getDefaultTitle())
            ->setDetail($this->getNotFoundMessage());
    }

    /**
     * Get message based on file. If file is RouteCollection return specific message.
     *
     * @return string
     */
    public function getNotFoundMessage()
    {
        $message = ! empty($this->exception->getMessage())
            ? $this->exception->getMessage()
            : class_basename($this->exception);

        if (basename($this->exception->getFile()) === 'RouteCollection.php') {
            $message = __('exception::exceptions.not_found_http.message');
        }

        return $message;
    }
}
