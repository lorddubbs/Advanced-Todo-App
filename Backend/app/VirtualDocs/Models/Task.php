<?php

namespace App\VirtualDocs\Models;

/**
 * @OA\Schema(
 *     title="Task",
 *     description="Task model",
 *     @OA\Xml(
 *         name="Task"
 *     )
 * )
 */
class Task
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
   *      title="title",
   *      description="The title of the Task",
   *      example="Lead a Series E",
   *      type="string"
   * )
   *
   * @var string
   */
  public $title;

  /**
   * @OA\Property(
   *      title="description",
   *      description="The description of the Task",
   *      example="Becoming a Unicorn",
   *      type="string"
   * )
   *
   * @var string
   */
  public $description;

  /**
   * @OA\Property(
   *      title="thumbnail",
   *      description="The image of the Task",
   *      example="https://res.cloudinary.com/dtgglytjm/image/upload/v1612307531/Files/i9gts5zn0wiusxekrrjz.png",
   *      type="string"
   * )
   *
   * @var string
   */
  public $thumbnail;

  /**
   * @OA\Property(
   *      title="priority",
   *      description="The priority level of the Task",
   *      example="high",
   *      type="string"
   * )
   *
   * @var string
   */
  public $priority;

  /**
     * @OA\Property(
     *     title="start_date",
     *     description="Start date of Task",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $start_date;

    /**
     * @OA\Property(
     *     title="end_date",
     *     description="End date of Task",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $end_date;


  /**
   * @OA\Property(
   *      title="access",
   *      description="The access type of the Task",
   *      example="0",
   *      type="boolean"
   * )
   *
   * @var string
   */
  public $access;

  /**
   * @OA\Property(
   *      title="status",
   *      description="The status of the Task",
   *      example="completed",
   *      type="string"
   * )
   *
   * @var string
   */
  public $status;

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
