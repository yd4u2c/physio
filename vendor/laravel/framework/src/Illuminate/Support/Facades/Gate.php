<?php

namespace Illuminate\Validation;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class ValidationException extends Exception
{
    /**
     * The validator instance.
     *
     * @var \Illuminate\Contracts\Validation\Validator
     */
    public $validator;

    /**
     * The recommended response to send to the client.
     *
     * @var \Symfony\Component\HttpFoundation\Response|null
     */
    public $response;

    /**
     * The status code to use for the response.
     *
     * @var int
     */
    public $status = 422;

    /**
     * The name of the error bag.
     *
     * @var string
     */
    public $errorBag;

    /**
     * The path the client should be redirected to.
     *
     * @var string
     */
    public $redirectTo;

    /**
     * Create a new exception instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @param  string  $errorBag
     * @return void
     */
    public function __construct($validator, $response = null, $errorBag = 'default')
    {
        parent::__construct('The given data was invalid.');

        $this->response = $response;
        $this->errorBag = $errorBag;
        $this->validator = $validator;
    }

    /**
     * Create a new validation exception from a plain array of messages.
     *
     * @para