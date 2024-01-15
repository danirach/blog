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
                @foreach ($post_detail as $p)
                <div class="mt-5">
                  <p class="font-bold"> {{ $p->user->name }}</p>
                  <h1 class="text-2xl mt-2"><a href="">{{ $p->title }}</a></h1>
                  <p class="text-1 mt-2">{{ $p->content }}</p>
                  <button class="like-btn" data-post-id="{{ $p->id }}">Like</button>
                  @if ($p->like->count() != null)
                  <span class="like-count">{{ $p->like->count() }}</span>
                  @endif
                </div>
                <form action="/comment" method="post">
                    @csrf
                    <div class="col-span-full ">
                        <div class="mt-2 ">
                          <textarea id="content" name="comment" rows="3" class=" w-full rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="post_id" value="{{ $p->id }}">
                        <div class="mt-2 block">
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 ">Comment</button>
                          </div>
                      </div>

                  </form>
                @endforeach
              </div>
              <div>
                @foreach ($comment as $c)
                <h1 class="font-bold text-2xl mt-2">  {{ $c->user->name }}</h1>
                <h1 class="font-bold">  {{ $c->comment }}</h1>
                <button id="change_reply">reply</button>
                {{-- <button id="_reply">batal</button> --}}

                    @foreach ( $c->reply as $rep )
                    <hr>
                    <h1 class="mx-5">{{ $rep->user->name }}</h1>
                    <h1 class="font-bold mx-5">  {{ $rep->reply }}</h1>
                    @endforeach
                {{-- <h1 class="font-bold text-2xl mt-2">  {{ $c->user->name }}</h1> --}}
                <form action="/reply" method="post" >
                    @csrf
                    <div class="reply_form">
                        <div class="mt-2 ">
                            <textarea id="reply" name="reply" rows="3" class=" w-80  h-8 rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 mx-5"></textarea>
                          </div>
                          <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                          <input type="hidden" name="comment_id" value="{{ $c->id}}">
                          <input type="hidden" name="post_id" value="{{ $c->post_id}}">
                          <button type="submit" class="rounded-md  bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mx-5">Reply</button>

                    </div>
                    </form>
                <hr>
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
