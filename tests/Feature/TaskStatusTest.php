<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskStatusesPageIsDisplayed(): void
    {
        TaskStatus::factory()->create();

        $response = $this->get('/task_statuses');
        $response->assertOk();
    }

    public function testUserCanAddUpdateDeleteTaskStatuses(): void
    {
        $user = User::factory()->create();
        $rowsCount = TaskStatus::query()->count();

        $response1 = $this
            ->actingAs($user)
            ->post('/task_statuses', [
                'name' => 'Task status name',
            ]);
        $response1
            ->assertSessionHasNoErrors()
            ->assertRedirect('/task_statuses');
        $this->assertEquals($rowsCount + 1, TaskStatus::query()->count());

        $task_status = TaskStatus::first();
        $expexted = "{$task_status->name} new name";

        $response2 = $this
            ->actingAs($user)
            ->patch("/task_statuses/{$task_status->id}", [
                'name' => $expexted,
            ]);
        $response2
            ->assertSessionHasNoErrors()
            ->assertRedirect('/task_statuses');
        $task_status->refresh();
        $this->assertSame($expexted, $task_status->name);

        $response3 = $this
            ->actingAs($user)
            ->delete("/task_statuses/{$task_status->id}");
        $response3
            ->assertSessionHasNoErrors()
            ->assertRedirect('/task_statuses');
        $this->assertEquals($rowsCount, TaskStatus::query()->count());
    }

    public function testUserCanNotDeleteUsedTaskStatuses(): void
    {
        $user = User::factory()->create();
        $task_status = TaskStatus::factory()->create();
        $task = Task::factory()->create();

        $rowsCount = TaskStatus::query()->count();

        $response = $this
            ->actingAs($user)
            ->delete("/task_statuses/{$task_status->id}");
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/task_statuses');
        $this->assertEquals($rowsCount, TaskStatus::query()->count());
    }

    public function testGuestCanNotAddUpdateDeleteTaskStatuses(): void
    {
        $rowsCount = TaskStatus::query()->count();

        $response1 = $this->post('/task_statuses', [
                'name' => 'Task status name',
            ]);
        $response1
            ->assertSessionHasNoErrors()
            ->assertRedirect('/login');
        $this->assertEquals($rowsCount, TaskStatus::query()->count());

        $task_status = TaskStatus::factory()->create();
        $expexted = $task_status->name;

        $response2 = $this->patch("/task_statuses/{$task_status->id}", [
                'name' => "$expexted new name",
            ]);
        $response2
            ->assertSessionHasNoErrors()
            ->assertRedirect('/login');
        $task_status->refresh();
        $this->assertSame($expexted, $task_status->name);

        $response3 = $this->delete("/task_statuses/{$task_status->id}");
        $response3
            ->assertSessionHasNoErrors()
            ->assertRedirect('/login');
        $this->assertEquals($rowsCount + 1, TaskStatus::query()->count());
    }
}
