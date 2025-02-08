<script lang="ts">
    import {main} from 'wailsjs/go/models';
    import {GetTables} from 'wailsjs/go/main/App.js'
    import Table from './Table.svelte';

    let tables:main.Table[] = []
    GetTables().then(data => {
        tables = data
        //selectedTable = tables[0]
    })

    let selectedTable:main.Table|null = null
</script>

<div class="h-full overflow-hidden bg-white p-3 border rounded-xl">
    {#if selectedTable}
    <Table table={selectedTable} />
    {:else}
        <div class="flex justify-between gap-2">
            <div class="flex text-xl gap-2 font-semibold flex-1">Tables</div>
        </div>
        <div class="grid grid-cols-3 gap-3 h-full auto-rows-min">
            {#each tables as table}
                <div class="border border border-black-100 rounded-xl overflow-hidden bg-white cursor-pointer h-[150px] flex" on:click={() => {selectedTable = table}}>
                    <div class="w-[10px] bg-blue-600"></div>
                    <div class="flex-1 p-3 text-lg font-medium">
                        {table.Name}
                    </div>
                </div>
            {/each}
        </div>
    {/if}
</div>