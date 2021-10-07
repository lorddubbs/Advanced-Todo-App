<?php

/**
 * @OA\Schema(
 *     title="Create Task Request",
 *     description="Body Data",
 *     type="object",
 *     required={"title", "description", "thumbnail", "priority", "start-date", "end_date", "access", "status"}
 * )
 */
class CreateTask
{
    /**
     * @OA\Property(
     *      title="title",
     *      description="The title of the Task",
     *      example="Doing Laundry"
     * )
     *
     * @var string 
     */
    public $title;

    /**
     * @OA\Property(
     *      title="description",
     *      description="The description of the task created",
     *      example="Going to the Laundry mart"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *      title="thumbnail",
     *      description="The image of the Task",
     *      example="https://en.wikipedia.org/image.png"
     * )
     *
     * @var string
     */
    public $thumbnail;

    /**
     * @OA\Property(
     *      title="priority",
     *      description="The priority level of the Task",
     *      example="low"
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
     *      example=1
     * )
     *
     * @var string
     */
    public $access;

    /**
   * @OA\Property(
   *      title="status",
   *      description="The status of the Task",
   *      example="completed"
   * )
   *
   * @var string
   */
  public $status;

}
