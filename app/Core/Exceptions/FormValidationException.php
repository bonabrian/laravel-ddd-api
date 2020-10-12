<?php

/**
 * @author Bona Brian Siagian <bonabriansiagian@gmail.com>
 */

namespace App\Core\Exceptions;

use App\Interfaces\Http\Controllers\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class FormValidationException extends ValidationException
{
    use ResponseTrait;

    /**
     * @var \Illuminate\Contracts\Validation\Validator $validator
     */
    public $validator;

    /**
     * @var int $status | Default \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY
     */
    public $status = Response::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * Create a new exception instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param string $errorBag
     *
     * @return void
     */
    public function __construct($validator, $response = null, $errorBag = 'default') {
        parent::__construct($validator);

        $this->response = $response;
        $this->errorBag = $errorBag;
        $this->validator = $validator;
    }

    public function render()
    {
        return $this->respondWithCustomData([
            'message' => 'The given data was invalid.',
            'errors' => $this->validator->errors()->messages()
        ], $this->status);
    }
}
