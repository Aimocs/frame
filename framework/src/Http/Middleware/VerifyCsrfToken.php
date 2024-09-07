<?php

namespace followed\framed\Http\Middleware;

use followed\framed\Http\CsrfException;
use followed\framed\Http\Request;
use followed\framed\Http\Response;

class VerifyCsrfToken implements MiddlewareInterface
{

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        // Proceed if not state change request
        if (!in_array($request->getMethod(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $requestHandler->handle($request);
        }

        // Retrieve the tokens
        $tokenFromSession = $request->getSession()->get('csrf_token');
        $tokenFromRequest = $request->input('csrf_token');


        // Throw an exception on mismatch
        if(!hash_equals($tokenFromSession, $tokenFromRequest)) {
            // Throw an exception
           $exception= new CsrfException("Invalid Token");
           $exception->setStatus(Response::HTTP_FORBIDDEN);
           throw $exception;

        }

        // Proceed
        return $requestHandler->handle($request);
    }
}