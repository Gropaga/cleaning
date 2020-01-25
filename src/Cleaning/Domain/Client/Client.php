<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasLiquidated;
use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\AggregateRoot;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Person;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use CleaningCRM\Todo\Domain\Todo\ClientWasCreated;
use CleaningCRM\Todo\Domain\Todo\Event\AddressWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\BankAccountWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\CompanyNameWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\RegNumberWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\VatNumberWasChanged;
use DateTimeImmutable;

final class Client extends AggregateRoot
{
    private $id;
    private $companyName;
    private $contacts;
    private $address;
    private $vatNumber;
    private $regNumber;
    private $bankAccount;
    private $liquidatedAt;

    private function __construct(
        ClientId $id,
        string $companyName,
        array $contacts,
        Address $address,
        string $vatNumber,
        string $regNumber,
        string $bankAccount,
        ?DateTimeImmutable $liquidatedAt = null
    )
    {
        $this->id = $id;
        $this->companyName = $companyName;
        $this->contacts = $contacts;
        $this->address = $address;
        $this->vatNumber = $vatNumber;
        $this->regNumber = $regNumber;
        $this->bankAccount = $bankAccount;
        $this->liquidatedAt = $liquidatedAt;
    }

    public function getId(): ClientId
    {
        return $this->id;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getContacts(): array
    {
        return $this->contacts;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }

    public function getRegNumber(): string
    {
        return $this->regNumber;
    }

    public function getBankAccount(): string
    {
        return $this->bankAccount;
    }

    public function getLiquidatedAt(): ?DateTimeImmutable
    {
        return $this->liquidatedAt;
    }

    public static function create(
        ClientId $id,
        string $companyName,
        array $contacts,
        Address $address,
        string $vatNumber,
        string $regNumber,
        string $bankAccount,
        DateTimeImmutable $liquidatedAt
    ): self
    {
        $newClient = new Client(
            $id,
            $companyName,
            $contacts,
            $address,
            $vatNumber,
            $regNumber,
            $bankAccount,
            $liquidatedAt
        );

        $clientWasCreated = new ClientWasCreated(
            EventId::generate(),
            $newClient->id,
            $newClient->companyName,
            $newClient->contacts,
            $newClient->address,
            $newClient->vatNumber,
            $newClient->regNumber,
            $newClient->bankAccount,
            $newClient->liquidatedAt
        );

        $newClient->recordThat($clientWasCreated);
        $newClient->notifyThat($clientWasCreated);

        return $newClient;
    }

    public static function createEmptyTodoWithId(ClientId $id): self
    {
        return new self(
            $id,
            '',
            [],
            Address::create('', '', '' , ''),
            '',
            '',
            '',
            null
        );
    }

    public function changeCompanyName(string $companyName): void
    {
        if ($companyName === $this->companyName) {
            return;
        }

        $companyNameWasChanged = new CompanyNameWasChanged(
            EventId::generate(),
            $this->id,
            $companyName
        );

        $this->applyAndRecordThat($companyNameWasChanged);
        $this->notifyThat($companyNameWasChanged);
    }

    public function changeAddress(Address $address): void
    {
        if ($address->equals($this->address)) {
            return;
        }

        $addressWasChanged = new AddressWasChanged(
            EventId::generate(),
            $this->id,
            $address
        );

        $this->applyAndRecordThat($addressWasChanged);
        $this->notifyThat($addressWasChanged);
    }

    public function changeVatNumber(string $vatNumber): void
    {
        if ($vatNumber === $this->vatNumber) {
            return;
        }

        $vatNumberWasChanged = new VatNumberWasChanged(
            EventId::generate(),
            $this->id,
            $vatNumber
        );

        $this->applyAndRecordThat($vatNumberWasChanged);
        $this->notifyThat($vatNumberWasChanged);
    }

    public function changeRegNumber(string $regNumber): void
    {
        if ($regNumber === $this->regNumber) {
            return;
        }

        $regNumberWasChanged = new RegNumberWasChanged(
            EventId::generate(),
            $this->id,
            $regNumber
        );

        $this->applyAndRecordThat($regNumberWasChanged);
        $this->notifyThat($regNumberWasChanged);
    }


    public function changeBankAccount(string $bankAccount): void
    {
        if ($bankAccount === $this->bankAccount) {
            return;
        }

        $bankAccountWasChanged = new BankAccountWasChanged(
            EventId::generate(),
            $this->id,
            $bankAccount
        );

        $this->applyAndRecordThat($bankAccountWasChanged);
        $this->notifyThat($bankAccountWasChanged);
    }

    public function liquidate(DateTimeImmutable $liquidatedAt): void
    {

        if ($this->liquidatedAt !== null) {
            return;
        }

        $clientWasLiquidated = new ClientWasLiquidated(
            EventId::generate(),
            $this->id,
            $liquidatedAt
        );

        $this->applyAndRecordThat($clientWasLiquidated);
        $this->notifyThat($clientWasLiquidated);
    }

    public function addContact(ContactId $contactId): void
    {
        if (in_array($contactId, $this->contacts, false)) {
            return;
        }

        $contactWasAdded = new ContactWasAdded(
            EventId::generate(),
            $this->id,
            $contactId
        );

        $this->applyAndRecordThat($contactWasAdded);
        $this->notifyThat($contactWasAdded);
    }

    public function removeContact(ContactId $contactId): void
    {
        if (! in_array($contactId, $this->contacts, false)) {
            return;
        }

        $contactWasRemoved = new ContactWasRemoved(
            EventId::generate(),
            $this->id,
            $contactId
        );

        $this->applyAndRecordThat($contactWasRemoved);
        $this->notifyThat($contactWasRemoved);
    }

    protected function applyAddressWasChanged(AddressWasChanged $event): void
    {
        $this->address = $event->getAddress();
    }

    protected function applyBankAccountWasChanged(BankAccountWasChanged $event): void
    {
        $this->bankAccount = $event->getBankAccount();
    }

    protected function applyClientWasCreated(ClientWasCreated $event): void
    {
        $this->companyName = $event->getCompanyName();
        $this->contacts = $event->getContacts();
        $this->address = $event->getAddress();
        $this->vatNumber = $event->getVatNumber();
        $this->regNumber = $event->getRegNumber();
        $this->bankAccount = $event->getBankAccount();
        $this->liquidatedAt = $event->getLiquidatedAt();
    }

    protected function applyClientWasLiquidated(ClientWasLiquidated $event): void
    {
        $this->liquidatedAt = $event->getLiquidatedAt();
    }

    protected function applyCompanyNameWasChanged(CompanyNameWasChanged $event): void
    {
        $this->companyName = $event->getCompanyName();
    }

    protected function applyContactWasAdded(ContactWasAdded $event): void
    {
        $this->contacts[] = $event->getContactId();
    }

    protected function applyContactWasRemoved(ContactWasRemoved $contactWasRemoved): void
    {
        $removedContact = $contactWasRemoved->getContactId();

        $this->contacts = array_filter($this->contacts, static function($contact) use ($removedContact) {
            return $contact !== $removedContact;
        });
    }

    protected function applyRegNumberWasChanged(RegNumberWasChanged $event): void
    {
        $this->regNumber = $event->getRegNumber();
    }

    protected function applyVatNumberWasChanged(VatNumberWasChanged $event): void
    {
        $this->vatNumber = $event->getVatNumber();
    }

    public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory): self
    {
        $todo = self::createEmptyTodoWithId(
            ClientId::fromString(
                (string) $eventsHistory->getAggregateId()
            )
        );

        foreach ($eventsHistory as $event) {
            $todo->apply($event);
        }

        return $todo;
    }
}
