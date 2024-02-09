@extends('layouts.main')

@section('container')
    <section class="bg-white dark:bg-gray-900 pt-10">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
            <div class="grid md:grid-cols-2 gap-8">
                <div
                    class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 h-max rounded-lg p-8 md:p-12">
                    <h1 class="mb-10 text-2xl font-medium text-gray-900 dark:text-white">Detail pelanggan</h1>
                    <div class="mb-5">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-fuchsia-500 focus:border-fuchsia-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-fuchsia-500 dark:focus:border-fuchsia-500"
                            placeholder="Masukkan nama" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="mb-10">
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No.
                            tlp</label>
                        <input type="text" id="phone"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-fuchsia-500 focus:border-fuchsia-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-fuchsia-500 dark:focus:border-fuchsia-500"
                            placeholder="Masukkan nomor telepon" required>
                    </div>
                    <h1 class="mb-5 text-2xl font-medium text-gray-900 dark:text-white">Metode pembayaran</h1>
                    <div class="h-max">
                        {{-- area pembayaran --}}
                        <div id="snap-container" class="w-full">
                            <p id="pesan" class="text-base font-normal text-center text-gray-500 my-20">Klik bayar
                                terlebih
                                dahulu</p>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 h-max rounded-lg p-8 md:p-12">
                    <h1 class="mb-10 text-2xl font-medium text-gray-900 dark:text-white">Detail pesanan</h1>
                    <div class="flex justify-between mb-5">
                        <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $product->name }}</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-white">× 1</p>
                        <p class="text-lg font-normal text-gray-900 dark:text-white">Rp.
                            {{ number_format($product->price, 0, '.', '.') }}</p>
                    </div>
                    <div class="flex justify-between mb-10">
                        <p class="text-lg font-medium text-gray-900 dark:text-white">Diskon</p>
                        <p class="text-lg font-normal text-gray-900 dark:text-white">(0%) Rp. 0</p>
                    </div>
                    <hr>
                    <div class="flex justify-between mt-2 mb-5">
                        <p class="text-lg font-medium text-gray-900 dark:text-white">Total</p>
                        <p class="text-lg font-normal text-gray-900 dark:text-white">Rp.
                            {{ number_format($product->price, 0, '.', '.') }}</p>
                    </div>
                    <button type="button" id="pay-button"
                        class="text-white bg-fuchsia-600 hover:bg-fuchsia-700 focus:ring-4 focus:ring-fuchsia-200 font-medium rounded-lg text-lg w-full py-2 mt-7 text-center dark:text-white  dark:focus:ring-fuchsia-900">Bayar
                        Sekarang</button>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('scripts')
    {{-- Snap Embed --}}

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        const pesan = document.querySelector('#pesan');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
            // Also, use the embedId that you defined in the div above, here.
            pesan.classList.add('hidden');
            window.snap.embed('{{ $transaction->snap_token }}', {
                embedId: 'snap-container',
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    // alert("payment success!");
                    // console.log(result);
                    window.location.href = '{{ route('home') }}';
                    Swal.fire({
                        title: 'Good job!',
                        text: 'Pembayaran anda telah berhasil!',
                        icon: 'success',
                        confirmButtonText: 'Okay'
                    });
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    // alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            });
        });
    </script>





    {{-- Snap pop-up modal --}}

    {{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $transaction->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script> --}}
@endsection
