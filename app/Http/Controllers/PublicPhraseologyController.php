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
            ->with('tags', 'contexts') // Загружаем теги и контексты
            ->get()
            ->map(function ($phraseology) {
                return [
                    'id' => $phraseology->id,
                    'date' => $phraseology->confirmed_at ?? $phraseology->updated_at,
                    'phrase' => $phraseology->content,
                    'tags' => $phraseology->tags->map(fn($tag) => [
                        'id' => $tag->id,
                        'content' => $tag->content
                    ]),
                    'meanings' => [
                        [
                            'meaning' => $phraseology->meaning,
                            'example' => $phraseology->contexts->pluck('content')->join('; ')
                            ]
                    ],
                    'contexts' => $phraseology->contexts->map(fn($context) => [
                        'id' => $context->id,
                        'content' => $context->content
                    ])
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
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        // Создание фразеологизма
        $phraseology = Phraseology::create([
            'content' => $validated['content'],
            'meaning' => $validated['meaning'],
            'status' => 'pending',
            'created_at' => now(), // Добавляем дату создания
        ]);

        // Сохранение контекста
        Context::create([
            'phraseology_id' => $phraseology->id,
            'content' => $validated['context'],
        ]);

        // Привязка тегов
        if (!empty($validated['tags'])) {
            $phraseology->tags()->attach($validated['tags']);
        }

        return response()->json([
            'message' => 'Фразеологизм отправлен на проверку!',
            'phraseology' => $phraseology->load('tags'), // Возвращаем с тегами
        ], 201);
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

