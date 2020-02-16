<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Application\Query\Todo\Handler;

use CleaningCRM\Cleaning\Application\Todo\Query\Handler\TodoCountQueryHandler;
use CleaningCRM\Cleaning\Application\Todo\Query\TodoCountQuery;
use CleaningCRM\Cleaning\Domain\Todo\TodoCountReadModel;
use CleaningCRM\Cleaning\Domain\Todo\TodoQueryRepository;
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
