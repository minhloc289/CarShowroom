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
                'description' => 'Gối tựa lưng massage điện là sản phẩm lý tưởng để giảm căng thẳng và đau nhức khi lái xe trong thời gian dài. Với thiết kế hiện đại, sản phẩm mang đến sự thoải mái tối đa và hỗ trợ cột sống hiệu quả. Chất liệu cao cấp giúp đảm bảo độ bền, an toàn và dễ dàng vệ sinh. Đây là phụ kiện không thể thiếu cho những ai thường xuyên di chuyển bằng xe hơi.',
                'image_url' => 'https://phukienxedep.com/wp-content/uploads/2017/08/goi-tua-lung-massage-600x600.jpg',
                'category' => 'Nội thất',
                'status' => 'Available',
            ],
            [
                'name' => 'Thảm chống nóng taplo cho xe ô tô',
                'price' => 300000,
                'description' => 'Thảm chống nóng taplo được thiết kế để bảo vệ bề mặt taplo khỏi tác hại của ánh nắng mặt trời và nhiệt độ cao. Sản phẩm không chỉ giúp giảm nhiệt độ trong xe mà còn tăng tuổi thọ của nội thất, mang lại sự an tâm cho người sử dụng. Với chất liệu cao cấp, thảm dễ dàng lắp đặt và vệ sinh, là lựa chọn lý tưởng cho mọi dòng xe hơi.',
                'image_url' => 'https://phukienxedep.com/wp-content/uploads/2017/05/tham-chong-nong-taplo-cho-xe-zinger-600x600.jpg',
                'category' => 'Nội thất',
                'status' => 'Available',
            ],
            [
                'name' => 'Rèm che nắng ô tô cuộn thông minh',
                'price' => 250000,
                'description' => 'Rèm che nắng cuộn thông minh được thiết kế để bảo vệ nội thất xe khỏi ánh nắng gay gắt và tia UV độc hại. Với khả năng tùy chỉnh kích thước, sản phẩm phù hợp với hầu hết các loại xe hơi. Lắp đặt dễ dàng, sử dụng tiện lợi và có độ bền cao, đây là phụ kiện lý tưởng cho những chuyến đi dưới trời nắng nóng.',
                'image_url' => 'https://phukienxedep.com/wp-content/uploads/2020/09/rem-che-nang-o-to-theo-xe-range-rover-velar-600x600.jpg',
                'category' => 'Nội thất',
                'status' => 'Out of stock',
            ],
            [
                'name' => 'Đất sét tẩy bụi sơn 3M cho ô tô',
                'price' => 150000,
                'description' => 'Đất sét tẩy bụi sơn 3M là giải pháp hoàn hảo để loại bỏ các loại bụi bẩn và tạp chất cứng đầu trên bề mặt sơn xe. Với công thức đặc biệt, sản phẩm giúp làm sạch hiệu quả mà không gây trầy xước sơn. Dễ dàng sử dụng và an toàn, đây là phụ kiện không thể thiếu cho việc chăm sóc xe của bạn.',
                'image_url' => 'https://phukienxedep.com/wp-content/uploads/2018/12/dat-set-tay-bui-son-1-600x600.jpg',
                'category' => 'Chăm sóc xe',
                'status' => 'Available',
            ],
            [
                'name' => 'Ví da đựng giấy tờ ô tô',
                'price' => 200000,
                'description' => 'Ví da đựng giấy tờ ô tô với thiết kế sang trọng và tinh tế, là phụ kiện cần thiết cho mọi tài xế. Sản phẩm được làm từ chất liệu da cao cấp, bền đẹp theo thời gian. Với nhiều ngăn tiện lợi, ví giúp bạn lưu trữ giấy tờ xe gọn gàng và dễ dàng tìm kiếm khi cần thiết.',
                'image_url' => 'https://phukienxedep.com/wp-content/uploads/2019/06/vi-da-dung-dang-kiem-600x600.jpg',
                'category' => 'Nội thất',
                'status' => 'Available',
            ],
            // Sản phẩm mới
            [
                'name' => 'Bạt phủ xe ô tô chống nắng mưa',
                'price' => 500000,
                'description' => 'Bạt phủ xe chống nắng mưa là giải pháp hoàn hảo để bảo vệ xe khỏi tác động của thời tiết khắc nghiệt. Sản phẩm được làm từ chất liệu cao cấp, bền bỉ, chống thấm nước và chống tia UV. Dễ dàng sử dụng và gấp gọn khi không cần thiết, bạt phủ giúp giữ xe luôn sạch sẽ và mới mẻ.',
                'image_url' => 'https://thegioidochoioto.vn/upload/images/sanpham/san-pham-khac/bat-phu-xe-o-to-cao-cap/bat-phu-xe-o-to-cao-cap-1.jpg',
                'category' => 'Ngoại thất',
                'status' => 'Available',
            ],
            [
                'name' => 'Khăn lau xe ô tô đa năng siêu thấm kích thước 30cm x 30cm',
                'price' => 10000,
                'description' => 'Khăn lau xe đa năng với khả năng thấm hút vượt trội giúp làm sạch nội thất và ngoại thất xe hiệu quả. Với kích thước 30cm x 30cm, sản phẩm tiện lợi cho việc lau chùi mọi bề mặt. Chất liệu mềm mại, bền bỉ và dễ giặt sạch, khăn lau này là phụ kiện cần thiết cho việc chăm sóc xe hàng ngày.',
                'image_url' => 'https://www.cavaha.com/wp-content/uploads/2021/09/khan-lau-xe5-min.jpg',
                'category' => 'Chăm sóc xe',
                'status' => 'Available',
            ],
            [
                'name' => 'Viên sủi rửa kính ô tô',
                'price' => 100000,
                'description' => 'Viên sủi rửa kính ô tô giúp làm sạch bề mặt kính hiệu quả chỉ với một viên pha 4 lít nước. Sản phẩm thân thiện với môi trường, loại bỏ bụi bẩn, vết dầu mỡ và tăng tầm nhìn khi lái xe. Tiện lợi, tiết kiệm và dễ sử dụng, đây là lựa chọn lý tưởng cho việc vệ sinh kính xe.',
                'image_url' => 'https://sieuthihuydung.com/storage/sieuthihuydungcom/3517/7hwgyv7z.jpg',
                'category' => 'Chăm sóc xe',
                'status' => 'Available',
            ],
            [
                'name' => 'Gối tựa đầu xe hơi cao cấp',
                'price' => 250000,
                'description' => 'Gối tựa đầu cao cấp được thiết kế để hỗ trợ cổ và đầu, mang đến cảm giác thoải mái trong suốt hành trình dài. Sản phẩm được làm từ chất liệu mềm mại, sang trọng và an toàn cho da. Với kiểu dáng tinh tế, gối tựa đầu không chỉ giúp giảm căng thẳng mà còn làm tăng vẻ đẹp cho nội thất xe.',
                'image_url' => 'https://phukienxe.shop/wp-content/uploads/2024/07/1-768x768.avif',
                'category' => 'Nội thất',
                'status' => 'Out of stock',
            ],
            [
                'name' => 'Cánh lướt gió đuôi xe thể thao',
                'price' => 1200000,
                'description' => 'Cánh lướt gió đuôi xe với thiết kế thể thao mang lại tính thẩm mỹ cao và cải thiện khí động học của xe. Sản phẩm được làm từ chất liệu bền đẹp, chịu được mọi điều kiện thời tiết. Dễ dàng lắp đặt, cánh lướt gió này không chỉ tăng sự nổi bật mà còn hỗ trợ hiệu suất khi vận hành xe.',
                'image_url' => 'https://tuning.vn/uploadImages/2021/canh-luot-gio-o-to-dep%20(10).jpg',
                'category' => 'Ngoại thất',
                'status' => 'Available',
            ],
            [
                'name' => 'Đệm hơi ô tô chất nhung êm mịn',
                'price' => 420000,
                'description' => 'Đệm hơi ô tô chất nhung được thiết kế để mang lại sự thoải mái tối đa khi di chuyển hoặc nghỉ ngơi trên xe. Với chất liệu nhung cao cấp, sản phẩm mang đến cảm giác êm ái và sang trọng. Đi kèm với bơm điện và 2 gối tiện lợi, đây là lựa chọn hoàn hảo cho những chuyến đi dài hoặc dã ngoại.',
                'image_url' => 'https://phukiendochoioto.vn/wp-content/uploads/2024/02/dem-hoi-o-to-nam-du-lich-di-choi-cao-cap-3.jpg',
                'category' => 'Nội thất',
                'status' => 'Available',
            ],
            [
                'name' => 'Nút giảm chấn cửa ô tô in logo',
                'price' => 20000,
                'description' => 'Nút giảm chấn cửa ô tô không chỉ giúp giảm tiếng ồn khi đóng mở cửa mà còn bảo vệ cửa xe khỏi va đập. Sản phẩm có thiết kế tinh tế với logo in sắc nét, phù hợp với nhiều loại xe. Được làm từ chất liệu bền chắc, đây là phụ kiện thiết yếu giúp tăng độ bền cho cửa xe.',
                'image_url' => 'https://phukiendochoioto.vn/wp-content/uploads/2024/02/nut-giam-chan-o-to-chong-on-bao-ve-cua-xe-6.jpg',
                'category' => 'Ngoại thất',
                'status' => 'Available',
            ],
            [
                'name' => 'Miếng dán gương kính chống đọng nước',
                'price' => 58000,
                'description' => 'Miếng dán gương kính chống đọng nước giúp tăng tầm nhìn rõ ràng khi lái xe trong điều kiện thời tiết xấu. Sản phẩm được thiết kế với công nghệ chống bám nước hiệu quả, giữ bề mặt gương luôn sạch và sáng. Dễ dàng lắp đặt, miếng dán này là phụ kiện không thể thiếu cho mọi tài xế.',
                'image_url' => 'https://phukiendochoioto.vn/wp-content/uploads/2024/02/mieng-dan-chong-dong-nuoc-chong-bam-nuoc-kinh-xe-4.jpg',
                'category' => 'Ngoại thất',
                'status' => 'Available',
            ],
            [
                'name' => 'Ốp gương chiếu hậu mạ crom',
                'price' => 350000,
                'description' => 'Ốp gương chiếu hậu mạ crom không chỉ làm tăng tính thẩm mỹ mà còn bảo vệ gương chiếu hậu khỏi trầy xước và hư hại. Với chất liệu mạ crom cao cấp, sản phẩm mang lại vẻ ngoài sáng bóng, sang trọng. Lắp đặt dễ dàng và phù hợp với hầu hết các dòng xe hơi.',
                'image_url' => 'https://hongphatauto.com/wp-content/uploads/2019/10/4-27.jpg',
                'category' => 'Ngoại thất',
                'status' => 'Available',
            ],
            [
                'name' => 'Bình xịt bọt đa năng vệ sinh nội thất',
                'price' => 79000,
                'description' => 'Bình xịt bọt đa năng là giải pháp tiện lợi để làm sạch nội thất xe hơi một cách nhanh chóng và hiệu quả. Với khả năng tạo bọt mạnh mẽ, sản phẩm dễ dàng loại bỏ bụi bẩn và vết bẩn cứng đầu. Thân thiện với môi trường và an toàn cho vật liệu nội thất, đây là phụ kiện cần thiết để giữ xe luôn sạch sẽ.',
                'image_url' => 'https://phukiendochoioto.vn/wp-content/uploads/2024/02/binh-xit-ve-sinh-noi-that-o-to-va-gia-dinh-7-768x768.jpg',
                'category' => 'Chăm sóc xe',
                'status' => 'Available',
            ],
            [
                'name' => 'Sáp đánh bóng sơn xe cao cấp',
                'price' => 150000,
                'description' => 'Sáp đánh bóng sơn xe, giúp xe sáng bóng như mới.',
                'image_url' => 'https://bizweb.dktcdn.net/thumb/grande/100/315/474/products/sap-getsun-12.jpg?v=1595565423097',
                'category' => 'Chăm sóc xe',
                'status' => 'Available',
            ],
            [
                'name' => 'Chai xịt dưỡng bóng lốp xe',
                'price' => 60000,
                'description' => 'Chai xịt dưỡng bóng lốp, bảo vệ lốp và tăng tuổi thọ.',
                'image_url' => 'https://phukiendochoioto.vn/wp-content/uploads/2024/02/phu-bong-nano-lam-moi-be-mat-son-o-to-1-768x768.jpg',
                'category' => 'Chăm sóc xe',
                'status' => 'Available',
            ],
        ];

        foreach ($products as $product) {
            // Kiểm tra nếu sản phẩm đã tồn tại dựa trên 'name'
            $existingProduct = Accessories::where('name', $product['name'])->first();
        
            if ($existingProduct) {
                // Nếu sản phẩm tồn tại, cập nhật các thuộc tính
                $existingProduct->update([
                    'price' => $product['price'],
                    'description' => $product['description'],
                    'image_url' => $product['image_url'],
                    'category' => $product['category'],
                    'status' => $product['status'],
                ]);
            } else {
                // Nếu sản phẩm chưa tồn tại, tạo mới
                Accessories::create($product);
            }
        }        
    }
}
