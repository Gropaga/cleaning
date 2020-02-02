<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasLiquidated;
use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Cleaning\Domain\Contact\RelatedContacts;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\AggregateRoot;
use CleaningCRM\Common\Domain\EventId;
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
    private $relatedContacts;
    private $address;
    private $vatNumber;
    private $regNumber;
    private $bankAccount;
    private $liquidatedAt;

    private function __construct(
        ClientId $id,
        string $companyName,
        RelatedContacts $contacts,
        Address $address,
        string $vatNumber,
        string $regNumber,
        string $bankAccount,
        ?DateTimeImmutable $liquidatedAt = null
    ) {
        $this->id = $id;
        $this->companyName = $companyName;
        $this->relatedContacts = $contacts;
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

    public function getRelatedContacts(): RelatedContacts
    {
        return $this->relatedContacts;
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
        RelatedContacts $contacts,
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
            $newClient->relatedContacts,
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

    /**
     * @throws AssertionFailedException
     */
    public static function createEmptyTodoWithId(ClientId $id): self
    {
        return new self(
            $id,
            '',
            RelatedContacts::createEmpty(),
            Address::createEmpty(),
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

    public function addContact(RelatedContact $relatedContact): void
    {
        if ($this->relatedContacts->includes($relatedContact)) {
            return;
        }

        $contactWasAdded = new ContactWasAdded(
            EventId::generate(),
            $this->id,
            $relatedContact
        );

        $this->applyAndRecordThat($contactWasAdded);
        $this->notifyThat($contactWasAdded);
    }

    public function removeContact(RelatedContact $relatedContact): void
    {
        if (! $this->relatedContacts->includes($relatedContact)) {
            return;
        }

        $contactWasRemoved = new ContactWasRemoved(
            EventId::generate(),
            $this->id,
            $relatedContact
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
        $this->relatedContacts = $event->getContacts();
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

    /**
     * @throws AssertionFailedException
     */
    protected function applyContactWasAdded(ContactWasAdded $event): void
    {
        $this->relatedContacts = $this->relatedContacts->append($event->getRelatedContact());
    }

    /**
     * @throws AssertionFailedException
     */
    protected function applyContactWasRemoved(ContactWasRemoved $contactWasRemoved): void
    {
        $this->relatedContacts = $this->relatedContacts->remove($contactWasRemoved->getRelatedContact());
    }

    protected function applyRegNumberWasChanged(RegNumberWasChanged $event): void
    {
        $this->regNumber = $event->getRegNumber();
    }

    protected function applyVatNumberWasChanged(VatNumberWasChanged $event): void
    {
        $this->vatNumber = $event->getVatNumber();
    }

    /**
     * @throws AssertionFailedException
     */
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
