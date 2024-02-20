<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Apple;

use Passbook\ArrayableInterface;

/**
 * Pass Structure
 *
 * @author Eymen Gunay <eymen@egunay.com>
 * @see https://developer.apple.com/documentation/walletpasses/passfields
 */
class PassFields implements ArrayableInterface
{
    /**
     * Fields to be displayed in the header on the front of the pass.
     * @var FieldInterface[]
     */
    public array $headerFields = [];

    /**
     * Fields to be displayed prominently on the front of the pass.
     * @var FieldInterface[]
     */
    public array $primaryFields = [];

    /**
     * Fields to be displayed on the front of the pass.
     * @var FieldInterface[]
     */
    public array $secondaryFields = [];

    /**
     * Additional fields to be displayed on the front of the pass.
     * @var FieldInterface[]
     */
    public array $auxiliaryFields = [];

    /**
     * Fields to be on the back of the pass.
     * @var FieldInterface[]
     */
    public array $backFields = [];

    public function toArray()
    {
        $array = [];

        foreach ($this->getHeaderFields() as $headerField) {
            $array['headerFields'][] = $headerField->toArray();
        }

        foreach ($this->getPrimaryFields() as $primaryField) {
            $array['primaryFields'][] = $primaryField->toArray();
        }

        foreach ($this->getSecondaryFields() as $secondaryField) {
            $array['secondaryFields'][] = $secondaryField->toArray();
        }

        foreach ($this->getAuxiliaryFields() as $auxiliaryField) {
            $array['auxiliaryFields'][] = $auxiliaryField->toArray();
        }

        foreach ($this->getBackFields() as $backField) {
            $array['backFields'][] = $backField->toArray();
        }

        return empty($array) ? (object)null : $array;
    }

    /**
     * {@inheritdoc}
     */
    public function addHeaderField(FieldInterface $headerField)
    {
        $this->headerFields[] = $headerField;

        return $this;
    }

    /**
     * @return FieldInterface[]
     */
    public function getHeaderFields(): array
    {
        return $this->headerFields;
    }

    /**
     * {@inheritdoc}
     */
    public function addPrimaryField(FieldInterface $primaryField)
    {
        $this->primaryFields[] = $primaryField;

        return $this;
    }

    /**
     * @return FieldInterface[]
     */
    public function getPrimaryFields(): array
    {
        return $this->primaryFields;
    }

    /**
     * {@inheritdoc}
     */
    public function addSecondaryField(FieldInterface $secondaryField)
    {
        $this->secondaryFields[] = $secondaryField;

        return $this;
    }

    /**
     * @return FieldInterface[]
     */
    public function getSecondaryFields(): array
    {
        return $this->secondaryFields;
    }

    /**
     * {@inheritdoc}
     */
    public function addAuxiliaryField(FieldInterface $auxiliaryField)
    {
        $this->auxiliaryFields[] = $auxiliaryField;

        return $this;
    }

    /**
     * @return FieldInterface[]
     */
    public function getAuxiliaryFields(): array
    {
        return $this->auxiliaryFields;
    }

    /**
     * {@inheritdoc}
     */
    public function addBackField(FieldInterface $backField)
    {
        $this->backFields[] = $backField;

        return $this;
    }

    /**
     * @return FieldInterface[]
     */
    public function getBackFields(): array
    {
        return $this->backFields;
    }
}
