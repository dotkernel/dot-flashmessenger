<?php
/**
 * Created by PhpStorm.
 * User: n3vrax
 * Date: 12/20/2016
 * Time: 1:08 AM
 */

namespace Dot\FlashMessenger\View;

/**
 * Interface RendererInterface
 * @package Dot\FlashMessenger\View
 */
interface RendererInterface
{
    /**
     * @param null $namespace
     * @return mixed
     */
    public function renderMessages($namespace = null);

    /**
     * @param $partial
     * @param null $namespace
     * @param array $extra
     * @return mixed
     */
    public function renderPartial($partial, $namespace = null, array $extra = []);
}