<?php

/**
 * @author Bona Brian Siagian <bonabriansiagian@gmail.com>
 */

namespace App\Interfaces\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    /**
     * The current path of resource to respond.
     *
     * @var string
     */
    protected string $resourceItem;

    /**
     * The current path of collection resource to respond.
     *
     * @var string
     */
    protected string $resourceCollection;

    /**
     * Respond with custom data
     *
     * @param $data
     * @param int $status | Default \Illuminate\Http\Response::HTTP_OK
     */
    protected function respondWithCustomData($data, $status = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse([
            'data' => $data,
            'meta' => [
                'timestamp' => $this->getTimestampInMilliseconds()
            ]
        ], $status);
    }

    /**
     * Get timestamp in milliseconds
     *
     * @return int
     */
    protected function getTimestampInMilliseconds(): int
    {
        return intdiv((int) now()->format('Uu'), 1000);
    }

    /**
     * Return no content for delete requests.
     *
     * @return JsonResponse
     */
    protected function respondWithNoContent(): JsonResponse
    {
        return new JsonResponse([
            'data' => null,
            'meta' => [
                'timestamp' => $this->getTimestampInMilliseconds()
            ]
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Return collection response from the application.
     *
     * @param LengthAwarePaginator $collection
     *
     * @return mixed
     */
    protected function respondWithCollection(LengthAwarePaginator $collection)
    {
        return (new $this->resourceCollection($collection))->additional([
            'meta' => [
                'timestamp' => $this->getTimestampInMilliseconds()
            ]
        ]);
    }

    /**
     * Return single item response from the application.
     *
     * @param Model $item
     *
     * @return mixed
     */
    protected function respondWithItem(Model $item)
    {
        return (new $this->resourceItem($item))->additional([
            'meta' => [
                'timestamp' => $this->getTimestampInMilliseconds()
            ]
        ]);
    }
}
