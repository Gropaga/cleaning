<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Common\Domain\Interval;
use CleaningCRM\Todo\Application\Command\Todo\Handler\UpdateHandler;
use CleaningCRM\Todo\Application\Command\Todo\Update;
use CleaningCRM\Todo\Application\Dto\TodoDto;
use CleaningCRM\Todo\Domain\Todo\Todo;
use CleaningCRM\Todo\Domain\Todo\TodoId;
use CleaningCRM\Todo\Domain\Todo\TodoRepository;
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
