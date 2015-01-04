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
 * LocalizationInterface
 */
interface LocalizationInterface
{
    /**
     * Sets language
     *
     * @param string
     */
    public function setLanguage($language);

    /**
     * Returns language
     *
     * @param string
     */
    public function getLanguage();


    /**
     * Adds a translation for a token. This token has to be used as value or label of a Field.
     *
     * @param string $token
     * @param string $value
     * @return LocalizationInterface
     */
    public function addString ($token, $value);

    /**
     * Adds a list of tokens and their localized values.
     *
     * @param array $strings
     * @return LocalizationInterface
     */
    public function addStrings (array $strings);

    /**
     * Returns the list of all added translations.
     *
     * @return string[]
     */
    public function getStrings();

    /**
     * Returns a formatted string in format:
     * "token1" = "value1";
     * "token2" = "value2";
     *
     * This format is required by the pass.strings file.
     *
     * @return string
     */
    public function getStringsFileOutput ();

    /**
     * {@inheritdoc}
     */
    public function addImage(ImageInterface $image);

    /**
     * {@inheritdoc}
     */
    public function getImages();
}
