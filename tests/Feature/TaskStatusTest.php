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
        TaskStatus::factory(4)->create();

        $response = $this->get('/task_statuses');
        $response->assertOk();
    }

    public function testUserCanAddUpdateDeleteTaskStatuses(): void
    {
        User::factory(10)->create();

        $user = User::inRandomOrder()->first();
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
        User::factory(10)->create();
        TaskStatus::factory(4)->create();
        Task::factory(15)->create();

        $user = User::inRandomOrder()->first();
        $task_status = TaskStatus::inRandomOrder()->whereHas('tasks')->with('tasks')->firstorFail();

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
        TaskStatus::factory(4)->create();

        $rowsCount = TaskStatus::query()->count();

        $response1 = $this->post('/task_statuses', [
                'name' => 'Task status name',
            ]);
        $response1
            ->assertSessionHasNoErrors()
            ->assertStatus(403);
        $this->assertEquals($rowsCount, TaskStatus::query()->count());

        $task_status = TaskStatus::inRandomOrder()->first();
        $expexted = $task_status->name;

        $response2 = $this->patch("/task_statuses/{$task_status->id}", [
                'name' => "$expexted new name",
            ]);
        $response2
            ->assertSessionHasNoErrors()
            ->assertStatus(403);
        $task_status->refresh();
        $this->assertSame($expexted, $task_status->name);

        $response3 = $this->delete("/task_statuses/{$task_status->id}");
        $response3
            ->assertSessionHasNoErrors()
            ->assertStatus(403);
        $this->assertEquals($rowsCount, TaskStatus::query()->count());
    }
}
