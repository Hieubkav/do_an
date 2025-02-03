<table class="w-full divide-y divide-gray-300">
    <thead class="bg-gray-800">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">STT</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Ảnh</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Tên</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Giá</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Số
                Lượng</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Tổng
                Tiền</th>
        </tr>
    </thead>
    @php
        $stt = 0;
    @endphp
    <tbody class="divide-y divide-gray-200">
        @foreach ($order->order_items as $item)
            @php
                $stt++;
            @endphp
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $stt }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <img class="h-10 w-10 rounded shadow"
                        src="{{ asset('asset/all_pic') }}/{{ $item->color_version_size->color_version_image->image }}"
                        alt="Product Image">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $item->color_version_size->color_version_image->version->product->name }} -
                    {{ $item->color_version_size->color_version_image->version->name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-semibold">
                    {{ number_format($item->price) }} VNĐ
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $item->quantity }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-semibold">
                    {{ number_format($item->price * $item->quantity) }} VNĐ
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
