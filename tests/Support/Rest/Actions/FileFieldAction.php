<?php

namespace Lomkit\Rest\Tests\Support\Rest\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Lomkit\Rest\Actions\Action;
use Lomkit\Rest\Http\Requests\RestRequest;

class FileFieldAction extends Action
{
    /**
     * Perform the action on the given models.
     *
     * The uploaded file's original name is written on the model so a test can observe that the real
     * UploadedFile instance reached the action, not a null placeholder.
     *
     * @param array                          $fields
     * @param \Illuminate\Support\Collection $models
     *
     * @return mixed
     */
    public function handle(array $fields, Collection $models)
    {
        foreach ($models as $model) {
            /** @var Model $model */
            $model->forceFill(
                [
                    'name'   => $fields['avatar']->getClientOriginalName(),
                    'number' => $fields['number'] ?? 1,
                ]
            )
                ->save();
        }
    }

    /**
     * The fields available on this action.
     *
     * @param RestRequest $request
     *
     * @return array
     */
    public function fields(RestRequest $request): array
    {
        return [
            'avatar' => [
                'required',
                'file',
                'image',
                'max:1024',
            ],
            'number' => [
                'sometimes',
                'numeric',
            ],
        ];
    }
}
