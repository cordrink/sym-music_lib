<?php

namespace App\Listener;

use App\Entity\Style;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class LifecycleStyleListener
{
    public function preUpdate(LifecycleEventArgs $args): void {
        $entity = $args->getObject();
        if (!$entity instanceof Style) {
            return;
        }
        //dd("LifecycleStyleListener");
        //$entity->changeUpdateValue();
    }
}