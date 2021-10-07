<?php

namespace App\VirtualDocs\Models;

/**
 * @OA\Schema(
 *     title="Category",
 *     description="Category model",
 *     @OA\Xml(
 *         name="Category"
 *     )
 * )
 */
class Category
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
   *      description="The name of the Category",
   *      example="Laundry",
   *      type="string"
   * )
   *
   * @var string
   */
  public $name;

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

  /**
     * @OA\Property(
     *     title="user_id",
     *     description="User ID",
     *     example=1
     * )
     *
     * @var int
     */
    public $user_id;

    /**
     * @OA\Property(
     *     title="User",
     *     description="User model"
     * )
     *
     * @var \App\VirtualDocs\Models\User
     */
    private $user;

}
