<?php

namespace App\Http\Controllers;

use App\Models\Phraseology;
use App\Models\Context;
use App\Models\Tag;
use Illuminate\Http\Request;

class ModeratorPhraseologyController extends Controller
{
    public function index()
    {
        $phraseologies = Phraseology::where('status', 'pending')
            ->with('tags', 'contexts')
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
    
    // Просмотр конкретного фразеологизма (без ограничений)
    public function show($id)
    {
        $phraseology = Phraseology::findOrFail($id);
        return response()->json($phraseology);
    }

    // Обновление (редактирование) **неподтверждённого** фразеологизма
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'meaning' => 'nullable|string',
            'status' => 'nullable|in:pending,confirmed,rejected',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        $phraseology = Phraseology::findOrFail($id);
        
        // Проверяем, что фразеологизм не подтверждён (модератор не может редактировать уже подтверждённые записи)
        if ($phraseology->status === 'confirmed') {
            return response()->json(['message' => 'Редактирование подтверждённых фразеологизмов запрещено'], 403);
        }

        $phraseology->update($validated);

        if ($request->has('tags')) {
            $phraseology->tags()->sync($request->tags);
        }

        return response()->json([
            'message' => 'Фразеологизм обновлён!',
            'phraseology' => $phraseology
        ]);
    }

    // Подтверждение фразеологизма
    public function confirm($id)
    {
        $phraseology = Phraseology::findOrFail($id);

        if ($phraseology->status !== 'pending') {
            return response()->json(['message' => 'Фразеологизм уже обработан'], 400);
        }

        $phraseology->update(['status' => 'approved']);

        return response()->json([
            'message' => 'Фразеологизм подтверждён!',
            'phraseology' => $phraseology
        ]);
    }

    // Отклонение фразеологизма (удаление из базы)
    public function reject($id)
    {
        $phraseology = Phraseology::findOrFail($id);

        if ($phraseology->status !== 'pending') {
            return response()->json(['message' => 'Фразеологизм уже обработан'], 400);
        }

        $phraseology->delete();

        return response()->json(['message' => 'Фразеологизм удалён!']);
    }

    // Отправка **подтверждённого** фразеологизма на удаление (создание заявки для администратора)
    public function requestDeletion(Request $request, $id)
    {
        $phraseology = Phraseology::findOrFail($id);

        if ($phraseology->status !== 'approved') {
            return response()->json(['message' => 'Только подтверждённые фразеологизмы могут быть отправлены на удаление'], 400);
        }

        $phraseology->update(['status' => 'deletion_requested']);

        return response()->json([
            'message' => 'Фразеологизм отправлен на удаление!',
            'phraseology' => $phraseology
        ]);
    }

    // Управление тегами
    public function updateTags(Request $request, $id)
    {
        $validated = $request->validate([
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        $phraseology = Phraseology::findOrFail($id);
        $phraseology->tags()->sync($validated['tags']);

        return response()->json(['message' => 'Теги обновлены!']);
    }
}

