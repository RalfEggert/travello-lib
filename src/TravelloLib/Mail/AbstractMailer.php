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
namespace TravelloLib\Mail;

use Zend\Mail\Message as MailMessage;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\AggregateResolver;

/**
 * Mailer service
 * 
 * Handles the mail building and sending
 * 
 * @package    TravelloLib
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2012 Travello GmbH
 */
abstract class AbstractMailer 
{
    /**
     * @var string
     */
    protected $encoding = 'utf-8';
    
    /**
     * @var string
     */
    protected $senderMail = null;
    
    /**
     * @var string
     */
    protected $senderName = null;
    
    /**
     * @var string
     */
    protected $subjectPrefix = null;
    
    /**
     * @var ViewModel
     */
    protected $viewModel = null;
    
    /**
     * @var PhpRenderer
     */
    protected $renderer = null;
    
    /**
     * @var TemplateMapResolver
     */
    protected $resolver = null;
    
    /**
     * @var TransportInterface
     */
    protected $transport = null;
    
    /**
     * @var MailMessage
     */
    protected $message = null;
    
    /**
     * Constructor
     * 
     * @param ViewModel $viewModel
     * @param TemplateMapResolver $resolver
     * @param PhpRenderer $renderer
     */
    public function __construct(ViewModel $viewModel, AggregateResolver $resolver, PhpRenderer $renderer, TransportInterface $transport)
    {
        // initialize objects
        $this->viewModel = $viewModel;
        $this->resolver  = $resolver;
        $this->renderer  = $renderer;
        $this->transport = $transport;
    }
    
    /**
     * Set email template
     *
     * @param string $emailTemplate
     * @return Mailer
     */
    public function setEmailTemplate($emailTemplate)
    {
        $this->viewModel->setTemplate($emailTemplate);
        return $this;
    }
    
    /**
     * Get email template
     *
     * @return string
     */
    public function getEmailTemplate()
    {
        return $this->viewModel->getTemplate();
    }
    
    /**
     * Get email transport
     *
     * @return TransportInterface
     */
    public function getTransport()
    {
        return $this->transport;
    }
    
    /**
     * Set email variables
     *
     * @param array $variables
     * @return Mailer
     */
    public function setVariables($variables)
    {
        $this->viewModel->setVariables($variables);
        return $this;
    }
    
    /**
     * Set email recipient
     *
     * @param array $variables
     * @return Mailer
     */
    public function setRecipient($email, $name)
    {
        if ($this->message) {
            $this->message->setTo($email, $name);
        }
        return $this;
    }
    
    /**
     * Get message
     *
     * @return MailMessage
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * Build Message
     *
     * @return MailMessage
     */
    public function buildMessage()
    {
        // prepare html body
        $htmlBody = $this->renderer->render($this->viewModel);
        
        // prepare text body
        $textBody = $this->buildTextBody($htmlBody);
        
        // prepare subject
        $subject = $this->buildSubject($htmlBody);
                
        // prepare html part
        $htmlPart = new MimePart($this->buildHtmlHeader() . $htmlBody . $this->buildHtmlFooter());
        $htmlPart->type = 'text/html';
        
        // prepare text part
        $textPart = new MimePart($textBody);
        $textPart->type = 'text/plain';
        
        // prepare mime message
        $mailBody = new MimeMessage();
        $mailBody->setParts(array($textPart, $htmlPart));
        
        // prepare message
        $this->message = new MailMessage();
        $this->message->setEncoding($this->encoding);
        $this->message->setFrom($this->senderMail, $this->senderName);
        $this->message->setSubject($subject);
        $this->message->setBody($mailBody);
        
        // return mailer
        return $this;
    }
    
    /**
     * Build text body
     *
     * @param string $htmlBody
     * @return string
     */
    public function buildTextBody($htmlBody)
    {
        $textBody = $htmlBody;
        $textBody = str_replace(array('<h1>', '</h1>'), array(str_pad('-', 70, '-') . "\n", "\n" . str_pad('-', 70, '-') . "\n"), $textBody);
        $textBody = str_replace(array('<p>', '</p>', '<br />', '<br/>', '<br>'), array('', "\n", "\n", "\n", "\n"), $textBody);
        $textBody = strip_tags($textBody);
        $textBody = html_entity_decode($textBody);
        $textBody = wordwrap($textBody, 70);
        
        return $textBody;
    }
    
    /**
     * Build subject
     *
     * @param string $htmlBody
     * @return string
     */
    public function buildSubject($htmlBody)
    {
        $matches = null;
        
        preg_match('=<h1>(.*)</h1>=i', $htmlBody, $matches);
        
        return $this->subjectPrefix . ' ' . $matches[1];
    }
    
    /**
     * Build html header
     *
     * @return string
     */
    abstract public function buildHtmlHeader();
    
    /**
     * Build html footer
     *
     * @return string
     */
    abstract public function buildHtmlFooter();
    
    /**
     * Send Message
     *
     * @return void
     */
    public function sendMessage()
    {
        if ($this->message) {
            $this->getTransport()->send($this->message);
        }
    }
    
}
