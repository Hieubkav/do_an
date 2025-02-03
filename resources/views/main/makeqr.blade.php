@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-8">
        <form action="{{route('makeqr_payment_momo_qr')}}" method="POST" id="napTienForm" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tongTien">
                    Tổng tiền muốn nạp
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="tongTien" type="number" placeholder="Nhập số tiền" name="total_price">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phi">
                    Phí (1.1%)
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-red-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="phi" type="text" disabled>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tienNhanDuoc">
                    Tiền nhận được
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-green-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="tienNhanDuoc" type="text" disabled>
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit" disabled>
                    Nạp Ngay
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var inputTongTien = document.getElementById("tongTien");
            var inputPhi = document.getElementById("phi");
            var inputTienNhanDuoc = document.getElementById("tienNhanDuoc");
            var btnNapNgay = document.querySelector("button[type='submit']");

            inputTongTien.addEventListener("input", function() {
                var tongTien = parseFloat(inputTongTien.value);
                if (!isNaN(tongTien) && tongTien > 0) {
                    var phi = tongTien * 0.011;
                    var tienNhanDuoc = tongTien - phi;

                    inputPhi.value = phi.toFixed(2) + " VND";
                    inputTienNhanDuoc.value = tienNhanDuoc.toFixed(2) + " VND";

                    btnNapNgay.disabled = false;
                    btnNapNgay.classList.remove("bg-gray-500");
                    btnNapNgay.classList.add("bg-green-500");
                } else {
                    inputPhi.value = "";
                    inputTienNhanDuoc.value = "";

                    btnNapNgay.disabled = true;
                    btnNapNgay.classList.add("bg-gray-500");
                    btnNapNgay.classList.remove("bg-green-500");
                }
            });
        });
    </script>
@endsection
