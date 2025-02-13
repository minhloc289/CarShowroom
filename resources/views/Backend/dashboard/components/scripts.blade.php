<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<!--end::Page Vendors Javascript-->
@if (isset($config['js']) && is_array($config['js']))
    @foreach ($config['js'] as $val)
        {!! '<script src="' . asset($val) . '"></script>' !!}
    @endforeach
@endif

<script>
        setInterval(() => {
            fetch('/admin/check-rental-status', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message); // Log thông báo từ server
                    // Bạn có thể thêm logic cập nhật UI tại đây nếu cần
                })
                .catch(error => {
                    console.error('Error checking rental status:', error);
                });
        }, 5000);

        setInterval(() => {
            fetch('/admin/check-order-status', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message); // Log thông báo từ server
                    // Bạn có thể thêm logic để cập nhật UI ở đây nếu cần
                })
                .catch(error => {
                    console.error('Error checking order status:', error);
                });
        }, 5000); // Thời gian 5 giây    

        setInterval(function () {
            $.ajax({
                url: "{{ route('check.payment.status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    console.log(response.message);
                },
                error: function (xhr) {
                    console.error("Lỗi kiểm tra trạng thái:", xhr.responseText);
                }
            });
        }, 5000); // 5000ms = 5s

</script>
