<?php
namespace Invit\SeoBundle\Seo;

interface TagInterface
{
    function setTagName($tagName);
    function getTagName();
    function addAttribute($attribute, $value);
    function getAttributes();
}
