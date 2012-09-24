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
namespace TravelloLib\Form;

use Zend\Form\Form as ZendForm;
use Zend\I18n\Translator\Translator;

/**
 * Extended form
 * 
 * Extends the form to add translator support
 * 
 * @package    TravelloLib
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2012 Travello GmbH
 */
abstract class AbstractForm extends ZendForm
{
    /**
     * @var string form name
     */
    protected $formName = null;
    
    /**
     * @var string text domain
     */
    protected $textDomain = 'default';
    
    /**
     * @var Translator
     */
    protected $translator = null;
    
    /**
     * Create the form
     * 
     * @param string $name Optional name for the form
     */
    public function __construct(Translator $translator) 
    {
        // set translator
        $this->translator = $translator;
        
        // call constructor
        parent::__construct($this->formName);
        
        // set attributes
        $this->setAttribute('method', 'post');
        
        // call initialize method
        $this->init();
    }
    
    /** 
     * Initialize form
     */
    abstract public function init();
    
    /**
     * Retrieve the translator
     *
     * @return Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }
    
    /**
     * Set translated options
     *
     * @name string name of element
     * @options array list of untranslated options
     * @return AbstractForm
     */
    public function setTranslatedOptions($name, array $options)
    {
        foreach ($options as $key => $value) {
            $options[$key] = $this->getTranslator()->translate($value, $this->textDomain);
        }
        
        $this->get($name)->setValueOptions($options);
        
        return $this;
    }
    
    
}
