<script lang="ts">
    import {Table, BedDouble, Calendar, SquareChartGantt, Users, Anchor, type Icon, Home, Utensils, BookOpen, Settings} from 'lucide-svelte';
    import Menu from '../components/Menu.svelte';
    import Tables from '../pages/Tables.svelte';
    import { type ComponentType } from 'svelte';

    interface Page {
      label: string,
      component?: ComponentType;
      icon: ComponentType<Icon>
    }

    const pages: Page[] = [
      {
        component: Tables,
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
  
<div class="flex flex-row h-full">
    <Menu />

    <div class="flex-1 overflow-hidden p-3">
    {#if selectedPage}
        <div class="overflow-hidden h-full"><svelte:component this={selectedPage.component}></svelte:component></div>
    {:else}
      <div class="grid grid-cols-3 grid-rows-4 gap-3 h-full">
        {#each pages as page}
            <button type="button" class="group rounded-xl border bg-white gap-2 justify-center active:bg-blue-500" on:click={() => selectedPage = page}>
                <div class="inline-block rounded-full p-4 bg-blue-600 group-active:bg-white group-active:text-blue-600 text-white">
                    <svelte:component this={page.icon} />
                </div>
                <div class="font-semibold text-xl group-active:text-white">
                    {page.label}
                </div>
            </button>
        {/each}
      </div>
    {/if}
  </div>
</div>