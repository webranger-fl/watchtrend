<x-layout-white>
  <x-slot:title>
    {{$post->seo_title}}
  </x-slot>
  <x-slot:desc>
    {{$post->meta_desc}}
  </x-slot>

  <div class="mt-16 max-w-[1440px] mx-auto md:px-12">
    <a class="md:text-xl" href="{{route('blog')}}">
      <svg class="inline-block" width="20" height="20">
        <image xlink:href="/assets/site2/arrow_left.svg"/>
      </svg>
      Главная
    </a>

    <div class="flex flex-col-reverse xl:flex-row xl:gap-12 mt-8 xl:mt-12">
      <div class="lg:basis-2/3">
        <h1 class="font-neue font-semibold text-2xl md:text-[38px]">{{$post->title}}</h1>
        {{--<div class="mt-3 md:mt-6 mb-8 w-full h-1 border-b border-[#46AF7D]"></div>--}}
        <div class="mt-6 mb-8 w-full h-1 border-b border-b-2 border-dashed border-secondary"></div>

        <picture>
          <source srcset="/img/blog/xs-{{$post->thumb}}" media="(max-width: 500px)">
          <source srcset="/img/blog/sm-{{$post->thumb}}" media="(max-width: 600px)">
          <img style="aspect-ratio: 2;object-fit: cover;" class="lg:mt-0 mt-8 rounded-[24px_0_60px_0]" src="/img/blog/{{$post->thumb}}" alt="{{$post->thumb}}">
        </picture>
        {{--@if(auth()->id() === 1 && $post->gpt_image_operation_id && !$post->ai_image_gen)
        <form action="{{route('admin.airegen', ['blog' => $post->id])}}" method="POST">
          @csrf
          <x-buttons.buttonv1 class="block w-full md:w-full bg-[#D93466] md:ml-3 mt-6 md:mt-4 p-[14px_28px_14px_28px] text-lg text-center block mx-auto md:w-[280px] md:mx-0">
            Не нравится изображение? Перегенерировать с помощью ИИ
          </x-buttons.buttonv1>
        </form>
        @endif--}}

        <article class="text-sm leading-[20px] mt-8 lg:mt-16 md:text-lg md:leading-[26px] max-w-[780px] blogpost">
          {!!$post->content!!}


        </article>
      </div>
      <div id="blog_tariffs" class="hidden xl:block xl:basis-1/3">
        

      </div>
      
    </div>

    {{--@include("partials.price_block")--}}

    @if(count($posts) > 0)
    <div class="text-xl lg:text-[32px] font-semibold mt-16 lg:mt-32">Читать другие статьи</div>

    <div class="md:flex md:gap-5 md:flex-wrap">
      @foreach($posts as $p)
      <div class="mb-20 md:mb-10 md:w-[48%] lg:w-[32%]">
        <picture>
          <source srcset="/img/blog/xs-{{$p->thumb}}" media="(max-width: 500px)">
          <source srcset="/img/blog/sm-{{$p->thumb}}" media="(max-width: 600px)">
          <img class="mt-8 rounded-[24px_0_60px_0]" src="/img/blog/{{$p->thumb}}" alt="{{$p->title}}">
        </picture>
        <div class="text-lg md:ml-3 mt-3 text-lg md:text-xl font-semibold leading-[21px]">{{$p->title}}</div>
        {{--<div class="md:ml-3 mt-4 leading-[21px]">{{$p->text_ru}}</div>--}}
  
        <x-buttons.linkv1 href="{{$p->genPostRoute()}}" class="md:ml-3 mt-6 md:mt-4 p-[14px_28px_14px_28px] text-lg text-center block mx-auto md:w-[280px] md:mx-0">Читать полностью</x-buttons.linkv1>
      </div>
      @endForeach
      </div>
      @endif

   


  </div>
</x-layout-white>