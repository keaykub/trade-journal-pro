@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://unlinitimg.space/image-inventory/1749818161.png" class="logo" alt="WickFill Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
