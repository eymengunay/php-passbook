<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Pass;

/**
 * Relevant Dates
 *
 * @author Christian Freear <https://github.com/cfreear>
 */
class RelevantDate implements RelevantDateInterface
{
    /**
     * Relevant date and time.
     * @var \DateTime
     */
    protected $date;

    /**
     * End of the pass relevancy interval.
     * @var \DateTime
     */
    protected $endDate;

    /**
     * Start of the pass relevancy interval.
     * @var \DateTime
     */
    protected $startDate;

    public function toArray()
    {
        $array = [
            'date' => $this->getDate(),
            'endDate' => $this->getEndDate(),
            'startDate' => $this->getStartDate()
        ];

        if ($date = $this->getDate()) {
            $array['date'] = $date;
        }

        if ($endDate = $this->getEndDate()) {
            $array['endDate'] = $endDate;
        }

        if ($startDate = $this->getStartDate()) {
            $array['startDate'] = $startDate;
        }

        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate()
    {
        return $this->startDate;
    }
}
