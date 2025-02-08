<script lang="ts">
    import ServerTime from "./ServerTime.svelte";
    import { Gauge, Power } from "lucide-svelte";
    import {User} from "lucide-svelte";
    import {Table, BedDouble, Calendar, SquareChartGantt, Users, Anchor, type Icon, Home, Utensils, BookOpen, Settings} from 'lucide-svelte';
    import { type ComponentType } from 'svelte';


    interface Page {
      label: string,
      component?: ComponentType;
      icon: ComponentType<Icon>
    }

    const pages: Page[] = [
      {
        label: 'Gauge',
        icon: Gauge
      },
      {
        label: 'Tables',
        icon: Table
      },
      {
        label: 'Rooms',
        icon: BedDouble
      },
      {
        label: 'Orders',
        icon: Utensils
      },
      {
        label: 'Gears Rental',
        icon: Anchor
      },
      {
        label: 'Guests',
        icon: Users
      },
      {
        label: 'Menu',
        icon: BookOpen
      },
      {
        label: 'Calendar',
        icon: Calendar
      },
      {
        label: 'Reports',
        icon: SquareChartGantt
      },
      {
        label: 'Settings',
        icon: Settings
      },
    ]

    let selectedPage:Page|null = null
</script>

<div class="h-full border-r bg-blue-600 gap-4 flex flex-col overflow-auto">

    <button type="button" class="rounded-full bg-blue-600 p-2 text-white flex items-center">
        <User  />
    </button>

    <div class="flex-1 flex gap-1 flex-col justify-center">
        {#each pages as page}
        <button type="button" class="menu-item group w-14 h-14 flex items-center justify-center" class:active={selectedPage === page} on:click={() => selectedPage = page}>
                <svelte:component this={page.icon} class="text-white" />
            <!-- <div class="font-semibold text-xl group-active:text-white">
                {page.label}
            </div> -->
        </button>
        {/each}
    </div>

    <button type="button" class="rounded-full bg-blue-600 p-2 text-white flex items-center">
        <Power  />
    </button>
    
    <!-- <div class="flex flex-col justify-between">
        <button type="button" class="flex gap-2 items-center border bg-white rounded-full px-2 py-2 active:bg-blue-600 group">
            <div class="rounded-full p-1 bg-blue-600 text-white inline-block group-active:text-blue-600 group-active:bg-white">
                <User size=15 />
            </div>
            <div class="flex items-center gap-2">
                <div class="font-medium group-active:text-white">Clyde Escobidal</div><div class="bg-slate-200 px-1 rounded-full text-sm">Cashier</div>
            </div>
        </button>

        <div>
            <ServerTime />
        </div>
    </div> -->
</div>


<style>
    .menu-item {
        @apply relative opacity-60;
        &:hover {
            @apply opacity-100;
        }
        &.active {
            @apply opacity-100;
            &:before {
                content: '';
                @apply w-[8px] h-[70%] bg-white -left-[4px] top-1/2 -translate-y-1/2 absolute rounded;
            }
        }
    }
</style>