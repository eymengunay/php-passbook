<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Subscriber;

use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;

class PassEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.pre_serialize', 'method' => 'onPreSerialize'),
            array('event' => 'serializer.post_serialize', 'method' => 'onPostSerialize'),
        );
    }

    public function onPreSerialize(PreSerializeEvent $event)
    {
        // Do not serialize null
        $context = $event->getContext();
        $context->setSerializeNull(false);
    }

    public function onPostSerialize(ObjectEvent $event)
    {
        $object = $event->getObject();

        foreach (get_object_vars($object) as $key => $var) {
            echo '==================';
            echo PHP_EOL;
            var_dump($key);
            echo PHP_EOL;
            echo PHP_EOL;
            var_dump($var);
            echo PHP_EOL;
            echo PHP_EOL;
            echo '==================';
            if (is_array($var) && empty($var)) $object->$key = null;
        }
    }
}