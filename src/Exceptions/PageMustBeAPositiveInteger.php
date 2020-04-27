<?php

declare(strict_types=1);

namespace Ardiakov\Pagination\Exceptions;

use Exception;

/**
 * Class PageIsOutOfRange.
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
class PageMustBeAPositiveInteger extends Exception
{
    protected $message = 'Page must be a positive integer';
}
