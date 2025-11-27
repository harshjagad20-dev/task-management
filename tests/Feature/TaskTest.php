<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    public function test_past_due_date_fails()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Test',
            'priority' => Task::PRIORITY_MEDIUM,
            'due_date' => now()->subDay()->toDateString(),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['due_date']);
    }
}
