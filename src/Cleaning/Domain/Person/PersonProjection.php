<?php

namespace CleaningCRM\Cleaning\Domain\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\AddressWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasCreated;
use CleaningCRM\Cleaning\Domain\Person\Event\EmailWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\NameWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasDeleted;
use CleaningCRM\Cleaning\Domain\Person\Event\PhoneWasChanged;
use CleaningCRM\Common\Domain\Projection;

interface PersonProjection extends Projection
{
    public function projectWhenPersonAddressWasChanged(AddressWasChanged $event): void;

    public function projectWhenPersonDeletedAtWasChanged(PersonWasDeleted $event): void;

    public function projectWhenPersonEmailWasChanged(EmailWasChanged $event): void;

    public function projectWhenPersonNameWasChanged(NameWasChanged $event): void;

    public function projectWhenPersonPhoneWasChanged(PhoneWasChanged $event): void;

    public function projectWhenPersonWasCreated(PersonWasCreated $event): void;
}
