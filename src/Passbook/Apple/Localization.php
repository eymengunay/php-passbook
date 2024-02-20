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

/**
 * Localization
 */
class Localization implements LocalizationInterface
{
    /**
     * Language of the localization
     */
    protected string $language;

    /**
     * Localized images
     *
     * @var ImageInterface[]
     */
    protected array $images = [];

    /**
     * Localized texts (token=>value)
     *
     * @var string[]
     */
    protected array $strings = [];

    public function __construct($language)
    {
        $this->setLanguage($language);
    }

    /**
     * {@inheritdoc}
     */
    public function setLanguage($language): void
    {
        $this->language = $language;
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * {@inheritdoc}
     */
    public function addString($token, $value)
    {
        $this->strings[$token] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addStrings(array $strings)
    {
        $this->strings = array_merge($this->strings, $strings);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStrings()
    {
        return $this->strings;
    }

    /**
     * {@inheritdoc}
     */
    public function getStringsFileOutput()
    {
        $output = '';
        foreach ($this->strings as $token => $value) {
            $output .= '"' . addslashes($token) . '" = "' . addslashes($value) . '";' . PHP_EOL;
        }

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return $this->images;
    }
}
