<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\ApprovalBundle\Enumeration;

abstract class FormEnum
{
    final public const SUBMIT = 'submit';

    final public const MONDAY = 'monday';
    final public const TUESDAY = 'tuesday';
    final public const WEDNESDAY = 'wednesday';
    final public const THURSDAY = 'thursday';
    final public const FRIDAY = 'friday';
    final public const SATURDAY = 'saturday';
    final public const SUNDAY = 'sunday';
    final public const CUSTOMER_FOR_FREE_DAYS = 'customer_for_free_days';
    final public const EMAIL_LINK_URL = 'email_link_url';
    final public const WORKFLOW_START = 'workflow_start';
    final public const OVERTIME_NY = 'approval_overtime_ny';
    final public const BREAKCHECKS_NY = 'approval_breakchecks_ny';
}
