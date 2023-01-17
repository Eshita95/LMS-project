<div>
    <h2>Information</h2>
    <p>Invoice to:{{ $invoice->user->name }}</p>

    <table class="table-auto w-full mt-4">
        <tr>
            <th class="border px-4 py-2 text-left">Name</th>
            <th class="border px-4 py-2 ">Price</th>
            <th class="border px-4 py-2 ">Quantity</th>
            <th class="border px-4 py-2 text-right">Total</th>
        </tr>

        @foreach ($invoice->items as $item)
            <tr>
                <td class="border px-4 py-2 text-left">{{ $item->name }}</td>
                <td class="border px-4 py-2 text-center">${{ number_format($item->price, 2) }}</td>
                <td class="border px-4 py-2 text-center">{{ $item->quantity }}</td>
                <td class="border px-4 py-2 text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
        @endforeach
    </table>

    @if ($enableAddItem)
        <form class="mt-4" wire:submit.prevent="saveNewItem">
            <div class="flex mb-4">
                <div class="w-full">
                    @include('components.form-field', [
                        'name' => 'name',
                        'label' => 'Name',
                        'type' => 'text',
                        'placeholder' => 'Item name',
                        'required' => 'required',
                    ])
                </div>

                <div class="min-w-max ml-4">
                    @include('components.form-field', [
                        'name' => 'price',
                        'label' => 'Price',
                        'type' => 'number',
                        'placeholder' => 'Type price',
                        'required' => 'required',
                    ])
                </div>

                <div class="min-w-max ml-4">
                    @include('components.form-field', [
                        'name' => 'quantity',
                        'label' => 'Quantity',
                        'type' => 'number',
                        'placeholder' => 'Type quantity',
                        'required' => 'required',
                    ])
                </div>
            </div>
            <div class="flex">
                @include('components.wire-loading-btn')
                <button class="ml-4" wire:click="addNewItem" type="button">Cancel</button>
            </div>
        </form>
    @else
        <h2 class="font-bold mt-4">Add New Item</h2>
        <button wire:click="addNewItem" class="underline mt-2">Add</button>
    @endIf
</div>
