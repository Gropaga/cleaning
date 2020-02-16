<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Application\Query\Todo\Handler;

use CleaningCRM\Cleaning\Application\Todo\Query\Handler\TodoByDateQueryHandler;
use CleaningCRM\Cleaning\Application\Todo\Query\TodoByDateQuery;
use CleaningCRM\Cleaning\Domain\Todo\TodoQueryRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TodoByDateQueryHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function itQueryByDateFetch()
    {
        $startDate = DateTimeImmutable::createFromFormat('Y-m-d', '2000-12-12')->setTime(0, 0);
        $endDate = DateTimeImmutable::createFromFormat('Y-m-d', '2000-12-20')->setTime(0, 0);

        $repo = $this->getMockBuilder(TodoQueryRepository::class)->getMock();
        $repo->expects($this->once())->method('byDate')->with(
            $startDate, $endDate
        );

        $query = new TodoByDateQuery($startDate, $endDate);

        call_user_func(new TodoByDateQueryHandler($repo), $query);
    }
}
