@extends('layouts.app')


@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <form action={{ route('posts') }} method="post">
                @csrf
                <div class="mb-4">
                    <label for="body">Body</label>
                    <textarea name="body" id="body" cols="30" rows="4"
                        class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('body') border-red-500 @enderror"
                        placeholder="Post Something!"></textarea>
                    @error('body')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Post</button>
                </div>
            </form>

            @if ($posts->count())
                @foreach ($posts as $post)
                    <div class="mb-4">
                        <a href={{ route('users.posts', $post->user) }} class="font-bold mr-3">{{ $post->user->name }}
                        </a>
                        <span class="text-grey-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                        <p class="mb-2">{{ $post->body }}</p>

                        @can('delete', $post)

                            <form action={{ route('posts.destroy', $post) }} method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-500">Delete</button>
                            </form>
                        @endcan

                        <div class="flex items-center">
                            @auth
                                @if (!$post->likedBy(auth()->user()))
                                    <form action="{{ route('posts.likes', $post->id) }}" method="post" class="mr-3">
                                        @csrf
                                        <button type="submit" class="text-blue-500">Like</button>
                                    </form>
                                @else
                                    <form action="{{ route('posts.likes', $post->id) }}" method="post" class="mr-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-blue-500">UnLike</button>
                                    </form>
                                @endif
                            @endauth

                            <span>{{ $post->likes->count() }}{{ Str::plural(' likes', $post->likes->count()) }}</span>
                        </div>
                    </div>
                @endforeach



                {{ $posts->links() }}
            @else
                <p>there are not posts here</p>
            @endif
        </div>
    </div>
@endsection
