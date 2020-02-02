<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasLiquidated;
use CleaningCRM\Common\Domain\Projection;
use CleaningCRM\Todo\Domain\Todo\ClientWasCreated;
use CleaningCRM\Todo\Domain\Todo\Event\AddressWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\BankAccountWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\CompanyNameWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\RegNumberWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\VatNumberWasChanged;

interface ClientProjection extends Projection
{
    public function projectWhenAddressWasChanged (AddressWasChanged $event): void;

    public function projectWhenBankAccountWasChanged (BankAccountWasChanged $event): void;

    public function projectWhenClientWasCreated (ClientWasCreated $event): void;

    public function projectWhenClientWasLiquidated (ClientWasLiquidated $event): void;

    public function projectWhenCompanyNameWasChanged (CompanyNameWasChanged $event): void;

    public function projectWhenContactWasAdded (ContactWasAdded $event): void;

    public function projectWhenContactWasRemoved (ContactWasRemoved $event): void;

    public function projectWhenRegNumberWasChanged (RegNumberWasChanged $event): void;

    public function projectWhenVatNumberWasChanged (VatNumberWasChanged $event): void;
}
