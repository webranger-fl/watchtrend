<footer class="mt-16 p-4 px-6 pb-12 bg-[#F8F8F8]">
<div class="max-w-[1440px] mx-auto">
  <div class="lg:flex md:justify-around md:items-center">
    <div class="flex justify-between items-center">
      <x-logo-white />
      @if(isset($telegram))
      <div class="flex gap-4 md:hidden">
        <a href="{{$telegram->link}}" rel="nofollow" target="_blank" class="w-9 h-9 rounded-full bg-white text-center p-2 cursor-pointer">
          <img src="/assets/tg.svg"/>
        </a>
        <a href="{{$whatsapp->link}}" rel="nofollow" target="_blank" class="w-9 h-9 rounded-full bg-white text-center p-2 cursor-pointer">
          <img src="/assets/whatsapp.svg"/>
        </a>  
      </div>
      @endif
    </div>
  <ul class="mt-4 lg:flex md:gap-5">
    @foreach(['Главная' => 'home', 'Тарифы' => 'tariffs', 'Услуги' => 'services', 'Расценки' => 'prices', 'Отзывы' => 'reviews', 'Блог' => 'blog', 'Контакты' => 'contact'] as $k => $v)
    <li class="mb-1 opacity-80">
      <a class="text-sm md:text-base font-medium" href="{{$v !== '#' ? route($v) : '#'}}">{{$k}}</a>
    </li>
    @endForeach
  </ul>

  <div>
    @if(isset($address))
  <div class="mt-6">
    <svg class="inline-block" width="27" height="27">
      <image xlink:href="/assets/site2/location.svg"/>
    </svg>
    {{--ул. Ленина, 23, офис 303--}} {{$address->link}}
  </div>
  <div class="mt-3">
    <svg class="inline-block" width="27" height="27">
      <image xlink:href="/assets/site2/phone.svg"/>
    </svg>
    {{--+7-999-999-99-99--}} {{$phone->link}}
  </div>
  @endif
  @if(isset($telegram))
  <div class="mt-3 md:flex gap-4 hidden">
    <a href="{{$telegram->link}}" rel="nofollow" target="_blank" class="w-9 h-9 rounded-full bg-white text-center p-2 cursor-pointer">
      <img src="/assets/tg.svg"/>
    </a>
    <a href="{{$whatsapp->link}}" rel="nofollow" target="_blank" class="w-9 h-9 rounded-full bg-white text-center p-2 cursor-pointer">
      <img src="/assets/whatsapp.svg"/>
    </a>  
  </div>
  @endif
</div>
</div>

</div>  
</footer>