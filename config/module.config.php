<?php
/**
 * elmado
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2012 Travello GmbH
 */

/**
 * Module application configuration
 * 
 * @package    Application
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
