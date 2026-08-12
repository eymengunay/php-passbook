<?php

namespace Passbook\Tests\Pass;

use Passbook\Pass\RelevantDate;
use PHPUnit\Framework\TestCase;

class RelevantDateTest extends TestCase
{
    public function testRelevantDate()
    {
        $relevantDate = new RelevantDate();
        $relevantDate
            ->setDate(new \DateTime('2026-06-10 14:00:00'))
            ->setEndDate(new \DateTime('2026-06-10 16:59:59'))
            ->setStartDate(new \DateTime('2026-06-10 14:00:00'))
        ;

        $this->assertEquals(new \DateTime('2026-06-10 14:00:00'), $relevantDate->getDate());
        $this->assertEquals(new \DateTime('2026-06-10 16:59:59'), $relevantDate->getEndDate());
        $this->assertEquals(new \DateTime('2026-06-10 14:00:00'), $relevantDate->getStartDate());

        $expected = [
            'date' => new \DateTime('2026-06-10 14:00:00'),
            'endDate' => new \DateTime('2026-06-10 16:59:59'),
            'startDate' => new \DateTime('2026-06-10 14:00:00')
        ];

        $this->assertEquals($expected, $relevantDate->toArray());
    }
}
