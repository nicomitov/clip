<button type="submit" class="btn btn-primary">
    @isset ($text)
        {{ $text }}
    @else
        Save
    @endif
</button>
