<?php

namespace Invit\SeoBundle\Twig\Extension;

use Invit\SeoBundle\Seo\SeoPage;

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
            'invit_seo_title'      => new \Twig_Function_Method($this, 'renderTitle'),
            'invit_seo_h1'         => new \Twig_Function_Method($this, 'renderH1'),
            'invit_seo_metadatas'  => new \Twig_Function_Method($this, 'renderMetadatas'),
            'invit_seo_html_attributes'  => new \Twig_Function_Method($this, 'renderHtmlAttributes'),
            'invit_seo_link_tags'  => new \Twig_Function_Method($this, 'renderLinkTags')
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
            $parts[] = $metaTag->getHtml();
        }
        return implode("\n", $parts);
    }

    public function renderLinkTags(){
        $linkTagsHtml = array();
        foreach($this->page->getLinkTags() as $linkTag){
            $linkTagsHtml[] = $linkTag->getHtml();
        }
        return implode("\n", $linkTagsHtml);
    }

    /**
     * @return string
     */
    public function renderHtmlAttributes()
    {
        $parts = array();
        foreach ($this->page->getHtmlAttributes() as $name => $value) {
            $parts[] = sprintf('%s="%s"', $name, $value);
        }
        return implode(" ", $parts);
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