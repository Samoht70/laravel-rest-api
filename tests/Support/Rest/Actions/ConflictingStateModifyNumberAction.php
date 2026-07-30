<?php

namespace Lomkit\Rest\Tests\Support\Rest\Actions;

class ConflictingStateModifyNumberAction extends ModifyNumberAction
{
    public $standalone = true;

    public $targeted = true;
}
