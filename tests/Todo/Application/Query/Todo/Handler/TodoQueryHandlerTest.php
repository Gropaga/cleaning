<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Application\Query\Todo\Handler;

use CleaningCRM\Cleaning\Application\Todo\Query\Handler\TodoByIdQueryHandler;
use CleaningCRM\Cleaning\Application\Todo\Query\TodoQuery;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use CleaningCRM\Cleaning\Domain\Todo\TodoQueryRepository;
use PHPUnit\Framework\TestCase;

class TodoQueryHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function itQueryByDateFetch()
    {
        $todoId = (string) TodoId::generate();

        $repo = $this->getMockBuilder(TodoQueryRepository::class)->getMock();
        $repo->expects($this->once())->method('byId')->with(
            $todoId
        );

        $query = new TodoQuery($todoId);

        call_user_func(new TodoByIdQueryHandler($repo), $query);
    }
}
