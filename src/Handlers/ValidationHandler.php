<?php

namespace SMartins\Exceptions\Handlers;

use SMartins\Exceptions\JsonApi\Error;
use SMartins\Exceptions\JsonApi\ErrorCollection;
use SMartins\Exceptions\JsonApi\Source;

class ValidationHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $errors = (new ErrorCollection())->setStatusCode(422);

        $failedFieldsRules = $this->getFailedFieldsRules();

        foreach ($this->getFailedFieldsMessages() as $field => $messages) {
            foreach ($messages as $key => $message) {
                $title = $this->getValidationTitle($failedFieldsRules, $key, $field);

                $error = (new Error())->setStatus(422)
                    ->setSource((new Source())->setPointer($field))
                    ->setTitle($title ?? $this->getDefaultTitle())
                    ->setDetail($message);

                $errors->push($error);
            }
        }

        return $errors;
    }

    /**
     * Get the title of response based on rules and field getting from translations.
     *
     * @return string|null
     */
    public function getValidationTitle(array $failedFieldsRules, string $key, string $field)
    {
        $title = __('exception::exceptions.validation.title', [
            'fails' => strtolower(array_keys($failedFieldsRules[$field])[$key]),
            'field' => $field,
        ]);

        return is_array($title) ? $title[0] : $title;
    }

    /**
     * Get message based on exception type. If exception is generated by
     * $this->validate() from default Controller methods the exception has the
     * response object. If exception is generated by Validator::make() the
     * messages are get different.
     */
    public function getFailedFieldsMessages(): array
    {
        return $this->exception->validator->messages()->messages();
    }

    /**
     * Get the rules failed on fields.
     */
    public function getFailedFieldsRules(): array
    {
        return (array) $this->exception->validator->errors()->messages();
    }
}
