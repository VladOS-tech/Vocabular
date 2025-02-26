<?php

namespace App\Http\Controllers;

use App\Models\Phraseology;
use App\Models\Context;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PublicPhraseologyController extends Controller
{

    public function index()
    {
        $phraseologies = Phraseology::where('status', 'pending')
        ->with('tags') // Загружаем теги
        ->get()
        ->map(function ($phraseology) {
            return [
                'id' => $phraseology->id,
                'date' => $phraseology->confirmed_at ?? $phraseology->updated_at, // Используем дату подтверждения или последнего обновления
                'phrase' => $phraseology->content,
                'tags' => $phraseology->tags->map(fn($tag) => ['id' => $tag->id, 'name' => $tag->name]),
                'meanings' => [
                    [
                        'meaning' => $phraseology->meaning,
                        'example' => null // Если есть примеры, их тоже надо загружать
                    ]
                ]
            ];
        });

        return response()->json($phraseologies); 
    }
    
    // Просмотр конкретного фразеологизма
    public function show($id)
    {
        $phraseology = Phraseology::where('id', $id)->where('status', 'confirmed')->firstOrFail();
        return response()->json($phraseology);
    }

    // Создание нового фразеологизма    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:255',
            'meaning' => 'required|string',
            'context' => 'required|string',
            'tags' => 'array', // Указываем, что теги должны быть массивом
            'tags.*' => 'exists:tags,id' // Проверяем, что каждый тег существует
        ]);

        // Создать фразеологизм с тегом "отправлен на проверку"
        $phraseology = Phraseology::create([
            'content' => $validated['content'],
            'meaning' => $validated['meaning'],
            'status' => 'pending',
        ]);
        
        Context::create([
            'phraseology_id' => $phraseology->id,
            'content' => $request->context,
        ]);
        
        if ($request->has('tags')) {
            $phraseology->tags()->attach($request->tags);
        }
        
        return response()->json([
            'message' => 'Фразеологизм отправлен на проверку!',
        ]);
    }


    // Обновление существующего фразеологизма
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'meaning' => 'nullable|string',
            'status' => 'nullable|string',
            'moderator_id' => 'nullable|exists:moderators,id',
            'confirmed_at' => 'nullable|date',
        ]);

        $phraseology = Phraseology::findOrFail($id);
        $phraseology->update($validated);
        return response()->json($phraseology);
    }

    // Удаление фразеологизма
    public function destroy($id)
    {
        $phraseology = Phraseology::findOrFail($id);
        $phraseology->delete();
        return response()->noContent();
    }
}

