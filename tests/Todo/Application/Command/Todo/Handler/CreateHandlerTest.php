<?php

namespace CleaningCRM\Tests\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Cleaning\Application\Todo\Command\Create;
use CleaningCRM\Cleaning\Application\Todo\Command\Handler\CreateHandler;
use CleaningCRM\Cleaning\Application\Todo\Dto\TodoDto;
use CleaningCRM\Cleaning\Domain\Shared\EventPublisher;
use CleaningCRM\Cleaning\Domain\Shared\Interval;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use CleaningCRM\Cleaning\Domain\Todo\TodoRepository;
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

        $publisher = $this->getMockBuilder(EventPublisher::class)->getMock();
        $publisher->expects($this->once())->method('add');

        $todoDto = new TodoDto();
        $todoDto->interval = Interval::create(new DateTimeImmutable(), new DateTimeImmutable());
        $todoDto->completed = true;
        $todoDto->title = 'Titleeee';
        $todoDto->description = 'Megadescription';

        $command = new Create(
            (string) TodoId::generate(),
            $todoDto
        );

        call_user_func(new CreateHandler($repo, $publisher), $command);
    }
}
