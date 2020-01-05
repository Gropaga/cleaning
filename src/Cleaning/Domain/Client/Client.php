<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use Assert\AssertionFailedException;
use CleaningCRM\Common\Domain\AggregateRoot;
use CleaningCRM\Common\Domain\Contact;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use CleaningCRM\Todo\Domain\Todo\ClientWasCreated;
use DateTimeImmutable;

final class Client extends AggregateRoot
{
    private $id;
    private $contact;
    private $business;
    private $deletedAt;

    private function __construct(
        ClientId $id,
        Contact $contact,
        Business $business,
        ?DateTimeImmutable $deletedAt = null
    )
    {
        $this->id = $id;
        $this->contact = $contact;
        $this->business = $business;
        $this->deletedAt = $deletedAt;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function createEmptyClientWithId(ClientId $id): self
    {
        return new self($id, Contact::createEmpty(), Business::createEmpty());
    }

    public function updateContact(Contact $contact): void
    {
        if ($contact->equals($this->contact)) {
            return;
        }

        $this->applyAndRecordThat(new ContactWasChanged(
            $this->id,
            $contact
        ));
    }

    public function updateBusiness(Business $business): void
    {
        if ($business->equals($this->business)) {
            return;
        }

        $this->applyAndRecordThat(new BusinessWasChanged(
            $this->id,
            $business
        ));
    }

    public function delete(): void
    {
        $this->applyAndRecordThat(new ClientDeletedAtWasChanged(
            $this->id,
            new DateTimeImmutable()
        ));
    }

    public function getId(): ClientId
    {
        return $this->id;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function getBusiness(): Business
    {
        return $this->business;
    }

    public function getDeleteAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public static function create(ClientId $id, Contact $contact, Business $business, ?DateTimeImmutable $deletedAt = null): self
    {
        $newClient = new Client(
            $id,
            $contact,
            $business,
            $deletedAt
        );

        $newClient->recordThat(new ClientWasCreated(
            $newClient->id,
            $newClient->getContact(),
            $newClient->getBusiness()
        ));

        return $newClient;
    }

    public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory): self
    {
        $client = self::createEmptyClientWithId($eventsHistory->getAggregateId());

        foreach ($eventsHistory as $event) {
            $client->apply($event);
        }

        return $client;
    }
}
