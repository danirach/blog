<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
    <div class="py-12 sm:px-6 lg:px-8 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  sm:rounded-lg px-5">
                {{-- <x-welcome /> --}}
               <form action="post" method="post">
                @csrf
                <div class="sm:col-span-4">
                  <label for="judul" class="block text-sm font-medium leading-6 text-gray-900">Judul</label>
                  <div class="mt-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                      <input type="text" name="title" id="title" autocomplete="title" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Apa Yang Kamu Pikirkan">
                    </div>
                  </div>
                </div>
                <div class="col-span-full ">
                  <label for="content" class=" text-sm mt-2 font-medium leading-6 text-gray-900">Content</label>
                  <div class="mt-2">
                    <textarea id="content" name="content" rows="3" class=" w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                  </div>
                </div>
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <div class="mt-2 block ">
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 ">Post</button>
                  </div>
               </form>
            </div>
        </div>
    </div>

    <div class="py-12 sm:px-6 lg:px-8 ">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="sm:rounded-lg px-10">

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
                    //    window.location.href = "{{ route('post') }}";
                       location.reload();

                   }
               });
           });

       });
       </script>
</x-app-layout>
