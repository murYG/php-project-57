<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Task;

class ExampleTest extends TestCase
{
    public function testTaskStatusFillableCheck(): void
    {
        $task = new Task(['name' => 'Test', 'id' => 1]);
        $this->assertNotEquals(1, $task->id);
    }
}
