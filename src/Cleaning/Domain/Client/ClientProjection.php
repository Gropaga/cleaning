<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\AddressWasChanged;
use CleaningCRM\Cleaning\Domain\Client\Event\BankAccountWasChanged;
use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasCreated;
use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasLiquidated;
use CleaningCRM\Cleaning\Domain\Client\Event\CompanyNameWasChanged;
use CleaningCRM\Cleaning\Domain\Client\Event\ContactWasAdded;
use CleaningCRM\Cleaning\Domain\Client\Event\ContactWasRemoved;
use CleaningCRM\Cleaning\Domain\Client\Event\RegNumberWasChanged;
use CleaningCRM\Cleaning\Domain\Client\Event\VatNumberWasChanged;
use CleaningCRM\Cleaning\Domain\Shared\Projection;

interface ClientProjection extends Projection
{
    public function projectWhenAddressWasChanged(AddressWasChanged $event): void;

    public function projectWhenBankAccountWasChanged(BankAccountWasChanged $event): void;

    public function projectWhenClientWasCreated(ClientWasCreated $event): void;

    public function projectWhenClientWasLiquidated(ClientWasLiquidated $event): void;

    public function projectWhenCompanyNameWasChanged(CompanyNameWasChanged $event): void;

    public function projectWhenContactWasAdded(ContactWasAdded $event): void;

    public function projectWhenContactWasRemoved(ContactWasRemoved $event): void;

    public function projectWhenContactPersonWasUpdated(ContactWasRemoved $event): void;

    public function projectWhenContactTypeWasUpdated(ContactWasRemoved $event): void;

    public function projectWhenRegNumberWasChanged(RegNumberWasChanged $event): void;

    public function projectWhenVatNumberWasChanged(VatNumberWasChanged $event): void;
}
