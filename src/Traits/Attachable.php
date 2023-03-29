<?php

namespace zedsh\tower\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Attachable
{
    public function files()
    {
        return $this->morphToMany(zedsh\tower\Models\File::class, 'attachable');
    }
}
