<?php

namespace Lomkit\Rest\Tests\Support\Rest\Resources;

class OrPerimeterModelResource extends ModelResource
{
    /**
     * A perimeter shaped like the common "mine or shared" tenant rule, whose first branch also
     * stops matching once ModifyNumberAction has run on a model.
     */
    public function searchQuery(\Lomkit\Rest\Http\Requests\RestRequest $request, \Illuminate\Contracts\Database\Eloquent\Builder $query)
    {
        $query = parent::searchQuery($request, $query);

        $query->where('number', '<', 100000000)->orWhere('string', 'public');

        return $query;
    }
}
