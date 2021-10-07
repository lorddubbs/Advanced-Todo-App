<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\{CreateTask, UpdateTask};
use App\Http\Resources\TaskResource;
use App\Services\Task\TaskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 


class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*
    public function myTasks()
    {
        try {
            $id = Auth::id();
            $tasks = $this->taskService->getAllTasks($id);
            return formatResponse(200, 'Tasks retrieved successfully.', true, TaskResource::collection($tasks));
        } catch (\Exception $e) {
            Log::error('Tasks retrieval failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Tasks retrieval failed.', false, $e->getMessage());
        }
    }
    */

    /**
     * @OA\Get(
     *      path="/task",
     *      operationId="taskIndex",
     *      tags={"Tasks"},
     *      summary="Authority: User | Get all Tasks",
     *      description="This endpoint retrieves all tasks",
     *      @OA\Response(
     *          response=200,
     *          description="Tasks retrieved",
     *          @OA\JsonContent(ref="#/components/schemas/Task")
     *       )
     *    )
     */
    public function index()
    {
        try {
            $tasks = $this->taskService->getAllTasks(Auth::id());
            return formatResponse(200, 'Tasks retrieved successfully.', true, TaskResource::collection($tasks));
        } catch (\Exception $e) {
            //Log::error('Tasks retrieval failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Tasks retrieval failed.', false, $e->getMessage());
        }
    }


    /**
     * @OA\Post(
     *      path="/task",
     *      operationId="createTask",
     *      tags={"Tasks"},
     *      summary="Authority: User | Create a new Task",
     *      description="This endpoint creates a new Task.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateTask")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Task created successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Task")
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Unauthorized. User not with access role",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="The given data was invalid.",
     *      ),
     *    )
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateTask  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTask $request)
    {
        try {
            $task = $this->taskService->createTask($request->validated());

            return formatResponse(200, 'Task created successfully.', true, $task);
        } catch (\Exception $e) {
            //Log::error('Task store failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Task creation failed.', false, $e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/task/{taskId}",
     *     operationId="getTask",
     *     tags={"Tasks"},
     *     summary="Authority: User | Get details of a Task by ID",
     *     description="This endpoint returns all related data of specified task",
     *     @OA\Response(
     *        response=200,
     *        description="Task retrieved successfully",
     *        @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response="401", description="Unauthenticated. Token needed"),
     *     @OA\Response(response="403", description="Unauthorized. User not with access role"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function show($id)
    {
        try {
            $task = $this->taskService->getTaskById($id);
            return formatResponse(200, 'Task retrieved successfully.', true, new TaskResource($task));
        } catch (\Exception $e) {
            Log::error('Task fetch failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Cannot fetch Task.', false, $e->getMessage());
        }
    }

    /*
    public function getTaskBySlug($slug)
    {
        try {
            $task = $this->taskService->getTaskBySlug($slug);
            return formatResponse(200, 'Task retrieved successfully.', true, new TaskResource($task));
        } catch (\Exception $e) {
            //Log::error('Task fetch failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Cannot fetch Task.', false, $e->getMessage());
        }
    }
    */

    /**
     * @OA\Put(
     *      path="/task/{taskId}",
     *      operationId="updateTask",
     *      tags={"Tasks"},
     *      summary="Authority: User | Update a Task | Please use x-www-form-urlencoded for body",
     *      description="This endpoint updates the task",
     *      @OA\Parameter(
     *        name="taskId",
     *        description="Task ID",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *            type="integer"
     *        )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateTask")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Task updated",
     *          @OA\JsonContent(ref="#/components/schemas/Task")
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Unauthorized. User not with access role",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Task not found",
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="The given data was invalid.",
     *      ),
     *    )
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateTask  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, UpdateTask $request)
    {
        try {
            $this->taskService->updateTask($id, $request->validated());

            $task = $this->taskService->getTaskById($id);
            return formatResponse(200, 'Task updated successfully.', true, new TaskResource($task));
        } catch (\Exception $e) {
            //Log::error('Task store failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Task update failed.', false, $e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/task/{taskId}",
     *     operationId="deleteTask",
     *     tags={"Tasks"},
     *     summary="Authority: User | Delete a Task",
     *     description="This endpoint deletes the selected Task",
     *     @OA\Parameter(
     *        name="taskId",
     *        description="Task ID",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *            type="integer"
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task deleted successfully",
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Unauthorized. User not with access role",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="The given data was invalid.",
     *     ),
     *  )
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\DeleteTask  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->taskService->deleteTask($id);
            return formatResponse(200, 'Task deleted successfully.', true);
        } catch (\Exception $e) {
            Log::error('Task deletion failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Task deletion failed.', false, $e->getMessage());
        }
    }
}
