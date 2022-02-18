<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data(Request $request)
    {
        $todos = Todo::where('user_id', auth()->id())->orderBy('created_at', 'DESC')->get();
        return DataTables::of($todos)
            ->addIndexColumn()
            ->addColumn('action', function ($todo) {
                return '
                <button onclick="editTodo(`' . route('todo.show', $todo->id) . '`)" type="button" class="btn btn-xs btn-warning btn-sm">
                    <i class="fa fa-pen"></i>
                </button>
                <button onclick="deleteTodo(`' . route('todo.destroy', $todo->id) . '`)" type="button" class="btn btn-xs btn-danger btn-sm">
                    <i class="fa fa-trash"></i>
                </button>
                ';
            })
            ->addColumn('delete-multiple', function ($todo) {
                return '
                    <input type="checkbox" name="delete_multiple" class="item_multiple" value="' . $todo->id . '"/>
                ';
            })
            ->editColumn('todo', function ($todo) {
                return '<a  role="button"  class="nav-link text-dark" onclick="detailTodo(`' . route('todo.show', $todo->id) . '`)">' . $todo->todo . '</a>';
            })
            ->editColumn('priority', function ($todo) {
                if ($todo->priority) {
                    return '<span class="badge bg-danger w-100 d-block p-2">Important</span>';
                } else {
                    return '<span class="badge bg-success w-100 d-block p-2">Normal</span>';
                }
            })
            ->editColumn('status', function ($todo) {
                if ($todo->status) {
                    return "Finished";
                } else {
                    return "Not yet";
                }
            })
            ->editColumn('created_at', function ($todo) {
                return '<span>' . $todo->created_at->format('d M Y') . '</span>';
            })
            ->rawColumns(['action', 'todo', 'status', 'priority', 'delete-multiple', 'created_at'])
            ->make();
    }

    public function index()
    {
        return view('page.todo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        $data = $request->only('todo', 'desc');
        $data['user_id'] = auth()->id();
        $data['priority'] = $request->priority === "0" ? true : false;


        Todo::create($data);
        return response()->json([
            'ok' => true,
            'status' => 200,
            'message' => 'STORE DATA SUCCESS',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        $data = $todo;
        $data['created'] = $todo->created_at->format('D , d F Y');
        $data["created_human"] = $todo->created_at->diffForHumans();
        $data["url"] = (string)route('todo.update-status', $todo->id);
        return response()->json(
            [
                'ok' => true,
                'status' => Response::HTTP_OK,
                'message' => "SUCCESS FETCH DATA",
                'data' => $data
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        $data = $request->only('todo', 'desc', 'priority');
        $data['user_id'] = auth()->id();
        $data['priority'] = $request->priority !== null ? true : false;

        $todo->update($data);

        return response()->json([
            'ok' => true,
            'status' => Response::HTTP_OK,
            'message' => "UPDATED SUCCESS",
            'data' => $todo
        ], Response::HTTP_OK);
    }

    public function update_status(Request $request, Todo $todo)
    {
        $data = $request->only('status');
        if ($request->status === "true") {
            $data['status'] = true;
        } else if ($request->status === "false") {
            $data['status'] = false;
        }


        $todo->update($data);

        return response()->json([
            'ok' => true,
            'status' => Response::HTTP_OK,
            'message' => "UPDATED SUCCESS",
            'data' => $todo
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json([
            'ok' => true,
            'status' => Response::HTTP_OK,
            'message' => 'DELETED SUCCESS',
        ], Response::HTTP_OK);
    }

    public function delete_multiple(Request $request)
    {
        foreach ($request->id as $id) {
            $todo = Todo::find((int)$id);
            $todo->delete();
        }

        return response()->json([
            'ok' => true,
            'status' => Response::HTTP_OK,
            'message' => 'DELETED SUCCESS',
        ], Response::HTTP_OK);
    }

    public function update_multiple(Request $request)
    {
        foreach ($request->id as $id) {
            $todo = Todo::find((int)$id);
            $todo->update([
                'status' => true,
            ]);
        }

        return response()->json([
            'ok' => true,
            'status' => Response::HTTP_OK,
            'message' => 'UPDATED SUCCESS',
        ], Response::HTTP_OK);
    }
}
