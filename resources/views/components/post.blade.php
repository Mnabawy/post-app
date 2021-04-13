@props(['post'=> $post])

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
