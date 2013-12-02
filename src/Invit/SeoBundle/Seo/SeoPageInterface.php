<?php
namespace Invit\SeoBundle\Seo;

use Symfony\Component\HttpKernel\Bundle\Bundle;

interface SeoPageInterface
{
    /**
     * @param $title
     * @return SeoPageInterface
     */
    function setTitle($title);

    /**
     * @return string
     */
    function getTitle();

    function setH1($title);

    function getH1();

    /**
     * @param array $data
     * @return SeoPageInterface
     */
    function addMeta($type, $name, $value, array $extras = array());

    /**
     * @return array
     */
    function getMetas();

    /**
     * @param array $metas
     * @return SeoPageInterface
     */
    function setMetas(array $metas);
}