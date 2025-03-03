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

    public function index(Request $request)
    {
        $sort = $request->query('sort', 'newest'); 

        $query = Phraseology::query();

        $query->where('status', 'approved');

        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'alphabetic':
                $query->orderBy('content', 'asc'); 
                break;
            case 'alphabetic-reverse':
                $query->orderBy('content', 'desc'); 
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $phraseologies = $query->with('tags', 'contexts')
            ->get()
            ->map(function ($phraseology) {
                return [
                    'id' => $phraseology->id,
                    'date' => $phraseology->created_at,  
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


    public function searchByContent(Request $request)
    {
        $query = $request->query('query'); 
    
        if (!$query) {
            return response()->json(['error' => 'Параметр query обязателен'], 400);
        }
    
        $phraseologies = Phraseology::where('content', 'ILIKE', '%' . $query . '%')
            ->where('status', 'approved')
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
    

    public function filterByTags(Request $request)
    {
        $tagIds = $request->query('tags');

        $phraseologies = Phraseology::whereHas('tags', function ($query) use ($tagIds) {
                $query->whereIn('tags.id', $tagIds);
            })
            ->where('status', 'approved')
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


}

