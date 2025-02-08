<script lang="ts">
    import dayjs from 'dayjs';
    import { GetTableActiveOrder } from 'wailsjs/go/main/App';
    import {main} from 'wailsjs/go/models';
    export let table:main.Table

    let order:main.Order

    GetTableActiveOrder(table.Id).then(data => {
        order = data
    }).catch(e => {
        console.log('error', e)
    })

</script>



<div class="flex h-full gap-2">
    <div class="w-[65%] flex flex-col overflow-hidden gap-4">
        <div class="flex justify-between ">
            <div class="font-semibold text-lg">Order Tabs</div>
            <button type="button" class="rounded-lg bg-blue-600 text-white px-4 py-2">+ Add New Order Tab</button>
        </div>
        <div class="flex flex-col gap-4 overflow-auto flex-1">
            {#each order?.OrderTabs || [] as orderTab}
                <div class="border rounded-2xl p-3 h-max">
                    <div class="text-xs font-light opacity-50 mb-3">
                        <div class="flex justify-between">
                            <div>ORDER TAB ID</div>
                            <div>{orderTab.Id}</div>
                        </div>
                        <div class="flex justify-between">
                            <div>PLACED ON</div>
                            <div>{dayjs(orderTab.CreatedAt).format('YYYY-MM-DD h:m A')}</div>
                        </div>
                    </div>

                    <table class="w-full leading-relaxed" cellpadding="0" cellspacing="0">
                        <thead class="opacity-50">
                            <td>ITEM</td>
                            <td class="text-right w-[30px]">QTY</td>
                            <td class="text-right w-[70px]">PRICE</td>
                        </thead>
                        <tbody>
                            {#each orderTab.OrderTabMenuItems || [] as orderTabMenuItem}
                            <tr>
                                <td>{orderTabMenuItem.Name}</td>
                                <td class="text-right">{orderTabMenuItem.Quantity}</td>
                                <td class="text-right">{orderTabMenuItem.Price.toFixed(2)}</td>
                            </tr>
                            {/each}
                        </tbody>
                    </table>
                </div>
            {/each}
        </div>
    </div>
    <div class="flex-1 bg-gray-100 p-4 rounded-lg">
        <div class="font-semibold text-lg">Order Summary</div>
    </div>
</div>

