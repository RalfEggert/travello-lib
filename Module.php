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
namespace TravelloLib;

use Zend\EventManager\EventInterface;
use Zend\Filter\StaticFilter;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Travello library module
 * 
 * Provides ZF2 library extensions
 * 
 * @package    TravelloLib
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2012 Travello GmbH
 */
class Module implements AutoloaderProviderInterface, BootstrapListenerInterface
{
    /**
     * Listen to the bootstrap event
     *
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        $sm = $e->getApplication()->getServiceManager(); /* @var $sm \Zend\ServiceManager\ServiceManager */
        
        StaticFilter::getPluginManager()->setInvokableClass(
            'stringToUrl', 'TravelloLib\Filter\StringToUrl'
        );
    }
    
    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
