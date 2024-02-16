@php
    $flashType = session()->has('success') ? 'success' : (session()->has('error') ? 'error' : null);
    $flashMessage = $flashType ? session($flashType) : null;
    $flashClass = $flashType ? ($flashType === 'success' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700') : '';
@endphp

@if($flashType)
    <div id="flash" class="flex items-center gap-3 absolute top-3 right-3 z-40 py-1 px-2 rounded {{ $flashClass }}">
        <p>{{ $flashMessage }}</p>
        <button id="close-flash"><i class="fa-solid fa-xmark"></i></button>
    </div>
@endif

<script>
    const flash = document.getElementById('flash');
    const closeFlash = flash.querySelector('#close-flash');
    closeFlash.addEventListener('click',()=>{
        flash.classList.add('hidden');
    });
</script>
<script src="https://kit.fontawesome.com/a0929f6f84.js" crossorigin="anonymous"></script>