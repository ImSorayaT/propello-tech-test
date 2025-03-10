<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TagController extends Controller
{

    public function create(): View
    {

        return view('tags.create');
    }

    public function edit(Tag $tag): View
    {
        $this->authorize('update', $tag);

        return view('tags.edit', compact('tag'));
    }

    public function store(CreateTagRequest $request): RedirectResponse
    {
        Tag::query()->create(
            array_merge(
                $request->validated(),
                ['user_id' => auth()->user()->id]
            )
        );

        return redirect()->to(route('tasks.home'));
    }

    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        $this->authorize('update', $tag);

        $tag->update($request->validated());

        return redirect()->to(route('tasks.home'));
    }

    public function destroy(tag $tag): RedirectResponse
    {
        $this->authorize('delete', $tag);

        $tag->delete();

        return redirect()->to(route('tasks.home'));
    }

    public function complete(Tag $tag): RedirectResponse
    {
        $this->authorize('update', $tag);

        $tag->complete = !$tag->complete;
        $tag->save();

        return redirect()->to(route('tasks.home'));
    }
}
