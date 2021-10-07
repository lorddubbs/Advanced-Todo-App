<?php

/**
 * @OA\Schema(
 *     title="Update Category Request",
 *     description="Update Category Request Body Data",
 *     type="object",
 *     required={"name"}
 * )
 */
class UpdateCategory
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="The name of the category",
     *      example="Interviews",
     *      type="string"
     * )
     *
     * @var string
     */
    public $name;
}