<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 全タスクを取得するメソッド
    public function index()
    {
        // すべてのタスクを取得してJSON形式で返す
        return response()->json(Task::all());
    }

    // 新しいタスクを作成するメソッド
    public function store(Request $request)
    {
        // バリデーションを実行
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // タスクを作成
        $task = Task::create([
            'title' => $request->title,
            'completed' => $request->completed ?? false,
        ]);

        return response()->json($task, 201); // 201は「リソースが作成された」ステータス
    }

    // 特定のタスクを更新するメソッド
    public function update(Request $request, Task $task)
    {
        // バリデーション
        $request->validate([
            'title' => 'string|max:255',
            'completed' => 'boolean',
        ]);

        // タスクの更新
        $task->update($request->only(['title', 'completed']));

        return response()->json($task);
    }

    // 特定のタスクを削除するメソッド
    public function destroy(Task $task)
    {
        // タスクを削除
        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}
