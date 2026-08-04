<?php

namespace Lomkit\Rest\Rules\Concerns;

use Illuminate\Support\Facades\Validator as ValidatorFactory;
use Illuminate\Validation\Validator;
use Lomkit\Rest\Support\Fields;

trait ValidatesFields
{
    /**
     * Pivot a positional [{name, value}] field list into an associative map
     * and validate it against the declared field rules, pushing any resulting
     * errors into the main validator under the given attribute prefix.
     *
     * @param Validator $validator       The main validator receiving the errors.
     * @param string    $attribute       The prefix for error keys (e.g. "fields").
     * @param mixed     $submittedFields The raw submitted fields list.
     * @param array     $declaredRules   The field rules keyed by field name.
     */
    protected function validateFields(
        Validator $validator,
        string $attribute,
        mixed $submittedFields,
        array $declaredRules
    ): void {
        if (!is_array($submittedFields)) {
            return;
        }

        $fieldsValidator = ValidatorFactory::make(Fields::pivot($submittedFields), $declaredRules);

        foreach ($fieldsValidator->errors()->messages() as $name => $messages) {
            foreach ($messages as $message) {
                $validator->errors()->add($attribute.'.'.$name, $message);
            }
        }
    }
}
