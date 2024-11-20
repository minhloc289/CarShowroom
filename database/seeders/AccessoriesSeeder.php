<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accessories;

class AccessoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Sản phẩm có sẵn
            [
                'name' => 'Gối tựa lưng xe hơi massage điện',
                'price' => 450000,
                'description' => 'Gối tựa lưng massage điện, êm ái, thoải mái, bền đẹp, an toàn.',
                'image_url' => 'https://phukienxedep.com/wp-content/uploads/2017/08/goi-tua-lung-massage-600x600.jpg',
                'category' => 'Nội thất',
                'status' => 'Available',
            ],
            [
                'name' => 'Thảm chống nóng taplo cho xe ô tô',
                'price' => 300000,
                'description' => 'Thảm chống nóng taplo, bảo vệ taplo khỏi ánh nắng mặt trời, tăng tuổi thọ cho xe.',
                'image_url' => 'https://phukienxedep.com/wp-content/uploads/2017/05/tham-chong-nong-taplo-cho-xe-zinger-600x600.jpg',
                'category' => 'Nội thất',
                'status' => 'Available',
            ],
            [
                'name' => 'Rèm che nắng ô tô cuộn thông minh',
                'price' => 250000,
                'description' => 'Rèm che nắng cuộn thông minh, đa dạng kích thước, lắp đặt dễ dàng.',
                'image_url' => 'https://phukienxedep.com/wp-content/uploads/2020/09/rem-che-nang-o-to-theo-xe-range-rover-velar-600x600.jpg',
                'category' => 'Nội thất',
                'status' => 'Out of stock',
            ],
            [
                'name' => 'Đất sét tẩy bụi sơn 3M cho ô tô',
                'price' => 150000,
                'description' => 'Đất sét tẩy bụi sơn 3M, dễ dàng vệ sinh, loại bỏ các loại bụi bẩn trên bề mặt xe.',
                'image_url' => 'https://phukienxedep.com/wp-content/uploads/2018/12/dat-set-tay-bui-son-1-600x600.jpg',
                'category' => 'Chăm sóc xe',
                'status' => 'Available',
            ],
            [
                'name' => 'Ví da đựng giấy tờ ô tô',
                'price' => 200000,
                'description' => 'Ví da tiện lợi, thiết kế đẹp, nhiều ngăn, giúp lưu trữ giấy tờ xe gọn gàng.',
                'image_url' => 'https://phukienxedep.com/wp-content/uploads/2019/06/vi-da-dung-dang-kiem-600x600.jpg',
                'category' => 'Nội thất',
                'status' => 'Available',
            ],
            // Sản phẩm mới
            [
                'name' => 'Bạt phủ xe ô tô chống nắng mưa',
                'price' => 500000,
                'description' => 'Bạt phủ xe chống nắng mưa, bảo vệ xe khỏi tác động của thời tiết, chất liệu bền bỉ.',
                'image_url' => 'https://thegioidochoioto.vn/upload/images/sanpham/san-pham-khac/bat-phu-xe-o-to-cao-cap/bat-phu-xe-o-to-cao-cap-1.jpg',
                'category' => 'Ngoại thất',
                'status' => 'Available',
            ],
            [
                'name' => 'Khăn lau xe ô tô đa năng siêu thấm kích thước 30cm x 30cm',
                'price' => 10000,
                'description' => 'Khăn lau đa năng, siêu thấm, kích thước 30cm x 30cm, phù hợp cho việc vệ sinh nội thất xe.',
                'image_url' => 'https://www.cavaha.com/wp-content/uploads/2021/09/khan-lau-xe5-min.jpg',
                'category' => 'Chăm sóc xe',
                'status' => 'Available',
            ],
            [
                'name' => 'Viên sủi rửa kính ô tô',
                'price' => 100000,
                'description' => 'Viên sủi rửa kính, tẩy sạch kính, 1 viên pha 4 lít nước, thân thiện môi trường.',
                'image_url' => 'https://sieuthihuydung.com/storage/sieuthihuydungcom/3517/7hwgyv7z.jpg',
                'category' => 'Chăm sóc xe',
                'status' => 'Available',
            ],
            [
                'name' => 'Gối tựa đầu xe hơi cao cấp',
                'price' => 250000,
                'description' => 'Gối tựa đầu cao cấp, chất liệu mềm mại, hỗ trợ cổ và đầu, tăng sự thoải mái khi lái xe.',
                'image_url' => 'https://phukienxe.shop/wp-content/uploads/2024/07/1-768x768.avif',
                'category' => 'Nội thất',
                'status' => 'Out of stock',
            ],
            [
                'name' => 'Cánh lướt gió đuôi xe thể thao',
                'price' => 1200000,
                'description' => 'Cánh lướt gió đuôi xe, thiết kế thể thao, tăng tính khí động học và thẩm mỹ cho xe.',
                'image_url' => 'https://tuning.vn/uploadImages/2021/canh-luot-gio-o-to-dep%20(10).jpg',
                'category' => 'Ngoại thất',
                'status' => 'Available',
            ],
        ];

        foreach ($products as $product) {
            // Kiểm tra nếu sản phẩm đã tồn tại dựa trên 'name'
            if (!Accessories::where('name', $product['name'])->exists()) {
                Accessories::create($product);
            }
        }
    }
}
