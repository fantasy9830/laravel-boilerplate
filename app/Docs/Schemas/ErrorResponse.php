<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *      description="Error response",
 *      title="Error response",
 *      required={"error", "error_description"},
 * )
 */
class ErrorResponse extends Exception
{
    /**
     * @OA\Property()
     * @var string
     */
    public $error;

    /**
     * @OA\Property()
     * @var string
     */
    public $error_description;
}
