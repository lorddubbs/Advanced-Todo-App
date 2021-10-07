<?php

/**
 * @OA\Schema(
 *     title="Create Category Request",
 *     description="Create Category Request Body Data",
 *     type="object",
 *     required={"name"}
 * )
 */
class CreateCategory
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="The name of the category",
     *      example="Laundry",
     *      type="string"
     * )
     *
     * @var string
     */
    public $name;
}