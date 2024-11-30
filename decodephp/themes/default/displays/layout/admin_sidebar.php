<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <nav class="w-64 bg-white shadow-sm fixed h-full">
        <div class="px-4 py-5">
            <div class="flex items-center">
                <span class="text-lg font-semibold">Admin Panel</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="px-4 py-2">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</div>
            <a href="<?= BASE_PATH ?>/admin" 
               class="mt-3 flex items-center px-4 py-2 text-gray-600 <?= $display->active_page === 'dashboard' ? 'bg-gray-100' : 'hover:bg-gray-100' ?> rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <a href="<?= BASE_PATH ?>/admin/users" 
               class="mt-3 flex items-center px-4 py-2 text-gray-600 <?= $display->active_page === 'users' ? 'bg-gray-100' : 'hover:bg-gray-100' ?> rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Users
            </a>
            <a href="<?= BASE_PATH ?>/admin/roles" 
               class="mt-3 flex items-center px-4 py-2 text-gray-600 <?= $display->active_page === 'roles' ? 'bg-gray-100' : 'hover:bg-gray-100' ?> rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Roles
            </a>
        </div>

        <div class="px-4 py-2 mt-4">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">System</div>
            <a href="<?= BASE_PATH ?>/admin/settings" 
               class="mt-3 flex items-center px-4 py-2 text-gray-600 <?= $display->active_page === 'settings' ? 'bg-gray-100' : 'hover:bg-gray-100' ?> rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </a>
        </div>
    </nav>
</div> 