<?php

namespace SMartins\Exceptions\Handlers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use SMartins\Exceptions\JsonApi\Error;
use SMartins\Exceptions\JsonApi\Source;
use SMartins\Exceptions\Response\ErrorHandledCollectionInterface;
use SMartins\Exceptions\Response\ErrorHandledInterface;

class ModelNotFoundHandler extends AbstractHandler
{
    /**
     * Create instance using the Exception to be handled.
     */
    public function __construct(ModelNotFoundException $e)
    {
        parent::__construct($e);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(): ErrorHandledInterface|ErrorHandledCollectionInterface
    {
        $entity = $this->extractEntityName($this->exception->getModel());

        $detail = __('exception::exceptions.model_not_found.title', ['model' => $entity]);

        return (new Error())->setStatus(404)
            ->setCode($this->getCode('model_not_found'))
            ->setSource((new Source())->setPointer('data/id'))
            ->setTitle(Str::snake(class_basename($this->exception)))
            ->setDetail($detail);
    }

    /**
     * Get entity name based on model path to mount the message.
     *
     * @return string
     */
    public function extractEntityName(string $model)
    {
        $classNames = (array) explode('\\', $model);

        $entityName = end($classNames);

        if ($this->entityHasTranslation($entityName)) {
            return __('exception::exceptions.models.'.$entityName);
        }

        return $entityName;
    }

    /**
     * Check if entity returned on ModelNotFoundException has translation on
     * exceptions file.
     *
     * @param  string  $entityName The model name to check if has translation
     * @return bool               Has translation or not
     */
    public function entityHasTranslation(string $entityName): bool
    {
        $hasKey = in_array($entityName, $this->translationModelKeys());

        if ($hasKey) {
            return ! empty($hasKey);
        }

        return false;
    }

    /**
     * Get the models keys on exceptions lang file.
     *
     * @return array An array with keys to translate
     */
    private function translationModelKeys(): array
    {
        return array_keys(__('exception::exceptions.models'));
    }
}
