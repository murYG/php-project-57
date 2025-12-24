<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testTasksPageIsDisplayed(): void
    {
        User::factory(10)->create();
        TaskStatus::factory(4)->create();
        Task::factory(15)->create();

        $task = Task::inRandomOrder()->first();

        $response1 = $this->get('/tasks');
        $response1->assertOk();

        $response2 = $this->get("/tasks/{$task->id}");
        $response2->assertOk();
    }

    public function testUserCanAddUpdateTasks(): void
    {
        User::factory(10)->create();
        TaskStatus::factory(4)->create();

        $user = User::inRandomOrder()->first();
        $task_status = TaskStatus::inRandomOrder()->first();

        $rowsCount = Task::query()->count();

        $response1 = $this
            ->actingAs($user)
            ->post('/tasks', [
                'name' => 'Task name',
                'status_id' => $task_status->id,
            ]);
        $response1
            ->assertSessionHasNoErrors()
            ->assertRedirect('/tasks');
        $this->assertEquals($rowsCount + 1, Task::query()->count());

        $task = Task::first();
        $expexted = "{$task->name} new name";

        $response2 = $this
            ->actingAs($user)
            ->patch("/tasks/{$task->id}", [
                'name' => $expexted,
                'status_id' => $task->status_id,
            ]);
        $response2
            ->assertSessionHasNoErrors()
            ->assertRedirect('/tasks');
        $task->refresh();
        $this->assertSame($expexted, $task->name);
    }

    public function testOnlyAuthorCanDeleteTask(): void
    {
        User::factory(10)->create();
        TaskStatus::factory(4)->create();
        Task::factory(15)->create();

        $task = Task::inRandomOrder()->first();
        $user1 = $task->author;
        $user2 = User::firstWhere('id', '<>', $user1->id);

        $rowsCount = Task::query()->count();

        $response1 = $this
            ->actingAs($user2)
            ->delete("/tasks/{$task->id}");
        $response1
            ->assertSessionHasNoErrors()
            ->assertStatus(403);
        $this->assertEquals($rowsCount, Task::query()->count());

        $response2 = $this
            ->actingAs($user1)
            ->delete("/tasks/{$task->id}");
        $response2
            ->assertSessionHasNoErrors()
            ->assertRedirect('/tasks');
        $this->assertEquals($rowsCount - 1, Task::query()->count());
    }

    public function testGuestCanNotAddUpdateDeleteTasks(): void
    {
        User::factory(10)->create();
        TaskStatus::factory(4)->create();
        Task::factory(15)->create();

        $task = Task::inRandomOrder()->first();

        $rowsCount = Task::query()->count();

        $response1 = $this
            ->post('/tasks', [
                'name' => 'Test',
                'status_id' => $task->status_id,
                'created_by_id' => $task->created_by_id
            ]);
        $response1
            ->assertSessionHasNoErrors()
            ->assertStatus(403);
        $this->assertEquals($rowsCount, Task::query()->count());

        $expexted = "{$task->name} new name";

        $response2 = $this->patch("/tasks/{$task->id}", [
                'name' => $expexted,
                'status_id' => $task->status_id,
                'created_by_id' => $task->created_by_id
            ]);
        $response2
            ->assertSessionHasNoErrors()
            ->assertStatus(403);
        $task->refresh();
        $this->assertNotSame($expexted, $task->name);

        $response3 = $this->delete("/tasks/{$task->id}");
        $response3
            ->assertSessionHasNoErrors()
            ->assertStatus(403);
        $this->assertEquals($rowsCount, Task::query()->count());
    }
}
