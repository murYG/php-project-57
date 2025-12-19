<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     */
    public function test_task_status_page_is_displayed(): void
    {
        $response = $this->get('/task_status');

        $response->assertOk();
    }
    
    public function test_user_can_add_updated_delete_task_status(): void
    {
        $user = User::factory()->create();

        $rowsCount = TaskStatus::query()->count();
        $response = $this
            ->actingAs($user)
            ->post('/task_status', [
                'name' => 'Test',
            ]);

        $this->assertEquals($rowsCount + 1, TaskStatus::query()->count());
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/task_status');
        
        $task_status = TaskStatus::findOrFail(1);
        $expexted = $task_status->name . ' 2';
        $response = $this
            ->actingAs($user)
            ->patch('/task_status/1', [
                'name' => $expexted,
            ]);
        
        $task_status->refresh();
        $this->assertSame($expexted, $task_status->name);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/task_status');
        
        $response = $this
            ->actingAs($user)
            ->delete('/task_status/1');
        
        $this->assertEquals($rowsCount, TaskStatus::query()->count());
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/task_status');
    }
    
    public function test_guest_can_not_add_updated_delete_task_status(): void
    {
        $rowsCount = TaskStatus::query()->count();
        $response = $this->post('/task_status', [
                'name' => 'Test',
            ]);

        $this->assertEquals($rowsCount, TaskStatus::query()->count());
        $response->assertRedirect('/login');
        
        $response = $this->patch('/task_status/1', [
                'name' => 'Test',
            ]);
        $response->assertRedirect('/login');
        
        $response = $this->delete('/task_status/1');
        $response->assertRedirect('/login');
        $this->assertEquals($rowsCount, TaskStatus::query()->count());
    }
}
