<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    private $todo;

    // 追加
    public function __construct(Todo $todo)
    {
        // dd($this->todo);
        $this->todo = $todo;
    }

    public function create()
    {
        return view('todo.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $this->todo->fill($inputs);
        $this->todo->save();
    }
}