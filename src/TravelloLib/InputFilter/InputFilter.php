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
namespace TravelloLib\InputFilter;

use Zend\Db\Adapter\Adapter;
use Zend\Filter\AbstractFilter;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Zend\Stdlib\AbstractOptions;
use Zend\Validator\AbstractValidator;

/**
 * Input filter
 * 
 * Extends standard input filter
 * 
 * @package    TravelloLib
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2012 Travello GmbH
 */
class InputFilter extends ZendInputFilter
{
    /**
     * @var Adapter
     */
    protected $adapter = null;

    /**
     * @var AbstractOptions
     */
    protected $options = null;

    /**
     * @var array list of filters
     */
    protected $filters = array();
    
    /**
     * @var array list of validators
     */
    protected $validators = array();
    
    /**
     * Constructor
     * 
     * @param Adapter $adapter database adapter
     * @param AbstractOptions $options module options
     */
    public function __construct(Adapter $adapter, AbstractOptions $options)
    {
        // set database adapter
        $this->adapter = $adapter;
        
        // set options
        $this->options = $options;
        
        // build filter
        $this->build();
    }

    /**
     * Build filter
     */
    public function build()
    {
    }
    
    /**
     * Set filter
     * 
     * @param string $input name of input
     * @param string $name  name of filter
     * @param AbstractFilter $filter
     */
    public function setFilter($input, $name, AbstractFilter $filter)
    {
        // check for input array
        if (!isset($this->filters[$input])) {
            $this->filters[$input] = array();
        }
        
        // set filter
        $this->filters[$input][$name] = $filter;
    }
    
    /**
     * Get filter
     * 
     * @param string $input name of input
     * @param string $name  name of filter
     * @return AbstractFilter
     */
    public function getFilter($input, $name)
    {
        // check for input array
        if (!isset($this->filters[$input]) || !isset($this->filters[$input][$name])) {
            throw new InvalidArgumentException('Unknown filter');
        }
        
        // return filter
        return $this->filters[$input][$name];
    }
    
    /**
     * Get filters
     * 
     * @return array with AbstractFilter
     */
    public function getFilters()
    {
        // return filters
        return $this->filters;
    }

    /**
     * Set validator
     *
     * @param string $input name of input
     * @param string $name  name of filter
     * @param AbstractValidator $validator
     */
    public function setValidator($input, $name, AbstractValidator $validator)
    {
        // check for input array
        if (!isset($this->validators[$input])) {
            $this->validators[$input] = array();
        }
    
        // set validator
        $this->validators[$input][$name] = $validator;
    }
    
    /**
     * Get validator
     *
     * @param string $input name of input
     * @param string $name  name of filter
     * @return AbstractValidator
     */
    public function getValidator($input, $name)
    {
        // check for input array
        if (!isset($this->validators[$input]) || !isset($this->validators[$input][$name])) {
            throw new InvalidArgumentException('Unknown validator');
        }
    
        // return validator
        return $this->validators[$input][$name];
    }
    
    /**
     * Get validators
     *
     * @return array with AbstractValidator
     */
    public function getValidators()
    {
        // return validators
        return $this->validators;
    }
}
