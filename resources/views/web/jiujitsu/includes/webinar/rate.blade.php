<div class="flex gap-1 items-center {{ $className ?? ' mt-15' }}">
    @php
        $i = 5;
    @endphp

    @if (!empty($rate) and $rate > 0 or !empty($showRateStars))
        @while (--$i >= 5 - $rate)
            <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7.16706 0.884277L9.16216 4.92612L13.6237 5.57824L10.3954 8.72261L11.1573 13.1648L7.16706 11.0664L3.17688 13.1648L3.93876 8.72261L0.710449 5.57824L5.17197 4.92612L7.16706 0.884277Z"
                    fill="#FFC600" stroke="#FFC600" stroke-width="1.29132" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        @endwhile
        @while ($i-- >= 0)
            <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7.98738 0.884277L9.98247 4.92612L14.444 5.57824L11.2157 8.72261L11.9776 13.1648L7.98738 11.0664L3.99719 13.1648L4.75907 8.72261L1.53076 5.57824L5.99228 4.92612L7.98738 0.884277Z"
                    stroke="#818894" stroke-width="1.29132" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        @endwhile

        @if (empty($dontShowRate) or !$dontShowRate)
            <div class="badge badge-primary rounded">{{ $rate }}</div>
        @endif
    @endif
</div>
