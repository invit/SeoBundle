<?php

namespace Invit\SeoBundle\Twig\Extension;

use Invit\SeoBundle\Seo\SeoPage;
use Invit\SeoBundle\Seo\Tag;
use Twig_SimpleFunction;

class SeoExtension extends \Twig_Extension
{
    protected $page;

    protected $encoding;

    /**
     * @param SeoPageInterface $page
     * @param $encoding
     */
    public function __construct(SeoPage $page, $encoding)
    {
        $this->page = $page;
        $this->encoding = $encoding;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('invit_seo_title', array($this, 'renderTitle')),
            new Twig_SimpleFunction('invit_seo_h1', array($this, 'renderH1')),
            new Twig_SimpleFunction('invit_seo_metadatas', array($this, 'renderMetadatas')),
            new Twig_SimpleFunction('invit_seo_link_tags', array($this, 'renderLinkTags')),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'sonata_seo';
    }

    /**
     * @return string
     */
    public function renderTitle()
    {
        return sprintf("<title>%s</title>", strip_tags($this->page->getTitle()));
    }

    public function renderH1()
    {
        if (strlen($this->page->getH1()) > 0)
            return $this->page->getH1();
        else
            return '';
    }

    /**
     * @return string
     */
    public function renderMetadatas()
    {
        $parts = array();
        foreach ($this->page->getMetas() as $metaTag) {
            $parts[] = $this->getHtmlFromTag($metaTag);
        }
        return implode("\n", $parts);
    }

    public function renderLinkTags(){
        $linkTagsHtml = array();
        foreach($this->page->getLinkTags() as $linkTag){
            $linkTagsHtml[] = $this->getHtmlFromTag($linkTag);
        }
        return implode("\n", $linkTagsHtml);
    }

    public function getHtmlFromTag(Tag $tag){
        $htmlAttributes = array();
        foreach($tag->getAttributes() as $attribute => $value){
            $htmlAttributes[] = sprintf('%s="%s"', $attribute, $this->normalize($value));
        }

        return sprintf("<%s %s>",
            $tag->getTagName(),
            implode(' ', $htmlAttributes)
        );
    }

    /**
     * @param $string
     * @return mixed
     */
    private function normalize($string)
    {
        return htmlentities(strip_tags($string), ENT_COMPAT, $this->encoding);
    }
}