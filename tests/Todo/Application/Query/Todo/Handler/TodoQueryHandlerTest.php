<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Application\Query\Todo\Handler;

use CleaningCRM\Todo\Application\Query\Todo\Handler\TodoQueryHandler;
use CleaningCRM\Todo\Application\Query\Todo\TodoQuery;
use CleaningCRM\Todo\Domain\Todo\TodoId;
use CleaningCRM\Todo\Domain\Todo\TodoQueryRepository;
use PHPUnit\Framework\TestCase;

class TodoQueryHandlerHandlerTest extends TestCase
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

        call_user_func(new TodoQueryHandler($repo), $query);
    }
}
