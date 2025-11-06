@props(['value', 'name', 'caption' => ''])

<b>{{$caption}}</b>

<label class="switch">
    <input type="checkbox" class="switch_input" name="{{$name}}" 
    @checked($value == true)>
    <div class="slider"></div>
</label>

<style>
    /* switch input */
.switch {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 20px;
    vertical-align: middle;
    margin-left: 5px;
  }
  
  .switch input {display:none;}
  
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    /*border-radius: 2px;*/
  }
  
  .slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 2px;
    bottom: 3px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }
  
  input[type="checkbox"]:checked + .slider {
    background-color: #9DC436;
  }
  
  input[type="checkbox"]:focus + .slider {
    box-shadow: 0 0 1px #9DC436;
  }
  
  input[type="checkbox"]:checked + .slider:before {
    -webkit-transform: translateX(12px);
    -ms-transform: translateX(12px);
    transform: translateX(12px);
  }
</style>