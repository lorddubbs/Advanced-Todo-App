<?php

namespace App\VirtualDocs\Models;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User
{
  /**
   * @OA\Property(
   *     title="ID",
   *     description="ID",
   *     format="int64",
   *     example=1
   * )
   *
   * @var int
   */
  private $id;

  /**
   * @OA\Property(
   *      title="name",
   *      description="The name of the User",
   *      example="Peter Oduntan",
   *      type="string"
   * )
   *
   * @var string
   */
  public $name;

  /**
   * @OA\Property(
   *      title="email",
   *      description="The email of the User",
   *      example="peter_oduntan@yahoo.com",
   *      type="string"
   * )
   *
   * @var string
   */
  public $email;

  /**
  * @OA\Property(
  *      title="thumbnail",
  *      description="The image of the User",
  *      example="https://example.com/image.png",
  *      type="string"
  * )
  *
  * @var string
  */
  public $thumbnail;

  /**
   * @OA\Property(
   *     title="Created at",
   *     description="Created at",
   *     example="2021-09-27 17:50:45",
   *     format="datetime",
   *     type="string"
   * )
   *
   * @var \DateTime
   */
  private $created_at;

  /**
   * @OA\Property(
   *     title="Updated at",
   *     description="Updated at",
   *     example="2021-09-27 17:50:45",
   *     format="datetime",
   *     type="string"
   * )
   *
   * @var \DateTime
   */
  private $updated_at;


}
