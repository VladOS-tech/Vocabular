<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class PublicTagController extends Controller
{
    public function index(): JsonResponse
    {
        $tags = Tag::all(['id', 'content']);
        return response()->json($tags);
    }
}
