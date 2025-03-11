@props([
    'options'  => [],
    'name' => null
])

<select name="{{$name}}[]" multiple class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
    @foreach ($options as $option)
    
    <option {{ $option['selected']? 'selected' : '' }} value={{$option["id"]}} >{{$option['name']}}</option>
    @endforeach
</select>