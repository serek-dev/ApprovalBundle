<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\ApprovalBundle\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use KimaiPlugin\ApprovalBundle\Repository\ApprovalRepository;

#[ORM\Table(name: 'kimai2_ext_approval')]
#[ORM\Entity(repositoryClass: ApprovalRepository::class)]
class Approval
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\ManyToOne(targetEntity: \App\Entity\User::class)]
    #[ORM\JoinColumn(onDelete: 'CASCADE', nullable: false)]
    private ?\App\Entity\User $user = null;
    #[ORM\Column(type: 'date')]
    private $startDate;
    #[ORM\Column(type: 'date')]
    private $endDate;
    #[ORM\Column(type: 'integer')]
    private $expectedDuration;
    #[ORM\Column(type: 'integer')]
    private $actualDuration;
    #[ORM\Column(type: 'datetime')]
    private $creationDate;
    #[ORM\OneToMany(targetEntity: \KimaiPlugin\ApprovalBundle\Entity\ApprovalHistory::class, mappedBy: 'approval')]
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate(mixed $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate(mixed $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getExpectedDuration()
    {
        return $this->expectedDuration;
    }

    public function setExpectedDuration(mixed $expectedDuration): void
    {
        $this->expectedDuration = $expectedDuration;
    }

    /**
     * @return mixed
     */
    public function getActualDuration()
    {
        return $this->actualDuration;
    }

    /**
     * @param mixed $expectedDuration
     */
    public function setActualDuration($actualDuration): void
    {
        $this->actualDuration = $actualDuration;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate(mixed $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getHistory()
    {
        $history = $this->history;

        return \gettype($history) === 'object' ? $history->toArray() : $history;
    }

    public function setHistory(mixed $history): void
    {
        $this->history = $history;
    }
}
