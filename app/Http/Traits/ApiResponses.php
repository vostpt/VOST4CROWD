<?php
declare(strict_types=1);

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use stdClass;

/**
 * Trait ApiResponses
 * @package App\Http\Traits
 */
trait ApiResponses
{
    /**
     * @var
     */
    protected $data;

    /**
     * @return $this
     */
    public function respond()
    {
        $this->data = [
            'success' => false,
            'message' => null,
            'errors'  => [],
            'data'    => new stdClass(),
        ];
        return $this;
    }

    /**
     * @param  string  $message
     * @return JsonResponse
     */
    public function notFound($message = 'Not found.')
    {
        $this->data['message'] = $message;
        return new JsonResponse($this->data, Response::HTTP_NOT_FOUND);
    }

    /**
     * @param  string  $message
     * @return JsonResponse
     */
    public function internalServerError($message = 'Internal server error.')
    {
        $this->data['message'] = $message;
        return new JsonResponse($this->data, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param  string  $message
     * @param  array  $errors
     * @return JsonResponse
     */
    public function validationFailed($message = 'Validation failed.', $errors = [])
    {
        $this->data['message'] = $message;
        $this->data['errors']  = $errors;

        return new JsonResponse($this->data, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param array $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    protected function success($data = [], $message = 'Success.', $status = Response::HTTP_OK)
    {
        $returnDataArray = $data['data'] ?? $data;
        unset($returnDataArray['meta']);

        $this->data['success'] = true;
        $this->data['message'] = $message;
        $this->data['meta']    = $data['meta'] ?? [];

        if (\is_array($this->data['data'])) {
            $this->data['data'] = [];
            $this->data['data'] = \array_merge($this->data['data'], $returnDataArray);
        } else {
            $this->data['data'] = $returnDataArray;
        }

        return new JsonResponse($this->data, $status);
    }

    /**
     * @param $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function created($data, $message = 'Created.')
    {
        return $this->success($data, $message, Response::HTTP_CREATED);
    }

    /**
     * @param $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function updated($data, $message = 'Created.')
    {
        return $this->success($data, $message, Response::HTTP_ACCEPTED);
    }

    /**
     * @param  string  $message
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public function badRequest($message = 'Bad request.', $statusCode = Response::HTTP_BAD_REQUEST)
    {
        $this->data['message'] = $message;
        return new JsonResponse($this->data, $statusCode);
    }

    /**
     * @param  string  $message
     * @return JsonResponse
     */
    public function unauthorized($message = 'Unauthorized')
    {
        $this->data['message'] = $message;
        return new JsonResponse($this->data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param  string  $message
     * @return JsonResponse
     */
    public function forbidden($message = 'Access Denied.')
    {
        $this->data['message'] = $message;
        return new JsonResponse($this->data, Response::HTTP_FORBIDDEN);
    }
}
