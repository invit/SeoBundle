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

    public function getTagName(){
        return $this->tagName;
    }

    public function addAttribute($attribute, $value){
        $this->attributes[$attribute] = $value;
    }
    public function getAttributes(){
        return $this->attributes;
    }
}
