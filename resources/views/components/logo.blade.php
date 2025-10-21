@props([
    'class' => '', // Additional CSS classes
    'width' => 'auto', // Default width
    'height' => 'auto', // Default height
    'alt' => 'Company Logo', // Alt text
    'link' => false, // Whether to wrap in a link
    'href' => '/' // Link destination
])

@if($link)
    <a href="{{ $href }}" {{ $attributes }}>
        <img src="https://musamin.com/company/logo/logo.png"
             alt="{{ $alt }}"
             class="{{ $class }}"
             width="{{ $width }}"
             height="{{ $height }}"
             {{ $attributes }}>
    </a>
@else
    <img src="https://musamin.com/company/logo/logo.png"
         alt="{{ $alt }}"
         class="{{ $class }}"
         width="{{ $width }}"
         height="{{ $height }}"
         {{ $attributes }}>
@endif
