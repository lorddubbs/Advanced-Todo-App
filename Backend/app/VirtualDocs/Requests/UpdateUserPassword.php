<?php

/**
 * @OA\Schema(
 *     title="User Password Update Request",
 *     description="User Password Request Body Data",
 *     type="object",
 *     required={"password", "password_confirmation"}
 * )
 */
class UpdateUserPassword
{
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
     *      title="password",
     *      description="Confirm the password of the user",
     *      example="Secret123"
     * )
     *
     * @var string
     */
    public $password_confirmation;

}
