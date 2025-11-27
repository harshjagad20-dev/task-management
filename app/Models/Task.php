<?php

namespace App\Models;

use App\Builders\TaskBuilder;
use App\Http\Requests\TaskRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public const STATUS_TODO = 'TODO';
    public const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    public const STATUS_DONE = 'DONE';

    public const PRIORITY_LOW = 'LOW';
    public const PRIORITY_MEDIUM = 'MEDIUM';
    public const PRIORITY_HIGH = 'HIGH';

    public function newEloquentBuilder($builder)
    {
        return new TaskBuilder($builder);
    }

    public static function createFromRequest(TaskRequest $request)
    {
        return self::create($request->validated());
    }

    public function updateFromRequest(TaskRequest $request)
    {
        $this->update($request->validated());

        return $this;
    }
}
