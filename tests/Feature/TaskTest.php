<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        User::factory(10)->create();
        TaskStatus::factory(4)->create();
        Label::factory(20)->create();
        Task::factory(15)->create();
    }

    /**
     * A basic feature test example.
     */
    public function testTasksPageIsDisplayed(): void
    {
        $task = Task::inRandomOrder()->first();

        $response1 = $this->get('/tasks');
        $response1->assertOk();

        $response2 = $this->get("/tasks/{$task->id}");
        $response2->assertOk();
    }

    public function testUserCanAddUpdateTasks(): void
    {
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
        $task = Task::inRandomOrder()->with('author')->firstOrFail();
        $task->labels()->detach();

        $user1 = $task->author;
        $user2 = User::factory()->create();

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
        $task = Task::inRandomOrder()->first();
        $task->labels()->detach();

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

    public function testTaskWithLabels(): void
    {
        $task = Task::inRandomOrder()->first();
        $user = $task->author;

        $expected1 = Label::limit(5)->orderBy('id')->pluck('id')->toArray();
        $response1 = $this->actingAs($user)->patch("/tasks/{$task->id}", [
                'name' => $task->name,
                'status_id' => $task->status_id,
                'labels' => $expected1
            ]);
        $response1->assertValid();

        $task->refresh();
        $result1 = $task->labels()->orderBy('labels.id')->pluck('labels.id')->toArray();
        $this->assertEquals($expected1, $result1);

        $expected2 = [];
        $response2 = $this->actingAs($user)->patch("/tasks/{$task->id}", [
                'name' => $task->name,
                'status_id' => $task->status_id,
                'labels' => null
            ]);
        $response2->assertValid();

        $task->refresh();
        $result2 = $task->labels()->orderBy('labels.id')->pluck('labels.id')->toArray();
        $this->assertEquals($expected2, $result2);

        $response3 = $this->actingAs($user)->patch("/tasks/{$task->id}", [
                'name' => $task->name,
                'status_id' => $task->status_id,
                'labels' => [null, 'smth', 1]
            ]);
        $response3->assertInvalid(['labels.0', 'labels.1']);

        $response4 = $this->actingAs($user)->patch("/tasks/{$task->id}", [
                'name' => $task->name,
                'status_id' => $task->status_id,
                'labels' => [1, 10000]
            ]);
        $response4->assertInvalid(['labels.1']);
    }
}
