<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Cleaning\Application\Todo\Command\Handler\UpdateHandler;
use CleaningCRM\Cleaning\Application\Todo\Command\Update;
use CleaningCRM\Cleaning\Application\Todo\Dto\TodoDto;
use CleaningCRM\Cleaning\Domain\Shared\Interval;
use CleaningCRM\Cleaning\Domain\Todo\Todo;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use CleaningCRM\Cleaning\Domain\Todo\TodoRepository;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class UpdateHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function isShouldAddToRepo()
    {
        $todo = Todo::createEmptyTodoWithId(TodoId::generate());

        $start = DateTimeImmutable::createFromFormat('Y-m-d', '2000-10-10')->setTime(0, 0);
        $end = $start->add(new DateInterval('PT1H'));

        $interval = Interval::create($start, $end);

        $todoDto = new TodoDto();
        $todoDto->interval = $interval;
        $todoDto->completed = true;
        $todoDto->title = 'New Title';
        $todoDto->description = 'New Description';

        $repo = $this->getMockBuilder(TodoRepository::class)->getMock();
        $repo->expects($this->once())->method('add');
        $repo->expects($this->once())->method('get')->willReturn(
            $todo
        );

        $command = new Update(
            (string) TodoId::generate(),
            $todoDto
        );

        call_user_func(new UpdateHandler($repo), $command);

        $this->assertNull($todo->getDeletedAt());
        $this->assertEquals('New Title', $todo->getTitle());
        $this->assertEquals('New Description', $todo->getDescription());
        $this->assertTrue($todo->isCompleted());
        $this->assertEquals($interval, $todo->getInterval());
    }
}
