<?php

declare(strict_types=1);

namespace CleaningCRM\Tests\Todo\Domain\Todo;

use CleaningCRM\Cleaning\Domain\Shared\DomainEvents;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventsHistory;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use CleaningCRM\Cleaning\Domain\Shared\Interval;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoCompletedWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDescriptionWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoIntervalWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoTitleWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoWasCreated;
use CleaningCRM\Cleaning\Domain\Todo\Todo;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use DateInterval;
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
        $start = (new DateTimeImmutable())->setTime(0, 0);
        $end = (new DateTimeImmutable())->setTime(2, 0);
        $interval = Interval::create($start, $end);
        $deletedAt = (new DateTimeImmutable())->setTime(12, 0);

        $todo = Todo::create(
            TodoId::generate(),
            'Title 1234',
            'Description 5678',
            $interval,
            true,
            $deletedAt
        );

        $this->assertTrue(
            $this->assertEvent($todo->getRecordedEvents(), TodoWasCreated::class)
        );

        $this->assertEquals('Title 1234', $todo->getTitle());
        $this->assertEquals('Description 5678', $todo->getDescription());
        $this->assertEquals(true, $todo->isCompleted());
        $this->assertEquals($interval, $todo->getInterval());
        $this->assertEquals(null, $todo->getDeletedAt());
    }

    public function eventProvider()
    {
        return [
            [
                'changeTitle',
                TodoTitleWasChanged::class,
                'Hello world',
                'getTitle',
                self::HAS_DOMAIN_EFFECT,
            ],
            [
                'changeTitle',
                TodoTitleWasChanged::class,
                'Title 1234',
                'getTitle',
                self::NO_DOMAIN_EFFECT,
            ],
            [
                'changeDescription',
                TodoDescriptionWasChanged::class,
                'Something new',
                'getDescription',
                self::HAS_DOMAIN_EFFECT,
            ],
            [
                'changeDescription',
                TodoDescriptionWasChanged::class,
                'Description 5678',
                'getDescription',
                self::NO_DOMAIN_EFFECT,
            ],
            [
                'changeCompleted',
                TodoCompletedWasChanged::class,
                false,
                'isCompleted',
                self::HAS_DOMAIN_EFFECT,
            ],
            [
                'changeCompleted',
                TodoCompletedWasChanged::class,
                true,
                'isCompleted',
                self::NO_DOMAIN_EFFECT,
            ],
            [
                'changeInterval',
                TodoIntervalWasChanged::class,
                Interval::create(
                    DateTimeImmutable::createFromFormat('Y-m-d', '1980-02-01')->setTime(0, 0),
                    DateTimeImmutable::createFromFormat('Y-m-d', '1980-02-02')->setTime(0, 0)
                ),
                'getInterval',
                self::HAS_DOMAIN_EFFECT,
            ],
            [
                'changeInterval',
                TodoIntervalWasChanged::class,
                Interval::create(
                    DateTimeImmutable::createFromFormat('Y-m-d', '1980-01-01')->setTime(0, 0),
                    DateTimeImmutable::createFromFormat('Y-m-d', '1980-01-02')->setTime(0, 0)
                ),
                'getInterval',
                self::NO_DOMAIN_EFFECT,
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
            Interval::create(
                DateTimeImmutable::createFromFormat('Y-m-d', '1980-01-01')->setTime(0, 0),
                DateTimeImmutable::createFromFormat('Y-m-d', '1980-01-02')->setTime(0, 0)
            ),
            true
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
    public function itShouldBeDeleted()
    {
        $todoId = TodoId::generate();

        $start = (new DateTimeImmutable())->setTime(1, 1, 1);
        $end = (new DateTimeImmutable())->setTime(2, 2, 2);

        $interval = Interval::create(
            $start,
            $end
        );

        $newInterval = Interval::create(
            $start->add(new DateInterval('P1D')),
            $end->add(new DateInterval('P1D'))
        );

        $eventsHistory = new DomainEventsHistory(
            $todoId,
            [
                new TodoWasCreated(
                    EventId::generate(),
                    $todoId,
                    'Title 1234',
                    'Description 5678',
                    true,
                    $interval
                ),
                new TodoTitleWasChanged(EventId::generate(), $todoId, 'New Title'),
                new TodoDescriptionWasChanged(EventId::generate(), $todoId, 'New Description'),
                new TodoCompletedWasChanged(EventId::generate(), $todoId, false),
                new TodoIntervalWasChanged(EventId::generate(), $todoId, $newInterval),
            ]
        );

        $todo = Todo::reconstituteFromHistory($eventsHistory);

        $deletedAt = (new DateTimeImmutable())->setTime(3, 3, 3);

        $this->assertEquals(null, $todo->getDeletedAt());
        $todo->delete($deletedAt);
        $this->assertEquals($deletedAt, $todo->getDeletedAt());
    }

    /**
     * @test
     */
    public function itShouldBeReconstitutedFromHistory()
    {
        $todoId = TodoId::generate();

        $start = (new DateTimeImmutable())->setTime(1, 1, 1);
        $end = (new DateTimeImmutable())->setTime(2, 2, 2);

        $interval = Interval::create(
            $start,
            $end
        );

        $newInterval = Interval::create(
            $start->add(new DateInterval('P1D')),
            $end->add(new DateInterval('P1D'))
        );

        $eventsHistory = new DomainEventsHistory(
            $todoId,
            [
                new TodoWasCreated(
                    EventId::generate(),
                    $todoId,
                    'Title 1234',
                    'Description 5678',
                    true,
                    $interval
                ),
                new TodoTitleWasChanged(EventId::generate(), $todoId, 'New Title'),
                new TodoDescriptionWasChanged(EventId::generate(), $todoId, 'New Description'),
                new TodoCompletedWasChanged(EventId::generate(), $todoId, false),
                new TodoIntervalWasChanged(EventId::generate(), $todoId, $newInterval),
            ]
        );

        $todo = Todo::reconstituteFromHistory($eventsHistory);

        $this->assertEquals($todoId, $todo->getId());
        $this->assertEquals('New Title', $todo->getTitle());
        $this->assertEquals('New Description', $todo->getDescription());
        $this->assertEquals(false, $todo->isCompleted());
        $this->assertTrue($newInterval->equals($todo->getInterval()));
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
