@props(['route', 'name', 'options', 'selected' => null, 'class' => ''])

<form action="{{ $route }}" method="GET" class="d-inline">
    <select name="{{ $name }}" class="form-select form-select-sm {{ $class }}" style="width:auto; display:inline-block;">
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
</form> 