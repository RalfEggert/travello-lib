<?php
/**
 * TravelloLib
 * 
 * @package    TravelloLib
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2012 Travello GmbH
 */

/**
 * TravelloLib configuration
 * 
 * @package    TravelloLib
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2012 Travello GmbH
 */
return array(
    'view_helpers' => array(
        'invokables'=> array(
            'mobileDetect' => 'TravelloLib\View\Helper\MobileDetect',
            'date'         => 'TravelloLib\View\Helper\Date',
            'pageTitle'    => 'TravelloLib\View\Helper\PageTitle',
        )
    ),
);
