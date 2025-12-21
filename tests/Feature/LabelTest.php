<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Label;
use App\Models\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    public function test_labels_page_is_displayed(): void
    {
        Label::factory()->create();

        $response = $this->get('/labels');
        $response->assertOk();
    }
    
    public function test_user_can_add_update_delete_labels(): void
    {
        $user = User::factory()->create();
        $rowsCount = Label::query()->count();
        
        $response1 = $this
            ->actingAs($user)
            ->post('/labels', [
                'name' => 'Label name',
            ]);
        $response1
            ->assertSessionHasNoErrors()
            ->assertRedirect('/labels');
        $this->assertEquals($rowsCount + 1, Label::query()->count());
        
        $label = Label::first();
        $expexted = "{$label->name} new name";
        
        $response2 = $this
            ->actingAs($user)
            ->patch("/labels/{$label->id}", [
                'name' => $expexted,
            ]);
        $response2
            ->assertSessionHasNoErrors()
            ->assertRedirect('/labels');
        $label->refresh();
        $this->assertSame($expexted, $label->name);
        
        $response3 = $this
            ->actingAs($user)
            ->delete("/labels/{$label->id}");
        $response3
            ->assertSessionHasNoErrors()
            ->assertRedirect('/labels');
        $this->assertEquals($rowsCount, Label::query()->count());
    }
    
    public function test_user_can_not_delete_used_labels(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();
        TaskStatus::factory()->create();
        Task::factory()->create();
        
        $rowsCount = Label::query()->count();
        
        $response = $this
            ->actingAs($user)
            ->delete("/labels/{$label->id}");
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/labels');
        $this->assertEquals($rowsCount, Label::query()->count());
    }
    
    public function test_guest_can_not_add_update_delete_labels(): void
    {
        $rowsCount = Label::query()->count();
        
        $response1 = $this->post('/labels', [
                'name' => 'Label name',
            ]);
        $response1
            ->assertSessionHasNoErrors()
            ->assertRedirect('/login');
        $this->assertEquals($rowsCount, Label::query()->count());
        
        $label = Label::factory()->create();
        $expexted = $label->name;
        
        $response2 = $this->patch("/labels/{$label->id}", [
                'name' => "$expexted new name",
            ]);
        $response2
            ->assertSessionHasNoErrors()
            ->assertRedirect('/login');
        $label->refresh();
        $this->assertSame($expexted, $label->name);
        
        $response3 = $this->delete("/labels/{$label->id}");
        $response3
            ->assertSessionHasNoErrors()
            ->assertRedirect('/login');
        $this->assertEquals($rowsCount + 1, Label::query()->count());
    }
}
