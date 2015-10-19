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

use Passbook\ArrayableInterface;

/**
 * StructureInterface
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
interface StructureInterface extends ArrayableInterface
{
    /**
     * Adds header field
     *
     * @param Field
     */
    public function addHeaderField(FieldInterface $headerField);

    /**
     * Returns header fields
     *
     * @return FieldInterface[]
     */
    public function getHeaderFields();

    /**
     * Adds primary field
     *
     * @param Field
     */
    public function addPrimaryField(FieldInterface $primaryField);

    /**
     * Returns primary fields
     *
     * @return FieldInterface[]
     */
    public function getPrimaryFields();

    /**
     * Adds secondary field
     *
     * @param Field
     */
    public function addSecondaryField(FieldInterface $secondaryField);

    /**
     * Returns secondary fields
     *
     * @return FieldInterface[]
     */
    public function getSecondaryFields();

    /**
     * Adds auxiliary field
     *
     * @param Field
     */
    public function addAuxiliaryField(FieldInterface $auxiliaryField);

    /**
     * Returns auxiliary fields
     *
     * @return FieldInterface[]
     */
    public function getAuxiliaryFields();

    /**
     * Adds back field
     *
     * @param Field
     */
    public function addBackField(FieldInterface $backField);

    /**
     * Returns back fields
     *
     * @return FieldInterface[]
     */
    public function getBackFields();
}
