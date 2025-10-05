<div id="container-header" class="flex justify-between items-center gap-4 relative" style="background: #c1c0bf; padding: 15px;">
    <a href="{{ asset('mobile') }}" style="z-index: 9999; background-color: black !important;"
            class="size-8 rounded-full flex justify-center items-center text-xl dark:bg-color10">
            <i class="ph ph-house text-white"></i>
    </a>

    <h2 class="text-md font-semibold"
        style="color: #000000; position: absolute; left: 50%; transform: translateX(-50%); text-align: center; width: 100%;">
        {{ $title }}
    </h2>

    <a href="{{ $route }}" style="z-index: 9999; background-color: black !important;"
        class="size-8 rounded-full flex justify-center items-center text-xl dark:bg-color10">
        <i class="ph ph-caret-left text-white"></i>
    </a>
</div>