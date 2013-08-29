<?php
namespace Invit\SeoBundle\Seo;

class Tag implements TagInterface
{
    private $tagName;
    private $attributes = array();

    public function __construct($tagName){
        $this->tagName = $tagName;
    }

    function setTagName($tagName){
        $this->tagName = $tagName;
    }

    public function addAttribute($attribute, $value){
        $this->attributes[$attribute] = $value;
    }
    public function getAttributes(){
        return $this->attributes;
    }

    public function getHtml(){
        $htmlAttributes = array();
        foreach($this->getAttributes() as $attribute => $value){
            $htmlAttributes[] = sprintf('%s="%s"', $attribute, $value);
        }

        return sprintf("<%s %s />",
            $this->tagName,
            implode(' ', $htmlAttributes)
        );
    }
}
