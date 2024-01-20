<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoCreateRequest;
use App\Http\Requests\TodoIdCheckRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TodoController extends Controller
{
    /**
     * ToDo一覧
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Todo::query();

        $finished = $request->input('finished');
        if ($finished === 'true') {
            $query->where('finished', true);
        } elseif ($finished === 'false') {
            $query->where('finished', false);
        }
        $todos = $query->get();
        $array = ['todos' => $todos];

        return $this->jsonResponse(Response::HTTP_OK, $array);
    }

    /**
     * ToDo作成
     * 
     * @param TodoCreateRequest $request
     * @return JsonResponse
     */
    public function create(TodoCreateRequest $request): JsonResponse
    {
        try {
            $todo = $this->_updateOrCreate($request);
            $array = ['todo' => $todo];

            return $this->jsonResponse(Response::HTTP_OK, $array);
        } catch (Throwable $e) {
            Log::error($e);
            $array = ['message' => 'Internal Server Error'];

            return $this->jsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $array);
        }
    }

    /**
     * ToDo詳細
     * 
     * @param TodoIdCheckRequest $request
     * @return JsonResponse
     */
    public function show(TodoIdCheckRequest $request): JsonResponse
    {
        $todo = Todo::find($request->input('id'));
        $array = ['todo' => $todo];

        return $this->jsonResponse(Response::HTTP_OK, $array);
    }

    /**
     * ToDo更新
     * 
     * @param TodoUpdateRequest $request
     * @return JsonResponse
     */
    public function update(TodoUpdateRequest $request): JsonResponse
    {
        try {
            $todo = $this->_updateOrCreate($request);
            $array = ['todo' => $todo];

            return $this->jsonResponse(Response::HTTP_OK, $array);
        } catch (Throwable $e) {
            Log::error($e);
            $array = ['message' => 'Internal Server Error'];

            return $this->jsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $array);
        }
    }

    /**
     * ToDo削除
     * 
     * @param TodoIdCheckRequest $request
     * @return JsonResponse
     */
    public function destroy(TodoIdCheckRequest $request): JsonResponse
    {
        $id = $request->input('id');
        try {
            Todo::destroy($id);
            $array = ['message' => 'ToDo with ID ' . $id . ' successfully deleted'];

            return $this->jsonResponse(Response::HTTP_OK, $array);
        } catch (Throwable $e) {
            Log::error($e);
            $array = ['message' => 'Internal Server Error'];

            return $this->jsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $array);
        }
    }

    /**
     * ToDoの登録・更新処理
     * 
     * @param Request $request
     * @return Todo
     */
    private function _updateOrCreate(Request $request): Todo
    {
        $params['title'] = $request->input('title');

        if ($request->input('description')) {
            $params['description'] = $request->input('description');
        }

        if ($request->input('finished')) {
            $params['finished'] = $request->input('finished');
        }

        return Todo::updateOrCreate(['id' => $request->input('id')], $params);
    }
}
