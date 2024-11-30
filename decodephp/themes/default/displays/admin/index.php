<?php
$display->title = 'Admin Dashboard';
$display->active_page = 'admin';
?>

<!-- Main Content -->
<div>
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="px-4 py-6">
            <h1 class="text-2xl font-semibold text-gray-800">Dashboard Overview</h1>
        </div>
    </header>

    <!-- Stats Grid -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Users -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                <dd class="text-lg font-medium text-gray-900"><?= $display->count_users() ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Server Status -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-3 w-3 rounded-full <?= $display->server_status()['status'] === 'Operational' ? 'bg-green-400' : 'bg-red-400' ?>"></div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Server Status</dt>
                                <dd class="text-lg font-medium text-gray-900"><?= $display->server_status()['status'] ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CPU Load -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">CPU Load</dt>
                                <dd class="text-lg font-medium text-gray-900"><?= $display->cpu_load()['load'] ?>%</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Memory Usage -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Memory Usage</dt>
                                <dd class="text-lg font-medium text-gray-900"><?= $display->memory_usage()['percentage'] ?>%</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 