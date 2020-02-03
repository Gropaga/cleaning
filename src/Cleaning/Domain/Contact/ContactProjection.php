<?php

namespace CleaningCRM\Cleaning\Domain\Contact;

use CleaningCRM\Cleaning\Domain\Contact\Event\ContactAddressWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactDeletedAtWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactEmailWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactNameWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactPhoneWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactTypeWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactWasCreated;
use CleaningCRM\Common\Domain\Projection;

interface ContactProjection extends Projection
{
    public function projectWhenContactAddressWasChanged(ContactAddressWasChanged $event): void;

    public function projectWhenContactDeletedAtWasChanged(ContactDeletedAtWasChanged $event): void;

    public function projectWhenContactEmailWasChanged(ContactEmailWasChanged $event): void;

    public function projectWhenContactNameWasChanged(ContactNameWasChanged $event): void;

    public function projectWhenContactPhoneWasChanged(ContactPhoneWasChanged $event): void;

    public function projectWhenContactTypeWasChanged(ContactTypeWasChanged $event): void;

    public function projectWhenContactWasCreated(ContactWasCreated $event): void;
}
