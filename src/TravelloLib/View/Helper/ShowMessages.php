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

use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Helper\AbstractHelper;

/**
 * Show messages view helper
 * 
 * Outputs all messages from FlashMessenger and view
 * 
 * @package    TravelloLib
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2012 Travello GmbH
 */
class ShowMessages extends AbstractHelper
{
    /**
     * FlashMessenger
     *
     * @var FlashMessenger
     */
    protected $flashMessenger;

    /**
     * Constructor
     *
     * @param  FlashMessenger $flashMessenger
     */
    public function __construct(FlashMessenger $flashMessenger)
    {
        $this->setFlashMessenger($flashMessenger);
    }

    /**
     * Outputs message depending on flag
     *
     * @return string 
     */
    public function __invoke()
    {
        // get messages
        $messages = array_unique(array_merge(
            $this->flashMessenger->getMessages(), 
            $this->flashMessenger->getCurrentMessages()
        ));
        
        // initialize output
        $output = '';
        
        // loop through messages
        foreach ($messages as $message) {
            // split into parts to identify $class and $textDomain
            $parts = explode('_', $message);
            $class = $parts[2];
            $textDomain = $parts[0];
            
            // create output
            $output.= '<div class="alert alert-' . $class . '">';
            $output.= '<button class="close" data-dismiss="alert" type="button">×</button>';
            $output.= $this->getView()->translate($message, $textDomain);
            $output.= '</div>';
        }

        // clear messages
        $this->flashMessenger->clearMessages();
        $this->flashMessenger->clearCurrentMessages();
        
        // return output
        return $output . "\n";
    }
    
    /**
     * Sets FlashMessenger
     *
     * @param  FlashMessenger $flashMessenger
     * @return AbstractHelper
     */
    public function setFlashMessenger(FlashMessenger $flashMessenger = null)
    {
        $this->flashMessenger = $flashMessenger;
        return $this;
    }
    
    /**
     * Returns FlashMessenger
     *
     * @return FlashMessenger
     */
    public function getFlashMessenger()
    {
        return $this->flashMessenger;
    }
}
