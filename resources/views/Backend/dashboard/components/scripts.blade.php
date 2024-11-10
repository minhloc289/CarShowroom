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
