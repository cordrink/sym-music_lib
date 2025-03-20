<?php

namespace App\Subscriber;

use App\Entity\Style;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class LifecycleStyleSubscriber implements EventSubscriberInterface
{

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
            Events::prePersist,
        ];
    }

    public function preUpdate(LifecycleEventArgs $args): void {
        $entity = $args->getObject();
        if (!$entity instanceof Style) {
            return;
        }
        //dump("LifecycleStyleSubscriber");
//        $entity->changeUpdateValue(new \DateTime());
    }
}