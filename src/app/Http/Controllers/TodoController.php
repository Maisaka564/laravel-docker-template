<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Todo;

class TodoController extends Controller
{
    private $todo;

    public function __construct(Todo $todo)
    {
        // dd($this->todo);//この時点ではnull
        $this->todo = $todo;//なぜなぜTodoインスタンスをコンストラクタで$this->todoに格納するのか
        // dd($this->todo);//この時点ではtodoインスタンスが格納されている。
    }

    public function create()
    {
        return view('todo.create');

    }

    public function store(TodoRequest $request)
    {
        $inputs = $request->all(); //all()を使用し、フォームで入力された値を連想配列に変換して取得
        $this->todo->fill($inputs);//fillの後に、#attributes: array:1 [▼"content" => "laravel"]
        $this->todo->save();//INSERT INTO todos(content) VALUES ('laravel');
        return redirect()->route('todo.index');
    }

    public function index()
    {
        $todo = $this->todo->all();//all()は、そのモデルが対応するテーブルにSELECT文を実行し、全てのレコードを取得する select * from todos;
        return view('todo.index', ['todos' => $todo]);
    }

    public function show($id)
    {
        $todo = $this->todo->find($id); //select * from todos where id = 1;
        return view('todo.show', ['todo' => $todo]);
    }

    public function edit($id)
    {
        $todo = $this->todo->find($id); //select * from todos where id = 1;
        return view('todo.edit', ['todo' => $todo]);
    }
    public function update(TodoRequest $request, $id)
    {
        $inputs = $request->all();//all()を使用し、フォームで入力された値を連想配列に変換して取得
        $todo = $this->todo->find($id);//select * from todos where id = 1;

        $todo->fill($inputs);//ユーザーが入力してきた値に変更 fillメソッドの引数に入れられた連想配列のデータのうち、fillableで指定されたデータのみ、todoインスタンスに格納する
        $todo->save();
        return redirect()->route('todo.show', $todo->id);
    }

    public function delete($id)
    {
        $todo = $this->todo->find($id);
        $todo->delete();
        return redirect()->route('todo.index');
    }
}
