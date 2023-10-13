<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\ApprovalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KimaiPlugin\ApprovalBundle\Repository\ApprovalStatusRepository;

#[ORM\Table(name: 'kimai2_ext_approval_status')]
#[ORM\Entity(repositoryClass: ApprovalStatusRepository::class)]
class ApprovalStatus
{
    final public const SUBMITTED = 'submitted';
    final public const GRANTED = 'granted'; //WRONG - only for migration
    final public const DENIED = 'denied';
    final public const APPROVED = 'approved';
    final public const NOT_SUBMITTED = 'not_submitted';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'string', length: 255)]
    private $name;
    #[ORM\OneToMany(targetEntity: \KimaiPlugin\ApprovalBundle\Entity\ApprovalHistory::class, mappedBy: 'status')]
    private $history;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function setName(mixed $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getHistory()
    {
        return $this->history;
    }

    public function setHistory(mixed $history): void
    {
        $this->history = $history;
    }
}
