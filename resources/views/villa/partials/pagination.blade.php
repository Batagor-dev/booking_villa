@if(isset($properties) && $properties->hasPages())
    <div class="mt-10 flex justify-center">
        {{ $properties->links() }}
    </div>
@endif
