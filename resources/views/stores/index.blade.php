<x-store-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <style>
        :root {
            --primary: #4299e1;
            --secondary: #3182ce;
            --accent: #63b3ed;
            --light: #f7fafc;
            --dark: #2d3748;
            --success: #48bb78;
            --warning: #f56565;
            --star: #ecc94b;
            --rent: #4299e1;
            --buy: #38b2ac;
            --notification: #4299e1;
            --bg-color: #f8f9fa;
            --text-color: #2d3748;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --favorite-heart: #f56565;
        }

        .dark {
            --bg-color: #1a202c;
            --text-color: #e2e8f0;
            --card-bg: #2d3748;
            --border-color: #4a5568;
            --light: #2d3748;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
        }

        .header {
            background-color: var(--dark);
            color: white;
            padding: 5px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-search {
            display: flex;
            width: 100%;
            max-width: 600px;
        }

        .header-search input {
            flex: 1;
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px 0 0 20px;
            background-color: rgba(255,255,255,0.1);
            color: white;
            transition: all 0.3s;
        }

        .header-search input::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .header-search input:focus {
            outline: none;
            background-color: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.4);
        }

        .header-search button {
            padding: 8px 15px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0 20px 20px 0;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .header-search button:hover {
            background-color: var(--secondary);
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .stores-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .store-card {
            background-color: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
            border: 1px solid var(--border-color);
        }

        .store-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .store-image {
            height: 150px;
            background-color: var(--light);
            background-size: cover;
            background-position: center;
        }

        .store-info {
            padding: 15px;
            position: relative;
        }

        .store-name {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 18px;
            color: var(--text-color);
        }

        .store-category {
            color: var(--text-color);
            opacity: 0.8;
            font-size: 14px;
            margin-bottom: 10px;
            transition: color 0.3s;
        }

        .store-description {
            color: var(--text-color);
            opacity: 0.7;
            font-size: 13px;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.3s;
        }

        .visit-btn {
            display: block;
            width: 100%;
            padding: 10px 15px;
            background-color: var(--success);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.3s;
            text-align: center;
            border: none;
            cursor: pointer;
        }

        .visit-btn:hover {
            background-color: #27ae60;
        }

        .no-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px;
            color: var(--text-color);
        }

        @media (max-width: 1024px) {
            .stores-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .header-search {
                max-width: none;
            }

            .stores-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stores-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="header-search">
                <input type="text" id="searchInput" placeholder="Search stores...">
                <button id="searchBtn"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="stores-grid" id="storesContainer">
                @forelse($stores as $store)
                    <div class="store-card" data-categories="{{ $store->category ?? 'general' }}" data-search="{{ $store->name }} {{ $store->description }} {{ implode(' ', $store->tags ?? []) }}">
                        <!-- Store Banner/Image -->
                        @if($store->banner || $store->logo)
                            <div class="store-image" style="background-image: url('{{ $store->banner ?: $store->logo }}')"></div>
                        @else
                            <div class="store-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                        @endif
                        
                        <div class="store-info">
                            <!-- Store Profile Picture -->
                            @if($store->logo)
                                <div class="store-profile" style="position: absolute; top: -20px; left: 15px; width: 40px; height: 40px; border-radius: 50%; overflow: hidden; border: 3px solid white; background: white;">
                                    <img src="{{ $store->logo }}" alt="{{ $store->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div style="margin-top: 25px;"></div>
                            @endif
                            
                            <div class="store-name">{{ $store->name }}</div>
                            @if($store->tags && count($store->tags) > 0)
                                <div class="store-category">{{ implode(', ', array_slice($store->tags, 0, 2)) }}</div>
                            @endif
                            <div class="store-description">{{ $store->description ? Str::limit($store->description, 80) : 'Welcome to our store!' }}</div>
                            <a href="{{ route('store.show', $store->handle) }}" class="visit-btn">Visit Store</a>
                        </div>
                    </div>
                @empty
                    <div class="no-results">
                        <div style="text-align: center; padding: 60px 20px;">
                            <i class="fas fa-store" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                            <h3 style="margin-bottom: 10px;">No Stores Available</h3>
                            <p style="color: #666;">There are currently no active stores to display.</p>

                        </div>
                    </div>
                @endforelse
        </div>
    </div>

    <script>
        // Search Functionality
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        const storesContainer = document.getElementById('storesContainer');
        const storeCards = document.querySelectorAll('.store-card');

        searchInput.addEventListener('input', () => {
            filterStores(searchInput.value);
        });

        searchBtn.addEventListener('click', () => {
            filterStores(searchInput.value);
        });

        // Search Filter Function
        function filterStores(searchTerm) {
            let hasResults = false;

            storeCards.forEach(card => {
                const matchesSearch = searchTerm === '' ||
                                    card.dataset.search.toLowerCase().includes(searchTerm.toLowerCase());

                if (matchesSearch) {
                    card.style.display = 'block';
                    hasResults = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show no results message if needed
            const noResults = document.getElementById('noResults');
            if (!hasResults && searchTerm !== '') {
                if (!noResults) {
                    const noResultsDiv = document.createElement('div');
                    noResultsDiv.id = 'noResults';
                    noResultsDiv.className = 'no-results';
                    noResultsDiv.textContent = 'No stores match your search criteria.';
                    storesContainer.appendChild(noResultsDiv);
                }
            } else if (noResults) {
                noResults.remove();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dbTheme = "{{ auth()->user()->theme }}";
            if (dbTheme) {
                applyTheme(dbTheme);
                localStorage.setItem('theme', dbTheme);
            }
        });

        function applyTheme(theme) {
            const html = document.documentElement;
            html.classList.remove('light', 'dark');
            html.classList.add(theme);
        }
    </script>
</body>
</x-store-layout>
