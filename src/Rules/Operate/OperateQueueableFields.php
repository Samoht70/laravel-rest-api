<?php

namespace Lomkit\Rest\Rules\Operate;

use Closure;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Arr;
use Illuminate\Validation\Validator;
use Lomkit\Rest\Actions\Action;
use Lomkit\Rest\Contracts\BatchableAction;
use Lomkit\Rest\Support\Fields;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OperateQueueableFields implements ValidationRule, ValidatorAwareRule
{
    /**
     * The validator instance.
     */
    protected Validator $validator;

    /**
     * The action being operated.
     */
    protected Action $action;

    /**
     * Set the current action.
     */
    public function setAction(Action $action): static
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Set the current validator.
     */
    public function setValidator(Validator $validator): static
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * PHP deletes the temporary upload as soon as the request ends, so a file serialized into a job
     * or into a batch's captured callbacks resolves to a path that no longer exists by the time a
     * worker picks it up. The caller is told at the boundary rather than after the models resolve.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->action instanceof ShouldQueue && !$this->action instanceof BatchableAction) {
            return;
        }

        foreach (Arr::dot(Fields::pivot($value)) as $name => $fieldValue) {
            if ($fieldValue instanceof UploadedFile) {
                $this->validator->errors()->add(
                    $attribute.'.'.$name,
                    'The '.$name.' field must not be an uploaded file because the '.$this->action->uriKey().' action is queued.'
                );
            }
        }
    }
}
