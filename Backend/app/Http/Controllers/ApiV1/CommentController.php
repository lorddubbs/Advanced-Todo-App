<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\{CreateComment, UpdateComment};
use App\Http\Resources\CommentResource;
use App\Services\Comment\CommentService;
use Illuminate\Support\Facades\Log; 


class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/comment/task/{taskId}",
     *      operationId="commentIndex",
     *      tags={"Comments"},
     *      summary="Authority: Users | Get all Comments for a Category",
     *      description="This endpoint retrieves all comments",
     *      @OA\Response(
     *          response=200,
     *          description="Comments retrieved",
     *          @OA\JsonContent(ref="#/components/schemas/Comment")
     *       )
     *    )
     */
    public function getCommentsForTask($taskId) {
        try {
            $comments = $this->commentService->getAllComments($taskId);
            return formatResponse(200, 'Comments retrieved successfully.', true, CommentResource::collection($comments));
        } catch (\Exception $e) {
           // Log::error('Categories retrieval failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Comments retrieval failed.', false, $e->getMessage());
        }
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *      path="/comment",
     *      operationId="createComment",
     *      tags={"Comments"},
     *      summary="Authority: User | Create a new Comment",
     *      description="This endpoint creates a new Comment.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateComment")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Comment created successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Comment")
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
     * @param  \Illuminate\Http\CreateComment  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateComment $request)
    {
        try {
            $comment = $this->commentService->createComment($request->validated());
            return formatResponse(201, 'Comment created successfully.', true, CommentResource::collection($comment));
        } catch (\Exception $e) {
            //Log::error('Comment store failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Comment creation failed.', false, $e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/comment/{commentId}",
     *     operationId="getComment",
     *     tags={"Comments"},
     *     summary="Authority: User | Get details of a Comment by ID",
     *     description="This endpoint returns all related data of specified comment",
     *     @OA\Response(
     *        response=200,
     *        description="Comment retrieved successfully",
     *        @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(response="401", description="Unauthenticated. Token needed"),
     *     @OA\Response(response="403", description="Unauthorized. User not with access role"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function show($id)
    {
        try {
            $comment = $this->commentService->getCommentById($id);
            return formatResponse(200, 'Comment retrieved successfully.', true, new CommentResource($comment));
        } catch (\Exception $e) {
            Log::error('Comment fetch failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Cannot fetch Comment.', false, $e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *      path="/comment/{commentId}",
     *      operationId="updateComment",
     *      tags={"Comments"},
     *      summary="Authority: User | Update a Comment | Please use x-www-form-urlencoded for body",
     *      description="This endpoint updates the comment",
     *      @OA\Parameter(
     *        name="commentId",
     *        description="Comment ID",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *            type="integer"
     *        )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateComment")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Comment updated",
     *          @OA\JsonContent(ref="#/components/schemas/Comment")
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Unauthorized. User not with access role",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Comment not found",
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="The given data was invalid.",
     *      ),
     *    )
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateComment  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, UpdateComment $request)
    {
        try {
            $this->commentService->updateComment($id, $request->validated());

            $comment = $this->commentService->getCommentById($id);
            return formatResponse(200, 'Comment updated successfully.', true, new CommentResource($comment));
        } catch (\Exception $e) {
            Log::error('Comment store failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Comment update failed.', false, $e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/comment/{commentId}",
     *     operationId="deleteComment",
     *     tags={"Comments"},
     *     summary="Authority: User | Delete a Comment",
     *     description="This endpoint deletes the selected Comment",
     *     @OA\Parameter(
     *        name="commentId",
     *        description="Comment ID",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *            type="integer"
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment deleted successfully",
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Unauthorized. User not with access role",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="The given data was invalid.",
     *     ),
     *  )
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\DeleteComment  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->commentService->deleteComment($id);
            return formatResponse(200, 'Comment deleted successfully.', true);
        } catch (\Exception $e) {
            Log::error('Comment deletion failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Comment deletion failed.', false, $e->getMessage());
        }
    }
}
