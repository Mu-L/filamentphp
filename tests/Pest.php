<?php

use Illuminate\Database\Eloquent\Model;

expect()->extend('toBeSameModel', function (Model $model) {
    return $this
        ->is($model)->toBeTrue();
});

/*
|--------------------------------------------------------------------------
| Eager-load Real-Time Facades
|--------------------------------------------------------------------------
|
| Real-time facades are generated on-demand and cached as PHP files in
| storage/framework/cache/. When running tests in parallel, multiple
| workers may try to generate the same facade file simultaneously,
| causing a race condition where one worker reads an incomplete file.
|
| By referencing the facade here (before parallel workers spawn), we
| ensure the facade file is generated once in the main process, avoiding
| the race condition entirely.
|
*/

class_exists(\Facades\Livewire\Features\SupportFileUploads\GenerateSignedUploadUrl::class);
