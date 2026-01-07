<!-- Sidebar -->
<div id="application-sidebar"
    class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 left-0 bottom-0 z-[60] w-64 bg-white border-r border-gray-200 pt-7 pb-10 overflow-y-auto scrollbar-y lg:block lg:translate-x-0 lg:right-auto lg:bottom-0 dark:scrollbar-y dark:bg-gray-800 dark:border-gray-700">
    <div class="px-6">
        <a class="flex-none text-xl font-semibold dark:text-white" href="{{ route('admin.index') }}"
            aria-label="{{ setting('site_name', 'Octosync Software Ltd') }}">
            {{ setting('site_name', 'Octosync Software Ltd') }}
        </a>
    </div>

    <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
        <ul class="space-y-1.5">
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white
                {{ in_array(Route::currentRouteName(), ['admin.index', '']) ? 'bg-gray-200 dark:bg-gray-900' : 'text-slate-700' }}"
                    href="{{ route('admin.index') }}">
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd"
                            d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg>
                    Dashboard
                </a>
            </li>
            @can('orders_manage')
                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white
                {{ in_array(Route::currentRouteName(), ['admin.orders.index', 'admin.orders.show', 'admin.orders.edit']) ? 'bg-gray-200 dark:bg-gray-900' : 'text-slate-700' }}"
                        href="{{ route('admin.orders.index') }}">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                        Orders
                    </a>
                </li>
            @endcan
            @can('reports_view')
                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white
                {{ in_array(Route::currentRouteName(), ['admin.reports.sales']) ? 'bg-gray-200 dark:bg-gray-900' : 'text-slate-700' }}"
                        href="{{ route('admin.reports.sales') }}">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M0 0h1v15h15v1H0V0zm13.5 3a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h11zM2 7h2v7H2V7zm3 3h2v4H5V10zm3-2h2v6H8V8zm3-4h2v10h-2V4z" />
                        </svg>
                        Sales Report
                    </a>
                </li>
            @endcan
            @can('reviews_manage')
                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white
                {{ in_array(Route::currentRouteName(), ['admin.reviews.index', 'admin.reviews.show']) ? 'bg-gray-200 dark:bg-gray-900' : 'text-slate-700' }}"
                        href="{{ route('admin.reviews.index') }}">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M8 0a8 8 0 1 0 16 0A8 8 0 0 0 8 0zm3.993 6.331l-4.39 4.39a.25.25 0 0 1-.354 0l-2.39-2.39a.25.25 0 1 1 .354-.354l2.163 2.163 4.163-4.163a.25.25 0 1 1 .354.354z" />
                        </svg>
                        Reviews
                    </a>
                </li>
            @endcan
            @can('products_manage')

                <li class="hs-accordion {{ in_array(Route::currentRouteName(), [
                    'admin.products.index',
                    'admin.products.create',
                    'admin.products.edit',
                    'admin.products.show',
                    'admin.products.trash',
                    'admin.categories.index',
                    'admin.categories.create',
                    'admin.categories.edit',
                    'admin.categories.show',
                    'admin.categories.trash',
                    'admin.brands.index',
                    'admin.brands.create',
                    'admin.brands.edit',
                    'admin.brands.show',
                    'admin.brands.trash',
                    'admin.deals.index',
                    'admin.deals.create',
                    'admin.deals.edit',
                    'admin.deals.products.show',
                    'admin.attributes.index',
                    'admin.attributes.create',
                    'admin.attributes.edit',
                    'admin.attributes.show',
                ])
                    ? 'hs-accordion-active'
                    : '' }}"
                    id="products-accordion">
                    <a class="hs-accordion-toggle flex items-center gap-x-3.5 py-2 px-2.5 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white"
                        href="javascript:;">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M5 4a.5.5 0 0 0-.496.438l-.5 4A.5.5 0 0 0 4.5 9h3v2.016c-.863.055-1.5.251-1.5.484 0 .276.895.5 2 .5s2-.224 2-.5c0-.233-.637-.429-1.5-.484V9h3a.5.5 0 0 0 .496-.562l-.5-4A.5.5 0 0 0 11 4H5zm2 3.78V5.22c0-.096.106-.156.19-.106l2.13 1.279a.125.125 0 0 1 0 .214l-2.13 1.28A.125.125 0 0 1 7 7.78z" />
                            <path
                                d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                        </svg>
                        Products

                        <svg class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>

                        <svg class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                    </a>

                    <div id="products-accordion-sub"
                        class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ in_array(Route::currentRouteName(), [
                            'admin.products.index',
                            'admin.products.create',
                            'admin.products.edit',
                            'admin.products.show',
                            'admin.products.trash',
                            'admin.categories.index',
                            'admin.categories.create',
                            'admin.categories.edit',
                            'admin.categories.show',
                            'admin.categories.trash',
                            'admin.brands.index',
                            'admin.brands.create',
                            'admin.brands.edit',
                            'admin.brands.show',
                            'admin.brands.trash',
                            'admin.deals.index',
                            'admin.deals.create',
                            'admin.deals.edit',
                            'admin.deals.products.show',
                            'admin.attributes.index',
                            'admin.attributes.create',
                            'admin.attributes.edit',
                            'admin.attributes.show',
                        ])
                            ? 'block'
                            : 'hidden' }}">
                        <ul class="pt-2 pl-2">
                            @can('products_manage')
                                <li>
                                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                        {{ in_array(Route::currentRouteName(), [
                            'admin.products.index',
                            'admin.products.create',
                            'admin.products.edit',
                            'admin.products.show',
                            'admin.products.trash',
                        ])
                            ? 'bg-gray-200 dark:bg-gray-900'
                            : 'text-slate-700' }}"
                                        href="{{ route('admin.products.index') }}">
                                        Products
                                    </a>
                                </li>
                            @endcan
                            @can('categories_manage')
                                <li>
                                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                        {{ in_array(Route::currentRouteName(), [
                            'admin.categories.index',
                            'admin.categories.create',
                            'admin.categories.edit',
                            'admin.categories.show',
                            'admin.categories.trash',
                        ])
                            ? 'bg-gray-200 dark:bg-gray-900'
                            : 'text-slate-700' }}"
                                        href="{{ route('admin.categories.index') }}">
                                        Categories
                                    </a>
                                </li>
                            @endcan
                            @can('brands_manage')
                                <li>
                                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                        {{ in_array(Route::currentRouteName(), [
                            'admin.brands.index',
                            'admin.brands.create',
                            'admin.brands.edit',
                            'admin.brands.show',
                            'admin.brands.trash',
                        ])
                            ? 'bg-gray-200 dark:bg-gray-900'
                            : 'text-slate-700' }}"
                                        href="{{ route('admin.brands.index') }}">
                                        Brands
                                    </a>
                                </li>
                            @endcan
                            @can('deals_manage')
                                <li>
                                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                                    {{ in_array(Route::currentRouteName(), [
                                        'admin.deals.index',
                                        'admin.deals.create',
                                        'admin.deals.edit',
                                        'admin.deals.products.show',
                                    ])
                                        ? 'bg-gray-200 dark:bg-gray-900'
                                        : 'text-slate-700' }}"
                                        href="{{ route('admin.deals.index') }}">
                                        Deals
                                    </a>
                                </li>
                            @endcan
                            @can('attributes_manage')
                                <li>
                                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                                    {{ in_array(Route::currentRouteName(), [
                                        'admin.attributes.index',
                                        'admin.attributes.create',
                                        'admin.attributes.edit',
                                        'admin.attributes.show',
                                    ])
                                        ? 'bg-gray-200 dark:bg-gray-900'
                                        : 'text-slate-700' }}"
                                        href="{{ route('admin.attributes.index') }}">
                                        Attributes
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcan
            @can('finance_manage')
                <li class="hs-accordion {{ in_array(Route::currentRouteName(), [
                    'admin.expense-categories.index',
                    'admin.expense-categories.create',
                    'admin.expense-categories.edit',
                    'admin.expenses.index',
                    'admin.expenses.create',
                    'admin.expenses.show',
                    'admin.expenses.edit',
                ])
                    ? 'hs-accordion-active'
                    : '' }}"
                    id="settings-accordion">
                    <a class="hs-accordion-toggle flex items-center gap-x-3.5 py-2 px-2.5 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white"
                        href="javascript:;">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M2 2.5A.5.5 0 0 1 2.5 2h11a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11zm1 .5v10h10V3H3zm2 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                        </svg>
                        Finances
                        <svg class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                        <svg class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                    </a>
                    <div id="settings-accordion-sub"
                        class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ in_array(Route::currentRouteName(), [
                            'admin.expense-categories.index',
                            'admin.expense-categories.create',
                            'admin.expense-categories.edit',
                            'admin.expenses.index',
                            'admin.expenses.create',
                            'admin.expenses.show',
                            'admin.expenses.edit',
                        ])
                            ? 'block'
                            : 'hidden' }}">
                        <ul class="pt-2 pl-2">
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                                    {{ in_array(Route::currentRouteName(), [
                                        'admin.expenses.index',
                                        'admin.expenses.create',
                                        'admin.expenses.show',
                                        'admin.expenses.edit',
                                    ])
                                        ? 'bg-gray-200 dark:bg-gray-900'
                                        : 'text-slate-700' }}"
                                    href="{{ route('admin.expenses.index') }}">
                                    Expenses
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                                    {{ in_array(Route::currentRouteName(), [
                                        'admin.expense-categories.index',
                                        'admin.expense-categories.create',
                                        'admin.expense-categories.edit',
                                    ])
                                        ? 'bg-gray-200 dark:bg-gray-900'
                                        : 'text-slate-700' }}"
                                    href="{{ route('admin.expense-categories.index') }}">
                                    Expenses Categories
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan
            @can('settings_manage')
                <li class="hs-accordion {{ in_array(Route::currentRouteName(), [
                    'admin.settings.index',
                    'admin.carousels.index',
                    'admin.carousels.create',
                    'admin.carousels.edit',
                    'admin.settings.homepage-sections',
                ])
                    ? 'hs-accordion-active'
                    : '' }}"
                    id="settings-accordion">
                    <a class="hs-accordion-toggle flex items-center gap-x-3.5 py-2 px-2.5 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white"
                        href="javascript:;">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1c.895.264 1.318 1.285.872 2.105l-.169.31c-.699 1.282.704 2.685 1.987 1.987l.31-.169c.82-.446 1.841-.023 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311c-.446-.82-.023-1.841.872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1c-.895-.264-1.318-1.285-.872-2.105l.169-.31c.699-1.282-.704-2.685-1.987-1.987l-.31.169c-.82.446-1.841.023-2.105-.872l-.1-.34zM8 5.5a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5z" />
                        </svg>
                        Settings
                        <svg class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                        <svg class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                    </a>
                    <div id="settings-accordion-sub"
                        class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ in_array(Route::currentRouteName(), ['admin.settings.index', 'admin.carousels.index', 'admin.carousels.create', 'admin.carousels.edit', 'admin.settings.homepage-sections']) ? 'block' : 'hidden' }}">
                        <ul class="pt-2 pl-2">
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                                    {{ in_array(Route::currentRouteName(), ['admin.settings.index']) ? 'bg-gray-200 dark:bg-gray-900' : 'text-slate-700' }}"
                                    href="{{ route('admin.settings.index') }}">
                                    General
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                                    {{ in_array(Route::currentRouteName(), ['admin.settings.homepage-sections']) ? 'bg-gray-200 dark:bg-gray-900' : 'text-slate-700' }}"
                                    href="{{ route('admin.settings.homepage-sections') }}">
                                    Hero Layout
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                                    {{ in_array(Route::currentRouteName(), ['admin.carousels.index', 'admin.carousels.create', 'admin.carousels.edit']) ? 'bg-gray-200 dark:bg-gray-900' : 'text-slate-700' }}"
                                    href="{{ route('admin.carousels.index') }}">
                                    Carousels
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan

            @can('subscribers_manage')
                <li class="hs-accordion {{ in_array(Route::currentRouteName(), ['admin.subscribers.index', 'admin.subscribers.create', 'admin.subscribers.edit']) ? 'hs-accordion-active' : '' }}"
                    id="marketing-accordion">
                    <a class="hs-accordion-toggle flex items-center gap-x-3.5 py-2 px-2.5 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white"
                        href="javascript:;">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm14.5-.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v.637l6.646 3.973a.5.5 0 0 0 .708 0L14.5 4.637V3.5zM14.5 5.803l-4.646 2.773L14.5 11V5.803zM1.5 11l4.646-2.424L1.5 5v6zM13.793 12H2.207l4.646-3.232L8 9.982l1.146-.714L13.793 12z" />
                        </svg>
                        Marketing

                        <svg class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                        <svg class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                    </a>
                    <div id="marketing-accordion-sub"
                        class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ in_array(Route::currentRouteName(), ['admin.subscribers.index', 'admin.subscribers.create', 'admin.subscribers.edit']) ? 'block' : 'hidden' }}">
                        <ul class="pt-2 pl-2">
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                                    {{ in_array(Route::currentRouteName(), ['admin.subscribers.index', 'admin.subscribers.create', 'admin.subscribers.edit']) ? 'bg-gray-200 dark:bg-gray-900' : 'text-slate-700' }}"
                                    href="{{ route('admin.subscribers.index') }}">
                                    Subscribers
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan

            @can('accounts_manage')
                <li class="hs-accordion {{ in_array(Route::currentRouteName(), [
                    'admin.role',
                    'admin.role.createPage',
                    'admin.role.edit',
                    'admin.permission',
                    'admin.permission.createPage',
                    'admin.permission.edit',
                    'admin.user',
                    'admin.users.create',
                    'admin.users.show',
                ])
                    ? 'hs-accordion-active'
                    : '' }}"
                    id="account-accordion">
                    <a class="hs-accordion-toggle flex items-center gap-x-3.5 py-2 px-2.5 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white"
                        href="javascript:;">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>
                        Account

                        <svg class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>

                        <svg class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                    </a>

                    <div id="account-accordion-sub"
                        class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ in_array(Route::currentRouteName(), ['admin.role', 'admin.role.createPage', 'admin.role.edit', 'admin.permission', 'admin.permission.createPage', 'admin.permission.edit', 'admin.user', 'admin.users.create', 'admin.users.show']) ? 'block' : 'hidden' }}">
                        <ul class="pt-2 pl-2">
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                                    {{ in_array(Route::currentRouteName(), ['admin.role', 'admin.role.createPage', 'admin.role.edit']) ? 'bg-gray-200 dark:bg-gray-900' : 'text-slate-700' }}"
                                    href="{{ route('admin.role') }}">
                                    Roles
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                                    {{ in_array(Route::currentRouteName(), ['admin.permission', 'admin.permission.createPage', 'admin.permission.edit']) ? 'bg-gray-200 dark:bg-gray-900' : 'text-slate-700' }}"
                                    href="{{ route('admin.permission') }}">
                                    Permissions
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white 
                                    {{ in_array(Route::currentRouteName(), ['admin.user', 'admin.users.create', 'admin.users.show']) ? 'bg-gray-200 dark:bg-gray-900' : 'text-slate-700' }}"
                                    href="{{ route('admin.user') }}">
                                    Users
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan
            
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-white"
                    href="https://docs.google.com/document/d/{{ env('APP_USER_MANUAL_ID') }}/preview"
                    target="_blank">
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M4.5 1A1.5 1.5 0 0 0 3 2.5v11A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-11A1.5 1.5 0 0 0 11.5 1h-7zM4 2.5A.5.5 0 0 1 4.5 2h7a.5.5 0 0 1 .5.5V4H4V2.5zm7 .75V14a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5V6h8v-.75z" />
                        <path
                            d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 .875-.252 1.02-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.126-.304-.464l.216-1 .645-.08c.294-.036.352-.176.288-.47l-.545-2.56c-.07-.33-.304-.42-.614-.384z" />
                        <circle cx="8" cy="4.496" r="1" />
                    </svg>
                    User Manual
                </a>
            </li>

            @role('admin')
            @endrole
        </ul>
    </nav>
</div>
<!-- End Sidebar -->
