<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Application\Query\Todo\Handler;

use CleaningCRM\Todo\Application\Query\Todo\Handler\TodoCountQueryHandler;
use CleaningCRM\Todo\Application\Query\Todo\TodoCountQuery;
use CleaningCRM\Todo\Domain\Todo\TodoCountReadModel;
use CleaningCRM\Todo\Domain\Todo\TodoQueryRepository;
use PHPUnit\Framework\TestCase;

class TodoQueryCountHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function itQueryCountFetch()
    {
        $repo = $this->getMockBuilder(TodoQueryRepository::class)->getMock();
        $repo->expects($this->once())->method('count')->willReturn(new TodoCountReadModel(5));

        $query = new TodoCountQuery();

        call_user_func(new TodoCountQueryHandler($repo), $query);
    }
}
