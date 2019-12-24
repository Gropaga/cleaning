<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Todo\Application\Command\Todo\Create;
use CleaningCRM\Todo\Application\Command\Todo\Handler\CreateHandler;
use CleaningCRM\Todo\Application\Dto\TodoDto;
use CleaningCRM\Todo\Domain\Todo\TodoId;
use CleaningCRM\Todo\Domain\Todo\TodoRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CreateHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function isShouldAddToRepo()
    {
        $repo = $this->getMockBuilder(TodoRepository::class)->getMock();
        $repo->expects($this->once())->method('add');

        $todoDto = new TodoDto();
        $todoDto->start = new DateTimeImmutable();
        $todoDto->end = new DateTimeImmutable();
        $todoDto->completed = true;
        $todoDto->title = 'Titleeee';
        $todoDto->description = 'Megadescription';

        $command = new Create(
            (string) TodoId::generate(),
            $todoDto
        );

        call_user_func(new CreateHandler($repo), $command);
    }
}
