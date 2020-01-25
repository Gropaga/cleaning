<?php

namespace CleaningCRM\Cleaning\Domain\Contact;

use MyCLabs\Enum\Enum;

/**
 * @method static Type CONTACT_PERSON()
 * @method static Type LEGAL_CONTACT()
 */
class Type extends Enum
{
    private const CONTACT_PERSON = 'contact_person';
    private const LEGAL_CONTACT = 'legal_contact';
}
