<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Mvc\View\Console;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\Console\Response as ConsoleResponse;
use Zend\View\Model\ConsoleModel as ConsoleViewModel;
use Zend\View\Model\ModelInterface as ViewModel;

class DefaultRenderingStrategy implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * Attach the aggregate to the specified event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, array($this, 'render'), -10000);
    }

    /**
     * Detach aggregate listeners from the specified event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * Render the view
     *
     * @param  MvcEvent $e
     * @return Response
     */
    public function render(MvcEvent $e)
    {
        $result = $e->getResult();
        if ($result instanceof Response) {
            return $result; // the result is already rendered ...
        }

        // marshal arguments
        $response  = $e->getResponse();

        if (empty($result)) {
            // There is absolutely no result, so there's nothing to display.
            // We will return an empty response object
            return $response;
        }

        // Collect results from child models
        $responseText = '';
        if ($result->hasChildren()) {
            foreach ($result->getChildren() as $child) {
                // Do not use ::getResult() method here as we cannot be sure if
                // children are also console models.
                $responseText .= $child->getVariable(ConsoleViewModel::RESULT);
            }
        }

        // Fetch result from primary model
        if ($result instanceof ConsoleViewModel) {
            $responseText .= $result->getResult();
        } else {
            $responseText .= $result->getVariable(ConsoleViewModel::RESULT);
        }

        // Append console response to response object
        $response->setContent(
            $response->getContent() . $responseText
        );

        // Pass on console-specific options
        if ($response instanceof ConsoleResponse
            && $result instanceof ConsoleViewModel
        ) {
            $errorLevel = $result->getErrorLevel();
            $response->setErrorLevel($errorLevel);
        }

        return $response;
    }
}
