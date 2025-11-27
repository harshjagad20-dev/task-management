<?php

namespace App\Http\Requests;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $priority = [
            Task::PRIORITY_LOW,
            Task::PRIORITY_MEDIUM,
            Task::PRIORITY_HIGH
        ];

        $rules = [
            "title" => [
                "required",
                "min:3",
                "max:200"
            ],
            "description" => [
                "nullable",
                "max:1000"
            ],
            "status" => [
                "nullable",
                Rule::in([
                    Task::STATUS_TODO,
                    Task::STATUS_IN_PROGRESS,
                    Task::STATUS_DONE
                ])
            ],
            "priority" => [
                "required",
                Rule::in($priority)
            ],
            "due_date" => [
                "nullable",
                "date",
                "after_or_equal:today"
            ],
        ];

        if ($this->isMethod('PUT')) {
            $rules["priority"] = [
                "nullable",
                Rule::in($priority)
            ];
        }

        return $rules;
    }

   protected function prepareForValidation()
    {
        if ($this->isMethod('POST')) {
            $this->merge([
                'status' => $this->status ?? Task::STATUS_TODO,
            ]);
        }

        if ($this->priority === Task::PRIORITY_HIGH) {
            $this->merge([
                'due_date_rule' => now()->addDays(7)->toDateString()
            ]);
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->priority === Task::PRIORITY_HIGH &&
                Carbon::parse($this->due_date)->gt(now()->addDays(7))) {
                $validator->errors()->add('due_date', 'High priority tasks must be due within 7 days.');
            }

            if ($this->isMethod('PUT')) {
                $task = $this->route('task');

                if ($task) {
                    $old = $task->status;
                    $new = $this->status;

                    if ($new && ($old === Task::STATUS_DONE && $new !== Task::STATUS_DONE)) {
                        $validator->errors()->add('status', "Cannot change status from DONE.");
                    }

                    $allowed = [
                        Task::STATUS_TODO => [
                            Task::STATUS_IN_PROGRESS
                        ],
                        Task::STATUS_IN_PROGRESS => [
                            Task::STATUS_DONE
                        ],
                    ];

                    if ($new && isset($allowed[$old]) && !in_array($new, $allowed[$old])) {
                        $validator->errors()
                            ->add('status', "Invalid transition from $old to $new");
                    }
                }
            }
        });
    }
}
