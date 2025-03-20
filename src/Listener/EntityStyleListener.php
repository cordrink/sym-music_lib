<?php

namespace App\Listener;

use App\Entity\Style;

use Doctrine\Persistence\Event\LifecycleEventArgs;

class EntityStyleListener {
    public function preUpdate(Style $style, LifecycleEventArgs $eventArgs): void
    {
        dump("LifecycleStyleListener");
        $style->setUpdatedAt(new \DateTimeImmutable());
    }
}