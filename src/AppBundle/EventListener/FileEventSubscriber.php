<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\EventSubscriber;
use Doctrine\Orm\Event\LifecycleEventArgs;
use AppBundle\Entity\Listing;
use AppBundle\Services\FileUploader;

class FileEventSubscriber implements EventSubscriber
{
    private $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate'
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->handle($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->handle($args);
    }

    public function handle(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Listener) {
            return;
        }

        if ($entity->getImage() instanceof UploadedFile) {
            $image = $entity->getImage();

            $filename = $this->fileUploader->upload($image);

            $entity->setImage($filename);
        }
    }
}
