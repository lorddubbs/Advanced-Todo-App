<?php

/**
 * @OA\Schema(
 *     title="Update Comment Request",
 *     description="Create Comment Request Body Data",
 *     type="object",
 *     required={"comment"}
 * )
 */
class UpdateComment
{
    /**
     * @OA\Property(
     *      title="comment",
     *      description="The text of the comment",
     *      example="Procastination will never win",
     *      type="string"
     * )
     *
     * @var string
     */
    public $comment;
}