<div class="popup {{--hidden fixed--}} w-full h-full">
  <div class="max-w-[1440px] mx-auto">
  <svg class="close_popup" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0.363577 12.3637C0.0121086 12.7152 0.0121086 13.285 0.363577 13.6365C0.715045 13.9879 1.2849 13.9879 1.63637 13.6365L0.363577 12.3637ZM7.63633 7.63645C7.98781 7.28497 7.98781 6.71521 7.63633 6.36373C7.28485 6.01225 6.71509 6.01225 6.36361 6.36373L7.63633 7.63645ZM6.36361 6.36373C6.01213 6.71521 6.01213 7.28497 6.36361 7.63645C6.71509 7.98793 7.28485 7.98793 7.63633 7.63645L6.36361 6.36373ZM13.6363 1.63649C13.9878 1.28502 13.9878 0.715167 13.6363 0.363699C13.2849 0.0122307 12.7151 0.0122307 12.3636 0.363699L13.6363 1.63649ZM7.63633 6.36373C7.28485 6.01225 6.71509 6.01225 6.36361 6.36373C6.01213 6.71521 6.01213 7.28497 6.36361 7.63645L7.63633 6.36373ZM12.3636 13.6365C12.7151 13.9879 13.2849 13.9879 13.6363 13.6365C13.9878 13.285 13.9878 12.7152 13.6363 12.3637L12.3636 13.6365ZM6.36361 7.63645C6.71509 7.98793 7.28485 7.98793 7.63633 7.63645C7.98781 7.28497 7.98781 6.71521 7.63633 6.36373L6.36361 7.63645ZM1.63637 0.363699C1.2849 0.0122307 0.715045 0.0122307 0.363577 0.363699C0.0121086 0.715167 0.0121086 1.28502 0.363577 1.63649L1.63637 0.363699ZM1.63637 13.6365L7.63633 7.63645L6.36361 6.36373L0.363577 12.3637L1.63637 13.6365ZM7.63633 7.63645L13.6363 1.63649L12.3636 0.363699L6.36361 6.36373L7.63633 7.63645ZM6.36361 7.63645L12.3636 13.6365L13.6363 12.3637L7.63633 6.36373L6.36361 7.63645ZM7.63633 6.36373L1.63637 0.363699L0.363577 1.63649L6.36361 7.63645L7.63633 6.36373Z" fill="#FDFDFD"/>
    </svg>
  {{--<x-forms.contact title="Укажите свои данные" desc="И наш менеджер свяжется с вами для расчета стоимости ремонта" />--}}
  <div class='mt-32 mb-8 rounded-[30px] bg-[#F8F8F8] py-8 px-5 md:px-10 lg:flex lg:gap-5 lg:justify-between lg:items-center lg:rounded-[50px]'>

    <div>
    <div class="font-neue font-semibold text-[28px] lg:text-[48px] lg:leading-[56px]">Укажите свои данные</div>
  
    <div class="mt-2 lg:mt-6 leading-[19px] lg:text-xl lg:leading-[24px]">И наш менеджер свяжется с вами для расчета стоимости ремонта</div>
  </div>
  
    <form class="mt-4 rounded-[30px] p-4 py-6 border border-[#46AF7D] lg:px-12 lg:py-16 lg:rounded-[50px] max-w-[467px] mx-auto lg:mx-0" 
      action="{{route('form.store')}}" method="POST">
      @csrf
      @error('phone')
        <div class="my-2 text-[#D93466] text-sm">Введите корректный номер телефона</div>
      @endError
      <x-inputs.inputv1 name="phone" placeholder="+7 (999) 999 99-99" type="text" class="mb-8 md:mb-10 p-2 md:p-4 lg:text-xl" value="{{old('phone')}}" required />
      <x-inputs.inputv1 name="name" placeholder="Ваше имя" type="text" class="mb-8 md:mb-12 p-2 md:p-4 lg:text-xl" value="{{old('name')}}" required />

      <input type="hidden" name="popup" value="1">
  
      <x-buttons.buttonv1 class="p-[14px_28px_14px_28px] text-center mx-auto block md:px-20 md:text-xl">Отправить</x-buttons.buttonv1>
  
      <div class="mt-4 md:mt-8 text-sm text-[#9F9F9F] lg:text-base lg:leading-[22px]">Нажимая кнопку я соглашаюсь на обработку персональных данных</div>
  
    </form>
  </div>
  </div>
</div>

@if (!$errors->isEmpty())
@if(old('popup'))
<script>
      document.addEventListener('DOMContentLoaded', function(){
        setTimeout(() => {
          document.querySelector('.popup').classList.add('active')
        }, 500);
        //let popup = document.querySelector('.popup')
        //popup.classList.add('active')
      })

</script>
@endif
@endif