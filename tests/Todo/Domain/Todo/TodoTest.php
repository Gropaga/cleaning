<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\DomainEvents;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use CleaningCRM\Todo\Domain\Todo\Todo;
use CleaningCRM\Todo\Domain\Todo\TodoCompletedWasChanged;
use CleaningCRM\Todo\Domain\Todo\TodoDateWasChanged;
use CleaningCRM\Todo\Domain\Todo\TodoDeletedAtWasChanged;
use CleaningCRM\Todo\Domain\Todo\TodoDescriptionWasChanged;
use CleaningCRM\Todo\Domain\Todo\TodoId;
use CleaningCRM\Todo\Domain\Todo\TodoTitleWasChanged;
use CleaningCRM\Todo\Domain\Todo\TodoWasCreated;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class TodoTest extends TestCase
{
    private const HAS_DOMAIN_EFFECT = true;
    private const NO_DOMAIN_EFFECT = false;

    /**
     * @test
     */
    public function itShouldRecordTodoWasCreatedEvent()
    {
        $date = (new DateTimeImmutable())->setTime(0, 0);
        $deletedAt = (new DateTimeImmutable())->setTime(12, 0);

        $todo = Todo::create(
            TodoId::generate(),
            'Title 1234',
            'Description 5678',
            true,
            $date,
            $deletedAt
        );

        $this->assertTrue(
            $this->assertEvent($todo->getRecordedEvents(), TodoWasCreated::class)
        );

        $this->assertEquals('Title 1234', $todo->getTitle());
        $this->assertEquals('Description 5678', $todo->getDescription());
        $this->assertEquals(true, $todo->isCompleted());
        $this->assertEquals($date, $todo->getDate());
        $this->assertEquals($deletedAt, $todo->getDeletedAt());

    }

    public function eventProvider()
    {
        return [
            [
                'changeTitle',
                TodoTitleWasChanged::class,
                'Hello world',
                'getTitle',
                self::HAS_DOMAIN_EFFECT
            ],
            [
                'changeTitle',
                TodoTitleWasChanged::class,
                'Title 1234',
                'getTitle',
                self::NO_DOMAIN_EFFECT
            ],
            [
                'changeDescription',
                TodoDescriptionWasChanged::class,
                'Something new',
                'getDescription',
                self::HAS_DOMAIN_EFFECT
            ],
            [
                'changeDescription',
                TodoDescriptionWasChanged::class,
                'Description 5678',
                'getDescription',
                self::NO_DOMAIN_EFFECT
            ],
            [
                'changeCompleted',
                TodoCompletedWasChanged::class,
                false,
                'isCompleted',
                self::HAS_DOMAIN_EFFECT
            ],
            [
                'changeCompleted',
                TodoCompletedWasChanged::class,
                true,
                'isCompleted',
                self::NO_DOMAIN_EFFECT
            ],
            [
                'changeDate',
                TodoDateWasChanged::class,
                DateTimeImmutable::createFromFormat('Y-m-d', '1980-01-01'),
                'getDate',
                self::HAS_DOMAIN_EFFECT
            ],
            [
                'changeDate',
                TodoDateWasChanged::class,
                DateTimeImmutable::createFromFormat('Y-m-d', '1990-02-02')->setTime(0, 0),
                'getDate',
                self::NO_DOMAIN_EFFECT
            ],
            [
                'changeDeletedAt',
                TodoDeletedAtWasChanged::class,
                DateTimeImmutable::createFromFormat('Y-m-d', '2000-01-01'),
                'getDeletedAt',
                self::HAS_DOMAIN_EFFECT
            ],
            [
                'changeDeletedAt',
                TodoDeletedAtWasChanged::class,
                null,
                'getDeletedAt',
                self::NO_DOMAIN_EFFECT
            ],
        ];
    }

    /**
     * @test
     * @dataProvider eventProvider
     */
    public function recordChangedEvent($actionName, $domainEventClass, $value, $valueGetter, $hasEffect)
    {
        $todo = Todo::create(
            TodoId::generate(),
            'Title 1234',
            'Description 5678',
            true,
            DateTimeImmutable::createFromFormat('Y-m-d', '1990-02-02')->setTime(0, 0)
        );

        $todo->{$actionName}($value);

        $this->assertEvent($todo->getRecordedEvents(), $domainEventClass);

        if ($hasEffect) {
            $this->assertTrue(
                $this->assertEvent($todo->getRecordedEvents(), $domainEventClass)
            );
            $this->assertEquals($value, $todo->{$valueGetter}());
        } else {
            $this->assertEquals(1, $todo->getRecordedEvents()->getIterator()->count());
        }
    }

    /**
     * @test
     */
    public function itShouldBeReconstitutedFromHistory()
    {
        $todoId = TodoId::generate();

        $eventsHistory = new DomainEventsHistory(
            $todoId,
            [
                new TodoWasCreated(
                    $todoId,
                    'Title 1234',
                    'Description 5678',
                    true,
                    new DateTimeImmutable()
                ),
                new TodoTitleWasChanged($todoId, 'New Title'),
                new TodoDescriptionWasChanged($todoId, 'New Description'),
                new TodoCompletedWasChanged($todoId, false),
                new TodoDateWasChanged($todoId, DateTimeImmutable::createFromFormat('Y-m-d', '2019-01-01')->setTime(0,0))
            ]
        );

        $todo = Todo::reconstituteFromHistory($eventsHistory);

        $this->assertEquals('New Title', $todo->getTitle());
        $this->assertEquals('New Description', $todo->getDescription());
        $this->assertEquals(false, $todo->isCompleted());
        $this->assertEquals(DateTimeImmutable::createFromFormat('Y-m-d', '2019-01-01')->setTime(0,0)->format('Y-m-d H:i:s'), $todo->getDate()->format('Y-m-d H:i:s'));
    }

    private function assertEvent(DomainEvents $recodedEvents, $eventClass): bool
    {
        foreach ($recodedEvents as $event) {
            if (get_class($event) === $eventClass) {
                return true;
            }
        }

        return false;
    }
}
