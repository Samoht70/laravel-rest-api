<?php

namespace Lomkit\Rest\Tests\Support\Rest\Actions;

use Illuminate\Contracts\Queue\ShouldQueue;

class QueueableFileFieldAction extends FileFieldAction implements ShouldQueue
{
}
