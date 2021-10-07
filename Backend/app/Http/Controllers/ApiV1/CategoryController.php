<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\{CreateCategory, UpdateCategory};
use App\Http\Resources\CategoryResource;
use App\Services\Category\CategoryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 


class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/category",
     *      operationId="categoryIndex",
     *      tags={"Categories"},
     *      summary="Authority: Users | Get all Categories",
     *      description="This endpoint retrieves all categories",
     *      @OA\Response(
     *          response=200,
     *          description="Categories retrieved",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *       )
     *    )
     */
    public function index() {
        try {
            $categories = $this->categoryService->getAllCategories(Auth::id());
            return formatResponse(200, 'Categories retrieved successfully.', true, CategoryResource::collection($categories));
        } catch (\Exception $e) {
           // Log::error('Categories retrieval failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Categories retrieval failed.', false, $e->getMessage());
        }
    }
    

    /*
    public function myCategories()
    {
        try {
            $id = Auth::id();
            $categories = $this->categoryService->getAllCategories($id);
            return formatResponse(200, 'Categories retrieved successfully.', true, CategoryResource::collection($categories));
        } catch (\Exception $e) {
            Log::error('Categories retrieval failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Categories retrieval failed.', false, $e->getMessage());
        }
    }
    */

    /**
     * @OA\Post(
     *      path="/category",
     *      operationId="createCategory",
     *      tags={"Categories"},
     *      summary="Authority: User | Create a new Category",
     *      description="This endpoint creates a new Category.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateCategory")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Category created successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
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
     * @param  \Illuminate\Http\CreateCategory  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategory $request)
    {
        try {
            $category = $this->categoryService->createCategory($request->validated());
            return formatResponse(201, 'Category created successfully.', true, new CategoryResource($category));
        } catch (\Exception $e) {
            //Log::error('Category store failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Category creation failed.', false, $e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/category/{categoryId}",
     *     operationId="getCategory",
     *     tags={"Categories"},
     *     summary="Authority: User | Get details of a Category by ID",
     *     description="This endpoint returns all related data of specified category",
     *     @OA\Response(
     *        response=200,
     *        description="Category retrieved successfully",
     *        @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(response="401", description="Unauthenticated. Token needed"),
     *     @OA\Response(response="403", description="Unauthorized. User not with access role"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function show($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            return formatResponse(200, 'Category retrieved successfully.', true, new CategoryResource($category));
        } catch (\Exception $e) {
            Log::error('Category fetch failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Cannot fetch Category.', false, $e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *      path="/category/{categoryId}",
     *      operationId="updateCategory",
     *      tags={"Categories"},
     *      summary="Authority: User | Update a Category | Please use x-www-form-urlencoded for body",
     *      description="This endpoint updates the category",
     *      @OA\Parameter(
     *        name="categoryId",
     *        description="Category ID",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *            type="integer"
     *        )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateCategory")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Category updated",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Unauthorized. User not with access role",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Category not found",
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="The given data was invalid.",
     *      ),
     *    )
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateCategory  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, UpdateCategory $request)
    {
        try {
            $this->categoryService->updateCategory($id, $request->validated());

            $category = $this->categoryService->getCategoryById($id);
            return formatResponse(200, 'Category updated successfully.', true, new CategoryResource($category));
        } catch (\Exception $e) {
            Log::error('Category store failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Category update failed.', false, $e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/category/{categoryId}",
     *     operationId="deleteCategory",
     *     tags={"Categories"},
     *     summary="Authority: User | Delete a Category",
     *     description="This endpoint deletes the selected Category",
     *     @OA\Parameter(
     *        name="categoryId",
     *        description="Category ID",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *            type="integer"
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category deleted successfully",
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Unauthorized. User not with access role",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="The given data was invalid.",
     *     ),
     *  )
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\DeleteCategory  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return formatResponse(200, 'Category deleted successfully.', true);
        } catch (\Exception $e) {
            Log::error('Category deletion failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Category deletion failed.', false, $e->getMessage());
        }
    }
}
