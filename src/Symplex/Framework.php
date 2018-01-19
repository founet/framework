<?php

namespace Symplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18/01/2018
 * Time: 14:37
 */
class Framework
{

    protected $controllerResolver;
    protected $argumentResolver;
    private $matcher;

    public function __construct(ControllerResolver $controllerResolver, ArgumentResolver $argumentResolver, UrlMatcher $matcher)
    {
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
        $this->matcher = $matcher;
    }

    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);

           return call_user_func_array($controller, $arguments);

        } catch (ResourceNotFoundException $e) {
            return new Response('Not Found', 404);

        } catch (Exception $e) {
           return  new Response('An error occurred :  '.$e->getMessage(), 500);
        }
    }
}