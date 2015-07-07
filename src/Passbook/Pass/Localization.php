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
 * Localization
 */
class Localization implements LocalizationInterface
{
    /**
     * Language of the localization
     * @var string
     */
    protected $language;

    /**
     * Localized images
     * @var array
     */
    protected $images = array();

    /**
     * Localized texts (token=>value)
     * @var array
     */
    protected $strings = array();

    public function __construct($language)
    {
        $this->setLanguage($language);
    }

    /**
     * {@inheritdoc}
     */
    public function setLanguage ( $language )
    {
        $this->language = $language;
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguage ()
    {
        return $this->language;
    }

    /**
     * {@inheritdoc}
     */
    public function addString ( $token , $value )
    {
        $this->strings[$token] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addStrings ( array $strings )
    {
        $this->strings = array_merge(  $this->strings  , $strings );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStrings ()
    {
       return $this->strings;
    }

    /**
     * {@inheritdoc}
     */
    public function getStringsFileOutput ()
    {
        $output = '';
        foreach ( $this->strings as $token=>$value )
        {
            $output .= '"'.$token.'" = "'.$value.'";'.PHP_EOL;
        }
        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function addImage(ImageInterface $image)
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