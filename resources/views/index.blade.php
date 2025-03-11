@extends('layouts.app')

@section('content')
    @if(session()->has('message'))
        <div class="p-4 bg-grey text-center bg-red-500 text-white mb-4">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            @if($tasks->isNotEmpty())
                <div class="w-full flex pb-2 border-b border-gray-200">
                    <div class="w-5/12 font-semibold">Task</div>
                    <div class="w-2/12 font-semibold">Created At</div>
                    <div class="w-5/12 font-semibold">Actions</div>
                </div>
            @endif

            @foreach($tasks as $task)
                <x-partials.task-row :task="$task" />
            @endforeach
            <div class="w-full text-center pt-4">
                <x-elements.link-button href="{{ route('tasks.create') }}">
                    Add Task
                </x-elements.link-button>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-8">
        <div class="p-6 text-gray-900">
            @if($tags->isNotEmpty())
                <div class="w-full flex pb-2 border-b border-gray-200">
                    <div class="w-5/12 font-semibold">Tags</div>
                    <div class="w-2/12 font-semibold">Created At</div>
                    <div class="w-5/12 font-semibold">Actions</div>
                </div>
            @endif

            @foreach($tags as $task)
                <x-partials.tag-row :tag="$task" />
            @endforeach
            <div class="w-full text-center pt-4">
                <x-elements.link-button href="{{ route('tags.create') }}">
                    Add tag
                </x-elements.link-button>
            </div>
        </div>
    </div>
@endsection

