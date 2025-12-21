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
    public function test_tasks_page_is_displayed(): void
    {
        User::factory()->create();
        TaskStatus::factory()->create();
                
        $task = Task::factory()->create();

        $response1 = $this->get('/tasks');
        $response1->assertOk();
        
        $response2 = $this->get("/tasks/{$task->id}");
        $response2->assertOk();
    }
    
    public function test_user_can_add_update_tasks(): void
    {
        $user = User::factory()->create();
        $task_status = TaskStatus::factory()->create();
        
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
    
    public function test_only_author_can_delete_task(): void
    {
        $user1 = User::factory()->create();
        TaskStatus::factory()->create();
        $task = Task::factory()->create();
        $user2 = User::factory()->create();

        $rowsCount = Task::query()->count();

        $response1 = $this
            ->actingAs($user2)
            ->delete("/tasks/{$task->id}");
        $response1
            ->assertSessionHasNoErrors()
            ->assertRedirect('/tasks');
        $this->assertEquals($rowsCount, Task::query()->count());
        
        $response2 = $this
            ->actingAs($user1)
            ->delete("/tasks/{$task->id}");
        $response2
            ->assertSessionHasNoErrors()
            ->assertRedirect('/tasks');
        $this->assertEquals($rowsCount - 1, Task::query()->count());
    }
    
    public function test_guest_can_not_add_update_delete_tasks(): void
    {
        User::factory()->create();
        TaskStatus::factory()->create();
        $task = Task::factory()->create();
        
        $rowsCount = Task::query()->count();
        
        $response1 = $this
            ->post('/tasks', [
                'name' => 'Test',
                'status_id' => $task->status_id,
                'created_by_id' => $task->created_by_id
            ]);
        $response1
            ->assertSessionHasNoErrors()
            ->assertRedirect('/login');
        $this->assertEquals($rowsCount, Task::query()->count());
        
        $expexted = "{$task->name} new name";

        $response2 = $this->patch("/tasks/{$task->id}", [
                'name' => $expexted,
                'status_id' => $task->status_id,
                'created_by_id' => $task->created_by_id
            ]);
        $response2
            ->assertSessionHasNoErrors()
            ->assertRedirect('/login');
        $task->refresh();
        $this->assertNotSame($expexted, $task->name);
        
        $response3 = $this->delete("/tasks/{$task->id}");
        $response3
            ->assertSessionHasNoErrors()
            ->assertRedirect('/login');
        $this->assertEquals($rowsCount, Task::query()->count());
    }
}
