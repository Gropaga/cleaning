<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Todo\Application\Command\Todo\Delete;
use CleaningCRM\Todo\Application\Command\Todo\Handler\DeleteHandler;
use CleaningCRM\Todo\Domain\Todo\Todo;
use CleaningCRM\Todo\Domain\Todo\TodoId;
use CleaningCRM\Todo\Domain\Todo\TodoRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class DeleteHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function isShouldAddToRepo()
    {
        $todo = Todo::createEmptyTodoWithId(TodoId::generate());

        $repo = $this->getMockBuilder(TodoRepository::class)->getMock();
        $repo->expects($this->once())->method('add');
        $repo->expects($this->once())->method('get')->willReturn(
            $todo
        );

        $command = new Delete(
            (string) TodoId::generate(),
            new DateTimeImmutable()
        );

        call_user_func(new DeleteHandler($repo), $command);

        $this->assertNotNull($todo->getDeletedAt());
    }
}
