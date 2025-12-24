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

    public function setUp(): void
    {
        parent::setUp();

        Label::factory(20)->create();
        User::factory(10)->create();
    }

    public function testLabelsPageIsDisplayed(): void
    {
        $response1 = $this->get('/labels');
        $response1->assertOk();

        $user = User::inRandomOrder()->first();
        $response2 = $this
            ->actingAs($user)
            ->get('/labels');
        $response2->assertOk();
    }

    public function testUserCanAddUpdateDeleteLabels(): void
    {
        $user = User::inRandomOrder()->first();
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

    public function testUserCanNotDeleteUsedLabels(): void
    {
        TaskStatus::factory(4)->create();
        Task::factory(15)->create();

        $user = User::inRandomOrder()->first();
        $label = Label::inRandomOrder()->whereHas('tasks')->with('tasks')->firstOrFail();

        $rowsCount = Label::query()->count();

        $response = $this
            ->actingAs($user)
            ->delete("/labels/{$label->id}");
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/labels');
        $this->assertEquals($rowsCount, Label::query()->count());
    }

    public function testGuestCanNotAddUpdateDeleteLabels(): void
    {
        $rowsCount = Label::query()->count();

        $response1 = $this->post('/labels', [
                'name' => 'Label name',
            ]);
        $response1
            ->assertSessionHasNoErrors()
            ->assertStatus(403);
        $this->assertEquals($rowsCount, Label::query()->count());

        $label = Label::inRandomOrder()->first();
        $expexted = $label->name;

        $response2 = $this->patch("/labels/{$label->id}", [
                'name' => "$expexted new name",
            ]);
        $response2
            ->assertSessionHasNoErrors()
            ->assertStatus(403);
        $label->refresh();
        $this->assertSame($expexted, $label->name);

        $response3 = $this->delete("/labels/{$label->id}");
        $response3
            ->assertSessionHasNoErrors()
            ->assertStatus(403);
        $this->assertEquals($rowsCount, Label::query()->count());
    }
}
