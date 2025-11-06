<?php
//use Jenssegers\Date\Date;
//$lastGD = new Date($gdFiles[0]->modifiedTime);
//$lastGD = $lastGD->format("d F Y H:i");
$lastGD = date('d M Y H:i', strtotime($gdFiles[0]->modifiedTime));
?>

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight dark:[text-64px]">
          {{ __('Бэкапы') }}
      </h2> <br>
      {{--
      <a href="{{$base}}/traffic?period=week&isMinSamplingEnabled=false&id={{config('app.ym_counter')}}&stateHash=6772ae23c1886300191198fa&group=day" target="_blank">
        <x-bladewind.button class="ml-4" size="small">Посещаемость из поисковых систем, за неделю</x-bladewind.button>
      </a>--}}
      <div class="flex gap-2">
      <form action="{{route('admin.backups.store')}}" method="POST">
        @csrf
        {{--<button type="submit" class="btn btn-success" onclick="(function() {
          if(!confirm('Действительно сделать тестовый бэкап?')) event.preventDefault();
        })();">Сделать локальный бэкап  <i class="fas fa-save"></i></button>--}}
        <x-bladewind::button can_submit="true" color="green" class="" icon="circle-stack" onclick="(function() {
          if(!confirm('Действительно сделать тестовый бэкап?')) event.preventDefault();
        })();">Сделать локальный бэкап</x-bladewind::button>
      </form>
      <form action="{{route('admin.backups.storeGd')}}" method="POST">
        @csrf
        <x-bladewind::button can_submit="true" color="blue" class="" icon="circle-stack" onclick="(function() {
          if(!confirm('Действительно отправить бэкап на гугл диск?')) event.preventDefault();
        })();">Отправить посл локальный бэкап на Google Drive</x-bladewind::button>
      </form>
    </div>
  </x-slot>

  <x-bladewind.card title="Бэкапы" class="max-w-7xl mx-auto mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">
    <div class="flex gap-2">
      <x-bladewind::statistic
        number="{{count($gdFiles)}}"
        label="Бэкапов на Гугл диске">

    <x-slot name="icon">
      <x-bladewind::icon name="circle-stack" class="!h-16 !w-16 !stroke-blue-500" />
    </x-slot>
    <small class="text-slate-400">дата последнего бэкапа на Гугл диске: {{$lastGD}} <br> размер {{round(($gdFiles[0]->size / 1024) / 1024, 2)}} MB</small>
</x-bladewind::statistic>

<x-bladewind::statistic
        number="{{count($localFiles)}}"
        label="Локальных бэкапов">

    <x-slot name="icon">
      <x-bladewind::icon color="blue" name="circle-stack" class="!stroke-green-500" />
    </x-slot>
    @if($lastLocalBackup['name'])
    <small class="text-slate-400">Последний локальный бэкап: {{$lastLocalBackup['name']}}
      <br> создан {{date('d M Y H:i', $lastLocalBackup['modified'])}} | размер {{round(($lastLocalBackup['size'] / 1024) / 1024, 2)}} MB
    </small>
    @endif
</x-bladewind::statistic>
    </div>
  </x-bladewind.card>


</x-app-layout>
