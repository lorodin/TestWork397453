<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TasksController extends ApiController
{
    const TODOS_ON_PAGE = 10;

    /**
     * Return list of todos
     *
     * @OA\Get(
     *      path="/api/tasks/list/{page}",
     *      summary="Tasks list",
     *      tags={"Tasks"},
     *      security={{"bearerAuth":{}}},
     *      description="Return list of tasks",
     *      @OA\Parameter(
     *          name="page",
     *          in="path",
     *          description="Page of list",
     *          required=true,
     *          example="1"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List data",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  example="success"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property (
     *                      property="per_page",
     *                      type="int",
     *                      example="10"
     *                  ),
     *                  @OA\Property (
     *                      property="page",
     *                      type="int",
     *                      example="1"
     *                  ),
     *                  @OA\Property (
     *                      property="count",
     *                      type="int",
     *                      example="100"
     *                  ),
     *                  @OA\Property (
     *                      property="list",
     *                      type="array",
     *                      @OA\Items (
     *                          ref="#/components/schemas/Task"
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     *
     * @param int|null $page
     * @return JsonResponse
     */
    public function list(int $page = null): JsonResponse
    {
        $page = !isset($page) || $page < 1 ? 1 : $page;

        /**
         * @var User $user
         */
        $user = Auth::user();

        $tasks = Task::query()
            ->where('user_id', $user->id)
            ->skip(($page - 1) * self::TODOS_ON_PAGE)
            ->take(self::TODOS_ON_PAGE)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($page != 1 && $tasks->count() == 0) {
            abort(404);
        }

        return $this->jsonResponse(true, [
            'page' => $page,
            'per_page' => self::TODOS_ON_PAGE,
            'count' => Task::query()
                ->where('user_id', $user->id)
                ->count(),
            'list' => $tasks,
        ]);
    }

    /**
     * Create task
     *
     * @OA\Post (
     *      path="/api/tasks/create",
     *      summary="Create task",
     *      tags={"Tasks"},
     *      security={{"bearerAuth":{}}},
     *      description="Create task",
     *      @OA\RequestBody(
     *          request="Task create request",
     *          required=true,
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/TaskCreateRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Saved result",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  example="success"
     *          )
     *      )
     *   )
     * )
     *
     * @param TaskCreateRequest $request
     * @return JsonResponse
     */
    public function create(TaskCreateRequest $request): JsonResponse
    {
        $validated = $request->validated();

        /**
         * @var User $user
         */
        $user = Auth::user();

        $task = new Task;
        $task->name = $validated['name'];
        $task->description = $validated['description'];
        $task->user_id = $user->id;

        return $this->jsonResponse($task->save());
    }

    /**
     * Delete task
     *
     * @OA\Delete (
     *     path="/api/tasks/delete/{id}",
     *     summary="Delete task",
     *     tags={"Tasks"},
     *     security={{"bearerAuth":{}}},
     *     description="Delete task",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Task id",
     *         required=true,
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Delete result",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  example="success"
     *          )
     *      )
     *    )
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        $result = Task::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->delete();

        return $this->jsonResponse($result == 1);
    }

    /**
     * Create task
     *
     * @OA\Post (
     *      path="/api/tasks/update/{id}",
     *      summary="Update task",
     *      tags={"Tasks"},
     *      security={{"bearerAuth":{}}},
     *      description="Update task",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Task id",
     *          required=true,
     *      ),
     *      @OA\RequestBody(
     *          request="Task update request",
     *          required=true,
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/TaskUpdateRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Update result",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  example="success"
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property (
     *                  property="status",
     *                  type="string",
     *                  example="error"
     *              ),
     *              @OA\Property (
     *                   property="errors",
     *                   type="array",
     *                   @OA\Items (
     *                      type="string",
     *                      example="Error message"
     *                   )
     *              )
     *          )
     *      )
     *   )
     * )
     *
     * @param TaskUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TaskUpdateRequest $request, int $id): JsonResponse
    {
        $validated = $request->validated();

        /**
         * @var User $user
         */
        $user = Auth::user();

        /**
         * @var Task $task
         */
        $task = Task::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($task->completed) {
            return $this->jsonResponse(false, 'Task is completed', 422);
        }

        $task->name = $validated['name'];
        $task->description = $validated['description'];
        $task->completed = $validated['completed'];

        return $this->jsonResponse($task->update());
    }
}
