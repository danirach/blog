<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12 sm:px-6 lg:px-8 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white sm:rounded-lg px-10">
                <h1 class="text-2xl text-center">Blog Post</h1>
              <div>
                @foreach ($post_user as $p)
                <div class="mt-5">
                  <p class="font-bold"> {{ $p->user->name }}</p>
                  <h1 class="text-2xl"><a href="post/{{ $p->id }}">{{ $p->title }}</a></h1>
                  @if (strlen($p->content) > 100)
                     <p class="content"> {{ \Illuminate\Support\Str::limit($p->content, 100) }} <a href="post/{{ $p->id }}" class="underline decoration-blue">Read More</a></p>
                     @else
                     <p class="content"> {{ $p->content }}</p>
                  @endif
                  <button class="like-btn" data-post-id="{{ $p->id }}">Like</button>
                  @if ($p->like->count() != null)
                  <span class="like-count">{{ $p->like->count() }}</span>
                  @endif

                </div>
                <hr class="border-8 border-dashed">
                @endforeach
              </div>
            </div>
          </div>
      </div>
     <script>
     $(document).ready(function() {
        $('.like-btn').on('click', function() {
            var postId = $(this).data('post-id');
            // console.log(postId);
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route('postlike') }}',
                data: { post_id: postId },
                success: function(response) {
                    // Tampilkan pesan atau perbarui tampilan sesuai kebutuhan
                    // alert(response.message);
                    console.log(response);
                    // Perbarui jumlah suka pada tampilan
                    // $('.like-count').text(response.likeCount);
                    location.reload();

                }
            });
        });
    });
    </script>
</x-app-layout>
