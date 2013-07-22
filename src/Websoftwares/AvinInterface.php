<?php
namespace Websoftwares;
/**
 * AvinInterface
 *
 * @package Websoftwares
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 * @version 0.1
 * @author Boris <boris@websoftwar.es>
 */
interface AvinInterface
{
    /**
     * Setter for filter
     * for a complete list of available filters:
     * @link http://www.avin.cc/api-documentation
     *
     * @param $key the filter name
     * @param $value the filter value
     */
    public function setFilter($key = null, $value = null);

    /**
     * clearFilter empties/resets filters
     */
    public function clearFilter();

    /**
     * setUrl
     */
    public function setUrl($method, $argument = null);

    /**
     * getUrl returns url
     */
    public function getUrl();

    /**
     * execute requests data
     */
    public function execute();
}
