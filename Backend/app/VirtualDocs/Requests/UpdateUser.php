<?php

/**
 * @OA\Schema(
 *     title="User Creation Request",
 *     description="User Request Body Data",
 *     type="object",
 *     required={"name", "email", "password", "thumbnail"}
 * )
 */
class UpdateUser
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="The name of the user",
     *      example="Peter",
     *      type="string"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="email",
     *      description="The email of the user",
     *      example="peter_oduntan@yahoo.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="password",
     *      description="The password of the user",
     *      example="Secret123"
     * )
     *
     * @var string
     */
    public $password;

    /**
     * @OA\Property(
     *      title="thumbnail",
     *      description="The image of the User",
     *      example="https://example.com/image.png"
     * )
     *
     * @var string
     */
    public $thumbnail;

}
