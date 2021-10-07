<?php

namespace App\VirtualDocs\Models;

/**
 * @OA\Schema(
 *     title="Comment",
 *     description="Comment model",
 *     @OA\Xml(
 *         name="Comment"
 *     )
 * )
 */
class Comment
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
   *      title="comment",
   *      description="The text of the comment",
   *      example="Procastination does not become me",
   *      type="string"
   * )
   *
   * @var string
   */
  public $comment;

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
     *     title="task_id",
     *     description="Task ID",
     *     example=1
     * )
     *
     * @var int
     */
    public $task_id;

    /**
     * @OA\Property(
     *     title="Task",
     *     description="Task model"
     * )
     *
     * @var \App\VirtualDocs\Models\Task
     */
    private $task;


}
