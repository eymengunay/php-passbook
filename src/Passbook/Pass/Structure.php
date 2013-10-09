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

use JMS\Serializer\Annotation\SerializedName;

/**
 * Pass Structure
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class Structure implements StructureInterface
{
    /**
     * Fields to be displayed in the header on the front of the pass.
     * @SerializedName(value="headerFields")
     * @var array
     */
    public $headerFields;

    /**
     * Fields to be displayed prominently on the front of the pass.
     * @SerializedName(value="primaryFields")
     * @var array
     */
    public $primaryFields;

    /**
     * Fields to be displayed on the front of the pass.
     * @SerializedName(value="secondaryFields")
     * @var array
     */
    public $secondaryFields;

    /**
     * Additional fields to be displayed on the front of the pass.
     * @SerializedName(value="auxiliaryFields")
     * @var array
     */
    public $auxiliaryFields;

    /**
     * Fields to be on the back of the pass.
     * @SerializedName(value="backFields")
     * @var array
     */
    public $backFields;

    /**
     * {@inheritdoc}
     */
    public function addHeaderField(FieldInterface $headerField)
    {
        $this->headerFields[] = $headerField;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderFields()
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
     * {@inheritdoc}
     */
    public function getPrimaryFields()
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
     * {@inheritdoc}
     */
    public function getSecondaryFields()
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
     * {@inheritdoc}
     */
    public function getAuxiliaryFields()
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
     * {@inheritdoc}
     */
    public function getBackFields()
    {
        return $this->backFields;
    }
}