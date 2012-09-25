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

use DateTime;
use IntlDateFormatter;
use Zend\View\Helper\AbstractHelper;

/**
 * Date output
 * 
 * Simplifies the date output for the dateFormat view helper
 * 
 * @package    TravelloLib
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2012 Travello GmbH
 */
class Date extends AbstractHelper
{
    /**
     * get string date and output it
     * 
     * @param string $dateString
     * @param string $mode
     * @return boolean
     */
    public function __invoke($dateString, $mode = 'medium')
    {
        if ($dateString == '0000-00-00 00:00:00') {
            return '-';
        }
        
        switch ($mode) {
            case 'short':
                $dateType = IntlDateFormatter::SHORT;
                $timeType = IntlDateFormatter::SHORT;
                break;

            case 'long':
                $dateType = IntlDateFormatter::LONG;
                $timeType = IntlDateFormatter::LONG;
                break;

            case 'short':
                $dateType = IntlDateFormatter::SHORT;
                $timeType = IntlDateFormatter::SHORT;
                break;

            case 'dateonly':
                $dateType = IntlDateFormatter::MEDIUM;
                $timeType = IntlDateFormatter::NONE;
                break;

            default:
            case 'medium':
                $dateType = IntlDateFormatter::MEDIUM;
                $timeType = IntlDateFormatter::MEDIUM;
                break;
        }
        
        $dateTime = new DateTime($dateString);
        
        return $this->getView()->dateFormat($dateTime, $dateType, $timeType);
    }
}
