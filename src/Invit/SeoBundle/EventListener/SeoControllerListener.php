<?php

namespace Invit\SeoBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class SeoControllerListener {

    private $seoPage;
    private $title;
    private $translatableMetas;
    private $metas;

    public function __construct($seoPage, $title, $translatableMetas, $metas)
    {
        $this->seoPage = $seoPage;
        $this->title = $title;
        $this->translatableMetas = $translatableMetas;
        $this->metas = $metas;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if($event->isMasterRequest()) {
            $this->seoPage->setTranslatableTitle($this->title);
            $this->seoPage->setMetas($this->metas);
            $this->seoPage->setTranslatableMetas($this->translatableMetas);
        }
    }
}
