<?php

declare(strict_types=1);

namespace Ardiakov\Pagination\Exceptions;

use Exception;

/**
 * Class PageIsOutOfRange.
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
class PageIsOutOfRange extends Exception
{
    protected $message = 'Page is out of range';
}
