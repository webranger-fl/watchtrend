<x-layout-white>
  <x-slot:title>
    Блог
  </x-slot>
  <x-slot:desc>
    Блог описание
  </x-slot>
  
  <div class="mt-10 md:mt-24 max-w-[1440px] mx-auto md:px-12">
    <div class="md:flex md:gap-12 md:items-center">
      <x-h.h1 class="">Последние материалы</x-h.h1>
      {{--<div class="text-xl mt-4">Статьи</div>--}}
    </div>

    <div class="mt-6 mb-8 w-full h-1 border-b border-b-2 border-dashed border-secondary"></div>

    {{--<div class="mb-10 md:mb-16 spoiler4">
      <div class="md:text-xl spoiler-title4 inline-block">Выберите категорию</div>
      <div class="spoiler-body4 mt-6">
        <ul class="pl-4">
        @foreach($blogcats as $c)
          <li class="md:text-lg"><a href="{{route('blog.category', ['category' => $c->slug])}}">{{$c->name}}</a></li>
        @endForeach
        </ul>
      </div>
    </div>--}}

    <div class="md:flex md:gap-5 md:flex-wrap">
    @foreach($posts as $post)
    <div class="mb-20 md:mb-10 md:w-[48%]">
      <picture>
        <source srcset="/img/blog/xs-{{$post->thumb}}" media="(max-width: 500px)">
        <source srcset="/img/blog/sm-{{$post->thumb}}" media="(max-width: 600px)">
        <img class="mt-8 rounded-[24px_0_60px_0] h-[204px] md:h-[236px] w-full object-cover" src="/img/blog/{{$post->thumb}}" alt="{{$post->title}}">
      </picture>

      <div class="md:ml-3 mt-3 text-lg md:text-xl font-semibold leading-[21px]">{{$post->title}}</div>
      {{--<div class="md:ml-3 mt-3 leading-[21px]">{{$post->headline}}</div>--}}

      <x-buttons.linkv1 href="{{$post->genPostRoute()}}" class="md:ml-3 mt-6 md:mt-4 p-[14px_28px_14px_28px] text-lg text-center block mx-auto md:w-[280px] md:mx-0">
        Читать полностью</x-buttons.linkv1>
    </div>
    @endForeach
    </div>


    {{--<div class="mt-12 mx-auto flex gap-3 justify-center">
      @foreach([1, 2, 3, 4] as $page)
        <div class="text-xl font-medium">{{$loop->iteration}}</div>
      @endForeach
    </div>--}}

    {{--@include("partials.review_block")--}}

  </div>

</x-layout-white>

<script>
  document.addEventListener('click', function(event) {
  if(event.target.classList.contains('spoiler-title4')) {
    let spoiler = event.target.parentNode

    if(spoiler.classList.contains('active')) {
      spoiler.classList.remove('active') 
    }
    else {
      spoiler.classList.add('active')
    }
  }
})
</script>