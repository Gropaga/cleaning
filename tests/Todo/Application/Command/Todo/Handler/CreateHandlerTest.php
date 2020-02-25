<?php

namespace CleaningCRM\Tests\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Cleaning\Application\Todo\Command\Create;
use CleaningCRM\Cleaning\Application\Todo\Command\Handler\CreateHandler;
use CleaningCRM\Cleaning\Application\Todo\Dto\TodoDto;
use CleaningCRM\Cleaning\Domain\Shared\EventPublisher;
use CleaningCRM\Cleaning\Domain\Shared\Interval;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use CleaningCRM\Cleaning\Domain\Todo\TodoRepository;
use DateInterval;
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
        $todoDto->start = (new DateTimeImmutable())->format('Y-m-d\TH:i:s');
        $todoDto->end = (new DateTimeImmutable())->add(new DateInterval('P1D'))->format('Y-m-d\TH:i:s');
        $todoDto->completed = true;
        $todoDto->title = 'Titleeee';
        $todoDto->description = 'Megadescription';

        $command = new Create(
            TodoId::generate(),
            $todoDto
        );

        call_user_func(new CreateHandler($repo, $publisher), $command);
    }
}
