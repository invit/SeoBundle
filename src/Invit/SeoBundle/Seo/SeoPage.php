<?php
namespace Invit\SeoBundle\Seo;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Translation\TranslatorInterface;

/**
 *
 * http://en.wikipedia.org/wiki/Meta_element
 *
 */
class SeoPage implements SeoPageInterface
{
    protected $title;

    protected $mainTitle;

    protected $h1;

    protected $metas = array();

    protected $linkTags = array();

    protected $translator = null;

    protected $translationDomain = 'messages';

    /**
     * {@inheritdoc}
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function setTranslationDomain($domain){
        $this->translationDomain = $domain;
    }

    public function setTranslatableTitle($translationString){
        return $this->setTitle($this->translator->trans($translationString, array(), $this->translationDomain));
    }

    public function setMainTitle($mainTitle){
        $this->mainTitle = $mainTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return !empty($this->mainTitle) ? $this->title.' - '.$this->mainTitle : $this->title;
    }

    public function setH1($title)
    {
        $this->h1 = $title;
    }

    public function getH1()
    {
        return $this->h1;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetas()
    {
        return $this->metas;
    }

    public function addMetaTranslatableContent($type, $name, $translationContentString, array $extras = array()){
        return $this->addMeta($type, $name, $this->translator->trans($translationContentString, array(), $this->translationDomain), $extras);
    }

    /**
     * {@inheritdoc}
     */
    public function addMeta($type, $name, $content, array $extras = array())
    {
        $tag = new Tag('meta');
        $tag->addAttribute($type, $name);
        $tag->addAttribute('content', $content);
        $this->metas[$type.'_'.$name] = $tag;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTranslatableMetas(array $metadatas)
    {

        foreach ($metadatas as $type => $metas) {
            foreach ($metas as $name => $meta) {
                list($content, $extras) = $this->normalize($meta);
                $this->addMetaTranslatableContent($type, $name, $content, $extras);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setMetas(array $metadatas)
    {
        foreach ($metadatas as $type => $metas) {
            foreach ($metas as $name => $meta) {
                list($content, $extras) = $this->normalize($meta);

                $this->addMeta($type, $name, $content, $extras);
            }
        }

        return $this;
    }

    public function addLinkTag(TagInterface $linkTag){
        $this->linkTags[] = $linkTag;
    }

    public function getLinkTags(){
        return $this->linkTags;
    }

    public function addAlternateTag($language, $href)
    {
        $tag = new Tag('link');
        $tag->addAttribute('rel', 'alternate');
        $tag->addAttribute('hreflang', $language);
        $tag->addAttribute('href', $href);
        $this->linkTags[] = $tag;
    }

    public function addSimpleRelTag($href, $rel) {
        $tag = new Tag('link');
        $tag->addAttribute('rel', $rel);
        $tag->addAttribute('href', $href);
        $this->linkTags[] = $tag;
    }

    public function setCanonicalTag($href)
    {
        foreach ($this->linkTags as $tag) {
            if ($tag->getAttribute('rel') === 'canonical') {
                $tag->setAttribute('href', strtolower($href));
                return;
            }
        }

        $this->addSimpleRelTag($href, 'canonical');
    }

    public function addPrevTag($href)
    {
        $this->addSimpleRelTag($href, 'prev');
    }

    public function addNextTag($href)
    {
        $this->addSimpleRelTag($href, 'next');
    }

    private function normalize($meta)
    {
        if (is_string($meta)) {
            return array($meta, array());
        }

        return $meta;
    }
}