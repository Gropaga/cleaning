<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Cleaning\Application\Todo\Command\Delete;
use CleaningCRM\Cleaning\Application\Todo\Command\Handler\DeleteHandler;
use CleaningCRM\Cleaning\Domain\Todo\Todo;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use CleaningCRM\Cleaning\Domain\Todo\TodoRepository;
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
