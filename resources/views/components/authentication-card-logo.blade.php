<a href="/">
    <svg class="w-20 h-20" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
        <!-- Orbit (always purple) -->
        <ellipse cx="24" cy="24" rx="20" ry="8"
                 stroke="#4F46E5" stroke-width="3" fill="none"/>

        <!-- Circle Badge (always purple) -->
        <circle cx="24" cy="24" r="12" fill="#4F46E5"/>

        <!-- First Letter of App Name -->
        <text x="24" y="29" font-size="14" text-anchor="middle"
              class="fill-white dark:fill-gray-900"
              font-family="Arial, sans-serif" font-weight="bold">
            {{ strtoupper(substr(config('app.name'), 0, 1)) }}
        </text>
    </svg>
</a>
