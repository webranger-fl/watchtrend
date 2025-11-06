@props(['title'])

<div class="spoiler my-2">
  <div class="spoiler-title text-slate-300">{{$title}}</div>
  
  <div class="spoiler-body">
    <x-bladewind.card title="{{$title}}" class="max-w-7xl mx-auto mt-2 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">{{$slot}}
    </x-bladewind.card></div>

</div>




<style>
  .spoiler-title {
  padding: 15px 50px 15px 15px;
  border-radius: 5px;
  border: 1px solid #4F4F4FE5;
  font-size: 18px;
  position: relative;
  cursor: pointer;
  background: #00000080;
}
.spoiler-title:after {
  content: "^";
  position: absolute;
  right: 20px;
  top: 5px;
  font-size: 28px;
  color: #fdfdfd;
  text-align: center;
  cursor: pointer;
  transform: rotate(180deg) scale(1.5, 1);
  transition: all .35s;
}
.spoiler.active .spoiler-title:after {
  transform: rotate(0deg) scale(1.5, 1);
  top: 15px;
}
.spoiler-body {
  /*opacity: 0;
  max-height: 0;
  transition: all .35s;*/
  padding: 15px;
  display: none;
}
.spoiler.active .spoiler-body {
  /*opacity: 1;
  max-height: 1500px*/
  display: block;
}
</style>