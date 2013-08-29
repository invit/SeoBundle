<?php
namespace Invit\SeoBundle\Seo;

interface TagInterface
{
    function setTagName($tagName);
    function addAttribute($attribute, $value);
    function getAttributes();
    function getHtml();
}
