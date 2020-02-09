<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasCreated;
use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasLiquidated;
use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\AggregateRoot;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use CleaningCRM\Common\Domain\EventId;
use DateTimeImmutable;

final class Client extends AggregateRoot
{
    private ClientId $id;
    private string $companyName;
    private array $contacts;
    private Address $address;
    private string $vatNumber;
    private string $regNumber;
    private string $bankAccount;
    private ?DateTimeImmutable $liquidatedAt;

    private function __construct(
        ClientId $id,
        string $companyName,
        array $contacts,
        Address $address,
        string $vatNumber,
        string $regNumber,
        string $bankAccount,
        ?DateTimeImmutable $liquidatedAt = null
    ) {
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
    ): self {
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
            $newClient->bankAccount
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
            [],
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
        if (null !== $this->liquidatedAt) {
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

    public function addContact(ContactId $contactId, PersonId $personId, string $type): void
    {
        if ($this->hasContact($contactId)) {
            return;
        }

        $contactWasAdded = new ContactWasAdded(
            EventId::generate(),
            $this->id,
            $contactId,
            $personId,
            $type
        );

        $this->applyAndRecordThat($contactWasAdded);
        $this->notifyThat($contactWasAdded);
    }

    public function removeContact(ContactId $contactId): void
    {
        if ($this->hasContact($contactId)) {
            return;
        }

        $relatedContactWasRemoved = new ContactWasRemoved(
            EventId::generate(),
            $this->id,
            $contactId
        );

        $this->applyAndRecordThat($relatedContactWasRemoved);
        $this->notifyThat($relatedContactWasRemoved);
    }

    public function updateContactPerson(ContactId $contactId, PersonId $personId): void
    {
        if ($this->hasContact($contactId)) {
            return;
        }

        $contactPersonWasUpdated = new ContactPersonWasUpdated(
            EventId::generate(),
            $this->id,
            $contactId,
            $personId
        );

        $this->applyAndRecordThat($contactPersonWasUpdated);
        $this->notifyThat($contactPersonWasUpdated);
    }

    public function updateContactType(ContactId $contactId, string $type): void
    {
        if ($this->hasContact($contactId)) {
            return;
        }

        $contactTypeWasUpdated = new ContactTypeWasUpdated(
            EventId::generate(),
            $this->id,
            $contactId,
            $type
        );

        $this->applyAndRecordThat($contactTypeWasUpdated);
        $this->notifyThat($contactTypeWasUpdated);
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

    /**
     * @throws AssertionFailedException
     */
    protected function applyContactWasAdded(ContactWasAdded $event): void
    {
        $this->contacts[] = new Contact(
            $event->getContactId(),
            $event->getPersonId(),
            $event->getType()
        );
    }

    protected function applyContactWasRemoved(ContactWasRemoved $event): void
    {
        $this->contacts = array_filter(
            $this->contacts,
            fn (Contact $item) => $event->getContactId() !== $item->getContactId()
        );
    }

    protected function applyContactTypeWasUpdated(ContactTypeWasUpdated $event): void
    {
        $this->contacts = array_map(
            fn (Contact $item) => $event->getContactId()->equals($item->getContactId())
                ? $item->setType($event->getType())
                : $item,
            $this->contacts
        );
    }

    protected function applyContactPersonWasUpdated(ContactPersonWasUpdated $event): void
    {
        $this->contacts = array_map(
            fn (Contact $item) => $event->getPersonId()->equals($item->getPersonId())
                ? $item->setType($event->getPersonId())
                : $item,
            $this->contacts
        );
    }

    protected function applyRegNumberWasChanged(RegNumberWasChanged $event): void
    {
        $this->regNumber = $event->getRegNumber();
    }

    protected function applyVatNumberWasChanged(VatNumberWasChanged $event): void
    {
        $this->vatNumber = $event->getVatNumber();
    }

    private function hasContact(ContactId $contactId): bool
    {
        /** @var Contact $contact */
        foreach ($this->contacts as $contact) {
            if ($contact->getContactId()->equals($contactId)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory): self
    {
        $client = self::createEmptyTodoWithId(
            ClientId::fromString(
                (string) $eventsHistory->getAggregateId()
            )
        );

        foreach ($eventsHistory as $event) {
            $client->apply($event);
        }

        return $client;
    }
}
