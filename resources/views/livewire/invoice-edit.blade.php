<div>
    <h2 class="font-bold text-green-700  ">Information</h2>
    <p>Invoice to: {{ $invoice->user->name }}</p>

    <table class="table-auto w-full mb-4">
        <tr>
            <th class="lms-cell-border text-left">Name</th>
            <th class="lms-cell-border">Price</th>
            <th class="lms-cell-border">Quantity</th>
            <th class="lms-cell-border text-right">Total</th>
        </tr>

        @foreach ($invoice->items as $item)
            <tr>
                <td class="lms-cell-border">{{ $item->name }}</td>
                <td class="lms-cell-border text-center">${{ number_format($item->price, 2) }}</td>
                <td class="lms-cell-border text-center">{{ $item->quantity }}</td>
                <td class="lms-cell-border text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="lms-cell-border text-right">Subtotal</td>
            <td class="lms-cell-border text-right">${{ number_format($invoice->amount()['total'], 2) }}</td>
        </tr>
        <tr>
            <td colspan="3" class="lms-cell-border text-right">Paid</td>
            <td class="lms-cell-border text-right">- ${{ number_format($invoice->amount()['paid'], 2) }}</td>
        </tr>
        <tr>
            <td colspan="3" class="lms-cell-border text-right">Due</td>
            <td class="lms-cell-border text-right">${{ number_format($invoice->amount()['due'], 2) }}</td>
        </tr>
    </table>




    @if ($enableAddItem)
        <form class="mb-4" wire:submit.prevent="saveNewItem">
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
            <div class="flex mb-4">
                @include('components.wire-loading-btn')
                <button class=" bg-red-500 ml-4 py-2 px-4 font-bold text-white " wire:click="addNewItem"
                    type="button">Cancel</button>
            </div>
        </form>
    @else
        <button class="px-4 py-2 rounded bg-blue-400 mt-4 mb-4" wire:click="addNewItem" class="underline">Add New Item</button>
    @endif


    <h3 class="font-bold text-lg mb-2">Payments</h3>
    <ul class="mb-4">
        @foreach ($invoice->payments as $payment)
            <li>{{ date('F j, Y - g:i:a', strtotime($payment->created_at)) }} -
                ${{ number_format($payment->amount, 2) }} - transaction ID: {{ $payment->transaction_id }}</li>
        @endforeach
    </ul>
</div>
