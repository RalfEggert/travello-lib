<?php
/**
 * TravelloLib
 * 
 * @package    TravelloLib
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2012 Travello GmbH
 */

/**
 * namespace definition and usage
 */
namespace TravelloLib\View\Helper;

use Zend\View\Helper\HeadTitle;

/**
 * Helper for setting and retrieving h1 element titles
 * 
 * @package    TravelloLib
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2012 Travello GmbH
 */
class PageTitle extends HeadTitle
{
    /**
     * Registry key for placeholder
     * @var string
     */
    protected $regKey = 'TravelloLib_View_Helper_PageTitle';

    /**
     * Flag whether to automatically escape output, must also be
     * enforced in the child class if __toString/toString is overridden
     * @var book
     */
    protected $autoEscape = false;

    /**
     * What string to use between individual items in the placeholder when rendering
     * @var string
     */
    protected $separator = ' &raquo; ';

    /**
     * Turn helper into string
     *
     * @param  string|null $indent
     * @return string
     */
    public function toString($indent = null)
    {
        $output = parent::toString($indent);
        $output = str_replace(array('<title>', '</title>'), array('<h1>', '</h1>'), $output);
        
        return $output;
    }
}
