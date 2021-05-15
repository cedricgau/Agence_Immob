<?php

namespace Cedric\RecaptchaBundle\RecaptchaValidator;

use ReCaptcha\ReCaptcha;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintValidator;

class RecaptchaValidator extends ConstraintValidator {

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var ReCaptcha
     */
    private $reCaptcha;

    public function __construct(RequestStack $requestStack, ReCaptcha $reCaptcha){
        $this->requestStack = $requestStack;
        $this->reCaptcha = $reCaptcha;        
    }

    public function validate($value, Constraint $constraint)
    {
        $request = $recaptchaResponse = $this->requestStack->getCurrentRequest()->request->get('g-recaptcha-response');
        if(empty($recaptchaResponse)){
            $this->context->buildViolation($constraint->message)->addViolation();
            return;
        }

        $response = $this->reCaptcha
        ->setExpectedHostname($request->getHost())
        ->verify($recaptchaResponse, $request->getClientIp());

        if(!$response->isSuccess()){
            dump($response->getErrorCodes());
            $this->addViolation($constraint);
        }

    }

    private function addViolation (Constraint $constraint){
    
        $this->context->buildViolation($constraint->message)->addViolation();
    }







}